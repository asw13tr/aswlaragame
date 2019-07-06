<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use App\Game;
use App\ConnectGameCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ASWHelper;

class GameController extends Controller{

    protected $coverPath;

    public function __construct(){
        $this->coverPath = asw('path_media_game');
        $this->middleware('panelAccessPermission')->except( ['index', 'create', 'store'] );
    }

    public function index(Request $request){
        $games = Game::orderBy('id', 'desc');
        if( $request->get('s', null) != null ){ $games = $games->where('status', $request->get('s')); }
        if( $request->get('c', null) != null ){
            $catID = $request->get('c');
            $games = $games->whereHas( 'categories', function($q) use($catID){
                $q->where('game_category_id', $catID);
            } );
       }
       if( Auth::user()->level != 3 ){ $games = $games->where('author', Auth::user()->id); }
        $datas = [  'items' => $games->get(), 'headTitle'=>'Oyunlar'   ];
       return view("panel/game/games", $datas);
    }










    public function create(){
        return view('panel/game/game-form', ['headTitle'=>'Yeni oyun ekle']);
    }


    public function store(Request $request){

        $status = false;
        $goUrl = url()->previous();
        if(!$request->get('category',false)){
            setAlertFixed('En az bir tane kategori seçmek zorundasınız.', 'danger');
        }else{
           // POSTTAN GELEN GEÇERLİ TÜM VERİLER VERİTABANINA EKLENİYOR.
           $game = Game::create( $request->all() );

           // SEÇİLEN KATEGORİLER BAĞLANIYOR
           $cats = array();
           foreach( $request->get('category') as $v ){ $cats[] = ['game_id'=>$game->id, 'game_category_id'=>$v]; }
           ConnectGameCategory::insert($cats);

           $cover = ASWHelper::uploadCover($request, $game, null, $this->coverPath);
           $game->update( [
               'cover'=>$cover,
               'allow_comments' => $request->get('allow_comments', 'off'),
               'author'       => Auth::user()->id
               ] );


           // OYUN SWF DOSYASI UPLOAD EDİLİYOR
           $swfName = null;
           if( $swf = $request->file('game_file') ){
               if( $swf->getClientOriginalExtension() != 'swf' ){
                   setAlert('Geçerli bir oyun dosyası seçmediniz. (.swf)', 'danger', 'game_file');
               }else{
                   $swfName = substr($game->slug, 0, 60).'__'.time().'.'.$swf->getClientOriginalExtension();
                   $swf->move( public_path(asw('path_media_game_files')), $swfName );
               }
           }
           $game->update( ['game_file'=>$swfName] );



           setAlertFixed('<strong>'.$game->title.'</strong> oyun eklendi.');
           $status = true;
           $goUrl = route( 'panel.game.edit', ['game'=>$game] );
        }

          return redirect( $goUrl )->with('postStatus', $status);
    }//store










    public function show(Game $game)
    {
        //
    }










    public function edit(Game $game){
        $cats = ConnectGameCategory::where('game_id', $game->id)->get();
        $selectedCategories = array();
        foreach($cats as $c){ $checkedCategories[] = $c->game_category_id; }

        $datas = [ 'data' => $game, 'checkedCategories' => $checkedCategories, 'headTitle'=>'Oyunu düzenle' ];
        return view('panel/game/game-form', $datas);
    }//edit


    public function update(Request $request, Game $game){
        if($request->get('status', 'null')=="trash" && $game->status=="trash"){ return $this->destroy($game); }
        $status = false;
        $goUrl = url()->previous();
        if(!$request->get('category',false)){
            setAlertFixed('En az bir tane kategori seçmek zorundasınız.', 'danger');
        }else{
           // POSTTAN GELEN GEÇERLİ TÜM VERİLER VERİTABANINA EKLENİYOR.
           $oldCoverName = $game->cover;
           $oldSwfName = $game->game_file;
           $game->update( $request->all() );

           // SEÇİLEN KATEGORİLER BAĞLANIYOR
           ConnectGameCategory::where('game_id', $game->id)->delete();
           $cats = array();
           foreach( $request->get('category') as $v ){ $cats[] = ['game_id'=>$game->id, 'game_category_id'=>$v]; }
           ConnectGameCategory::insert($cats);

           $cover = ASWHelper::uploadCover($request, $game, $oldCoverName, $this->coverPath);
           $game->update( [
               'cover'=>$cover,
               'allow_comments' => $request->get('allow_comments', 'off')
               ] );


           // ESKİ OYUN DOSYASI SİLİNİYOR.
            $swfName = $oldSwfName;
            if( $request->get('removeSwf')=="on" && $game->game_file ){
                deleteFile(public_path( asw('path_media_game_files').'/'.$swfName ));
                $swfName = null;
            }

           // OYUN SWF DOSYASI UPLOAD EDİLİYOR
           if( $swf = $request->file('game_file') ){
               if( $swf->getClientOriginalExtension() != 'swf' ){
                   setAlert('Geçerli bir oyun dosyası seçmediniz. (.swf)', 'danger', 'game_file');
               }else{
                   $swfName = substr($game->slug, 0, 60).'__'.time().'.'.$swf->getClientOriginalExtension();
                   $swf->move( public_path(asw('path_media_game_files')), $swfName );
               }
           }
           $game->update( ['game_file'=>$swfName] );



           setAlertFixed('<strong>'.$game->title.'</strong> oyun güncellendi.');
           $status = true;
           $goUrl = route( 'panel.game.edit', ['game'=>$game] );
        }

          return redirect( $goUrl )->with('postStatus', $status);
    }//update










    public function destroy(Game $game){
        if($game->status != 'trash'){
             $game->update( ['status' => 'trash'] );
             setAlertFixed('<strong>'.$game->title.'</strong> başlıklı oyun çöpe taşındı.');
             $goUrl = url()->previous();
        }else{
             $id = $game->id;
             $cover = $game->cover;
             $swf = $game->game_file;
             $title = $game->title;
             $game->delete();
             ConnectGameCategory::where('game_id', $id)->delete();
             if($cover){ ASWHelper::deleteCover($cover, $this->coverPath); }
             if($swf){ deleteFile(public_path(asw('path_media_game_files').'/'.$swf)); }
             setAlertFixed('<strong>'.$title.'</strong> başlıklı oyun tamamen silindi.');
             $goUrl = route('panel.game.games');
        }
        return redirect( $goUrl );
    }









    public function change_comments_permissions(Game $game){
        $newValue = $game->allow_comments=="on"? "off" : "on" ;
        $game->update( ['allow_comments'=>$newValue] );
        $datas = [
            'status' => getBool($newValue, $game->allow_comments),
            'class'  => getBool($game->allow_comments, "on", "success", "danger")
        ];
        return response()->json($datas);
    }
    public function change_status(Game $game){
        $newValue = $game->status!="published"? "published" : "draft";
        $game->update( ['status'=>$newValue] );
        $datas = [
            'status' => getBool($newValue, $game->status),
            'class' => getBool($game->status, "published", "success", "danger")
        ];
        return response()->json( $datas );
    }









}
