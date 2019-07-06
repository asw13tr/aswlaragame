<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;


use App\Article;
use App\ConnectArticleCategory;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ASWHelper;

class ArticleController extends Controller{

    protected $coverPath;


    public function __construct(){
        $this->coverPath = asw('path_media_article');
        $this->middleware('panelAccessPermission')->except( ['index', 'create', 'store'] );
    }















    public function index(Request $request){
         $articles = Article::orderBy('id', 'desc');
         if( $request->get('s', null) != null ){ $articles = $articles->where('status', $request->get('s')); }
         if( $request->get('c', null) != null ){
             $catID = $request->get('c');
            $articles = $articles->whereHas( 'categories', function($q) use($catID){
                $q->where('blog_category_id', $catID);
            } );
        }
        if( Auth::user()->level != 3 ){ $articles = $articles->where('author', Auth::user()->id); }
         $datas = [
            'headTitle' => 'Yazılar',
            'items' => $articles->get()
         ];
        return view("panel/blog/articles", $datas);
    }















    public function create(){
        return view('panel/blog/article-form', ['headTitle'=>'Yeni yazı ekle']);
    }



    public function store(Request $request){

         $status = false;
         $goUrl = url()->previous();
        if(!$request->get('category',false)){
            setAlertFixed('En az bir tane kategori seçmek zorundasınız.', 'danger');
        }else{
           // Posttan gelen tüm veriler DB içine kaydedilip yeni bir yazı nesnesi oluşturuluyor.
           $article = Article::create( $request->all() );

           // Makale için seçilen kategoriler makale ile bağlanıyor.
           $cats = array();
           foreach( $request->get('category') as $v ){ $cats[] = ['article_id'=>$article->id, 'blog_category_id'=>$v]; }
           ConnectArticleCategory::insert($cats);

           $cover = ASWHelper::uploadCover($request, $article, null, $this->coverPath);

           // Makale görseli güncelleniyor.
           $article->update( [
               'cover'=>$cover,
               'allow_comments' => $request->get('allow_comments', 'off'),
               'hide_cover' => $request->get('hide_cover', 'off'),
               'author'       => Auth::user()->id
               ] );
           setAlertFixed('<strong>'.$article->title.'</strong> başlıklı yazı oluşturuldu.');
           $status = true;
           $goUrl = route( 'panel.blog.article.edit', ['article'=>$article] );
        }

          return redirect( $goUrl )->with('postStatus', $status);
    }















    public function edit(Article $article){
         $cats = ConnectArticleCategory::where('article_id', $article->id)->get();
         $selectedCategories = array();
         foreach($cats as $c){ $checkedCategories[] = $c->blog_category_id; }

         $datas = [
             'data' => $article,
             'checkedCategories' => $checkedCategories,
             'headTitle'=>'Yazıyı düzenle' ];
         return view('panel/blog/article-form', $datas);
    }



    public function update(Request $request, Article $article){
        if($request->get('status', 'null')=="trash" && $article->status=="trash"){ return $this->destroy($article); }
        $status = false;
         if(!$request->get('category',false)){
             setAlertFixed('En az bir tane kategori seçmek zorundasınız.');
         }else{

            $oldCoverName = $article->cover;

            // Yazı Bilgileri güncelleniyor.
            $article->update( $request->all() );

            // Yazı kategorileri güncelleniyor.
            ConnectArticleCategory::where('article_id', $article->id)->delete();
            $cats = array();
            foreach( $request->get('category') as $v ){ $cats[] = ['article_id'=>$article->id, 'blog_category_id'=>$v]; }
            ConnectArticleCategory::insert($cats);

            $cover = ASWHelper::uploadCover($request, $article, $oldCoverName, $this->coverPath);

            // Makale görseli güncelleniyor.
            $article->update( [
                'cover'=>$cover,
                'allow_comments' => $request->get('allow_comments', 'off'),
                'hide_cover' => $request->get('hide_cover', 'off')
                ] );
            $status = true;
            setAlertFixed('Yazı güncelleme başarılı.');
        }
        return redirect(  route('panel.blog.article.edit', ['article'=>$article])  );


    }















    public function destroy(Article $article){
        if($article->status != 'trash'){
             $article->update( ['status' => 'trash'] );
             setAlertFixed('<strong>'.$article->title.'</strong> başlıklı yazı çöpe taşındı.');
             $goUrl = url()->previous();
        }else{
             $id = $article->id;
             $cover = $article->cover;
             $title = $article->title;
             $article->delete();
             ConnectArticleCategory::where('article_id', $id)->delete();
             if($cover){ ASWHelper::deleteCover($cover, $this->coverPath); }
             setAlertFixed('<strong>'.$title.'</strong> başlıklı yazı tamamen silindi.');
             $goUrl = route('panel.blog.articles');
        }
        return redirect( $goUrl );
    }















    public function change_cover_visibilty(Article $article){
        $newValue = $article->hide_cover=="on"? "off" : "on" ;
        $article->update( ['hide_cover'=>$newValue] );
        $datas = [
            'status' => getBool($newValue, $article->hide_cover),
            'class'  => getBool($article->hide_cover, "on", "danger", "success")
        ];
        return response()->json($datas);
    }










    public function change_comments_permissions(Article $article){
        $newValue = $article->allow_comments=="on"? "off" : "on" ;
        $article->update( ['allow_comments'=>$newValue] );
        $datas = [
            'status' => getBool($newValue, $article->allow_comments),
            'class'  => getBool($article->allow_comments, "on", "success", "danger")
        ];
        return response()->json($datas);
    }










    public function change_status(Article $article){
        $newValue = $article->status!="published"? "published" : "draft";
        $article->update( ['status'=>$newValue] );
        $datas = [
            'status' => getBool($newValue, $article->status),
            'class' => getBool($article->status, "published", "success", "danger")
        ];
        return response()->json( $datas );
    }















}
