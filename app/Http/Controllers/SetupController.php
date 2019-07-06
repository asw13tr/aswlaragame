<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class SetupController extends Controller{





    public function welcome(){
        Artisan::call('key:generate');
        return view('panel/setup/welcome');
    }




















    public function database(){
        return view('panel/setup/database');
    }



    public function databasePost(Request $request){
        $request->flashExcept(['password']);
        $this->databaseValidate($request);
        $file = fopen( base_path('.env'), 'w' );
        fwrite($file, $this->getEnv($request));
        fclose($file);
        sleep(7);
        return redirect()->route('setup.migrate');
    }



    protected function databaseValidate(Request $request){
        $request->validate([
            'database' => 'required',
            'username' => 'required'
        ]);
    }



    protected function getEnv(Request $request){
        return 'APP_NAME=AsWeb
APP_ENV=local
APP_KEY='.env("APP_KEY").'
APP_DEBUG=false
APP_URL=http://localhost
APP_INSTALL=true

LOG_CHANNEL=stack

DB_CONNECTION='.$request->get("connection", "mysql").'
DB_HOST='.$request->get("host", "127.0.0.1").'
DB_PORT='.$request->get("port", "3306").'
DB_DATABASE='.$request->get("database", "").'
DB_USERNAME='.$request->get("username", "").'
DB_PASSWORD='.$request->get("password", "").'

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
        ';
    }














    public function migrate(){
        Artisan::call('migrate');
        return redirect()->route('setup.config');
    }















    public function config(){
        if(isset($GLOBALS['aswConfig'])){
            foreach($GLOBALS['aswConfig'] as $key => $val){
                \App\Config::firstOrCreate(['key'=>$key], ['val'=>$val]);
            }
        }
        return redirect()->route('setup.general');
    }



















    public function general(){
        return view('panel/setup/general');
    }



    public function generalPost(Request $request){
        $datas = $request->all();
        unset($datas['_token']);
        foreach($datas as $key => $val){
            \App\Config::where('key', $key)->update(['val'=>$val]);
        }
        return redirect()->route('setup.administrator');
    }



















    public function administrator(){
        return view('panel/setup/administrator');
    }



    public function administratorPost(Request $request){
        $request->flashExcept(['password', 'repassword']);
        $this->validateAdministrator($request);
        $password = $request->get('password', null);
        $username = $request->get('name', null);
        $user = \App\User::create($request->all())->update(['password' => Hash::make($password), 'level' => 3, 'status'=>'active', 'slug' => $username]);
        return redirect()->route('setup.finish');
    }



    protected function validateAdministrator(Request $request){
        $request->validate(
            [
                'name'  => 'required|string|unique:users|min:4|max:16',
                'email' => 'required|email|unique:users',
                'password'  => 'required|string|min:8|max:32|required_with:repassword|same:repassword',
                'repassword'    => 'required',
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
            ]
        );
    }



















    public function finish(){
        return view('panel/setup/finish');
    }



}
