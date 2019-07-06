<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LogonController extends Controller{

    // KULLANICI GİRİŞ İŞLEMLERİ
    public function login(Request $request){
        if(Auth::check()){ return redirect( route('panel.dashboard') ); }
        return view('panel/logon/login', ['headTitle'=>'Giriş Yap']);
    }
    public function loginPost(Request $request){
        $request->flashExcept(['password']);
        $this->validateLogin($request);
        $goUrl = url()->previous();
        $username = $request->get('username', null);
        $password = $request->get('password', null);
        $remember = $request->get('remember', false);
        $uye = User::where('name', $username)->where('level','>',1)->where('status', 'active')->first();
        if(!$uye){
            setAlertFixed('Varolan bir kullanıcı hesabı belirtilmedi.', 'danger');
        }else{
            if(Hash::check($password, $uye->password) != true){
                setAlertFixed('Varolan bir kullanıcı hesabı belirtilmedi.', 'danger');
            }else{
                if(!$remember){
                    Auth::login($uye);
                }else{
                    Auth::login($uye, true);
                }
                setAlertFixed('Kullanıcı girişi başarılı.');
                $goUrl = route('panel.dashboard');
            }
        }
        return redirect($goUrl);
    }
    protected function validateLogin(Request $request){
        $request->validate(
            [
                'username' => 'required',
                'password'  => 'required'
            ],
            [
                'username.required' => 'Kullanıcı adını girmediniz',
                'password.required' => "Kullanıcı şifrenizi girmediniz"
            ]
        );
    }








    // KULLANICI ÇIKIŞ İŞLEMLERİ
    public function logout(){
        if(Auth::check()){
            Auth::logout();
        }
        return redirect()->route('panel.login');
    }






    // KULLANICI REGİSTER İŞLEMLERİ
    public function register(){
        if(!asw('allow_register_panel')){ return redirect()->route('panel.login'); }
        return view('panel/logon/register', ['headTitle'=>"Kayıt Ol"]);
    }
    public function registerPost(Request $request){
        $request->flashExcept(['password', 'repassword']);
        $this->validateRegister($request);
        $password = $request->get('password', null);
        $username = $request->get('name', null);
        $user = User::create($request->all())->update(['password' => Hash::make($password), 'level' => 2, 'status'=>'passive', 'slug' => $username]);
        return redirect()->route('panel.registerSuccess');
    }
    protected function validateRegister(Request $request){
        $request->validate(
            [
                'name'  => 'required|string|unique:users|min:4|max:16',
                'email' => 'required|email|unique:users',
                'password'  => 'required|string|min:8|max:32|required_with:repassword|same:repassword',
                'repassword'    => 'required',
                'conditions'    => 'required',
            ],
            [
                'name.required' => "Kullanıcı adı boş bırakılamaz",
                'name.unique'   => "Kullanıcı adı daha önce alınmış",
                'name.min'      => "Kullanıcı adı en az 4 karakterden oluşmalıdır",
                'name.max'      => "Kullanıcı adı en fazla 16 karakter olmadılıdır.",

                'email.required'    => "E-posta adresi boş bırakılamaz",
                'email.email'    => "Geçerli bir E-posta adresi girmediniz.",
                'email.unique'    => "E-posta adresi sistemde kayıtlı",

                'password.required'      => "Parola boş bırakılamaz",
                'password.min'  => "Parolanız en az 8 karakterden oluşmalıdır.",
                'password.max'  => "Parolanız en fazla 32 karakter olmalıdır.",
                'password.required_with'    => "Parolalar birbiri ile uyuşmuyor.",
                'password.same'    => "Parolalar birbiri ile uyuşmuyor.",

                'repassword.required'   => "Şifre tekrarını boş bıraktınız.",

                'conditions.required'  => "Şartları kabul etmediniz"
            ]
        );
    }
    public function registerSuccess(){
        return view('panel/logon/register-success', ['headTitle'=>"Yeni kullanıcı oluşturuldu."]);
    }






}
