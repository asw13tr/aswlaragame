<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ASWHelper;

class UserController extends Controller{

    protected $coverPath;

    public function __construct(){
        $this->coverPath = asw('path_media_user');
        $this->middleware('panelAccessPermission');
    }

    public function index(Request $request){
        $users = User::orderBy('id', 'desc');
        if( $request->get('s', null) != null ){ $users = $users->where('status', $request->get('s')); }
        if( $request->get('l', null) != null ){ $users = $users->where('level', $request->get('l')); }
        $datas = [
           'headTitle' => 'Kullanıcılar',
           'items' => $users->get()
        ];
       return view("panel/user/users", $datas);
    }











    public function create(){
        return view('panel/user/user-form', ['headTitle'=>'Yeni kullanıcı kaydet']);
    }
    public function store(Request $request){
        $goUrl = url()->previous();
        if( !$request->get('name', null) || !$request->get('email', null) || !$request->get('password', null) ){
            setAlertFixed('Gerekli tüm alanları doldurduğunuzdan emin olun.', 'danger');
        }elseif( User::where('name',$request->get('name'))->count() ){
            setAlertFixed('Kullanıcı adı sistemde kayıtlı.', 'danger');
        }elseif( User::where('email',$request->get('email'))->count() ){
            setAlertFixed('E-posta adresi sistemde kayıtlı.', 'danger');
        }else{
                try{
                    // POST DATALARI İLE OBJE OLUŞTURULUYOR.
                    $user = User::create( $request->all() );
                    $cover = ASWHelper::uploadCover($request, $user, null, $this->coverPath);
                    $user->update( [
                            'slug'      =>  $user->name,
                            'cover'     =>  $cover,
                            'password'  =>  Hash::make($user->password),
                            'datas'     =>  json_encode($request->get('others', []))
                        ] );
                    // MESAJ VE YÖNLENDİRME ADRESİ
                    setAlertFixed('<strong>'.$user->name.'</strong> kullanıcı hesabı oluşturuldu.');
                    $goUrl = route('panel.user.edit', ['user'=>$user] );

                }catch(\Illuminate\Database\QueryException $e){
                    setAlertFixed("Beklenmedik bir hata oluştu", 'danger');
                }
        }
        return redirect( $goUrl );
    }//store














    public function edit(User $user){
        return view('panel/user/user-form', ['headTitle'=>'Kullanıcı hesabı düzenle', 'data'=>$user]);
    }
    public function update(Request $request, User $user){
        $goUrl = url()->previous();
        if( !$request->get('name', null) || !$request->get('email', null)){
            setAlertFixed('Gerekli tüm alanları doldurduğunuzdan emin olun.', 'danger');
        }elseif( User::where('name',$request->get('name'))->where('id', '!=', $user->id)->count() ){
            setAlertFixed('Kullanıcı adı sistemde kayıtlı.', 'danger');
        }elseif( User::where('email',$request->get('email'))->where('id', '!=', $user->id)->count() ){
            setAlertFixed('E-posta adresi sistemde kayıtlı.', 'danger');
        }else{
                try{
                    $oldCoverName = $user->cover;
                    // POST DATALARI İLE OBJE OLUŞTURULUYOR.
                    $user->update( $request->all() );
                    $cover = ASWHelper::uploadCover($request, $user, $oldCoverName, $this->coverPath);
                    $newPass = $request->get('change_password', false);
                    $user->update( [
                            'slug'      => $user->name,
                            'cover'     =>  $cover,
                            'password'  =>  $newPass? Hash::make($newPass) : $user->password,
                            'datas'     =>  json_encode($request->get('others', []))
                        ] );
                    // MESAJ VE YÖNLENDİRME ADRESİ
                    setAlertFixed('<strong>'.$user->name.'</strong> kullanıcı hesabı güncellendi.');
                    $goUrl = route('panel.user.edit', ['user'=>$user] );

                }catch(\Illuminate\Database\QueryException $e){
                    setAlertFixed("Beklenmedik bir hata oluştu", 'danger');
                }
        }
        return redirect( $goUrl );
    }













    public function destroy(User $user){
        if($user->status != 'trash'){
             $user->update( ['status' => 'trash'] );
             setAlertFixed('<strong>'.$user->name.'</strong> kullanıcı hesabı çöpe taşındı.');
             $goUrl = url()->previous();
        }else{
             $id = $user->id;
             $cover = $user->cover;
             $name = $user->name;
             $user->delete();
             if($cover){ ASWHelper::deleteCover($cover, $this->coverPath); }
             setAlertFixed('<strong>'.$name.'</strong> kullanıcı hesabı tamamen silindi.');
             $goUrl = route('panel.user.users');
        }
        return redirect( $goUrl );
    }










    public function profile(){
        return view('panel/user/profile', ['headTitle'=>'Profilinizi Düzenleyin', 'data'=>Auth::user()]);
    }
    public function profilePost(Request $request){
        $user = Auth::user();
        $goUrl = url()->previous();
        $postEmail = $request->get('email', null);
        if( !$postEmail ){
            setAlertFixed('Gerekli tüm alanları doldurduğunuzdan emin olun.', 'danger');
        }elseif( User::where('email', $postEmail)->where('id', '!=', $user->id)->count() ){
            setAlertFixed('E-posta adresi sistemde kayıtlı.', 'danger');
        }else{
                try{
                    $oldCoverName = $user->cover;
                    // POST DATALARI İLE OBJE OLUŞTURULUYOR.
                    $user->update( $request->all() );
                    $cover = ASWHelper::uploadCover($request, $user, $oldCoverName, $this->coverPath);
                    $newPass = $request->get('change_password', false);
                    $user->update( [
                            'cover'     =>  $cover,
                            'password'  =>  $newPass? Hash::make($newPass) : $user->password,
                            'datas'     =>  json_encode($request->get('others', []))
                        ] );
                    // MESAJ VE YÖNLENDİRME ADRESİ
                    setAlertFixed('<strong>'.$user->name.'</strong> Profiliniz güncellendi.');
                    $goUrl = route('panel.user.profile' );

                }catch(\Illuminate\Database\QueryException $e){
                    setAlertFixed("Beklenmedik bir hata oluştu", 'danger');
                }
        }
        return redirect( $goUrl );
    }











    public function change_status(User $user){
        $newValue = $user->status!="active"? "active" : "passive";
        $user->update( ['status'=>$newValue] );
        $datas = [
            'status' => getBool($newValue, $user->status),
            'class' => getBool($user->status, "active", "success", "danger")
        ];
        return response()->json( $datas );
    }


}
