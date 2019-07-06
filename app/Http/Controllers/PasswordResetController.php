<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\PasswordReset;
use App\User;

class PasswordResetController extends Controller{

    /*
    ###ADMİN PANEL ŞİFRE SIFIRLAMA
    */
    public function passwordResetPanel(){
        return view('panel/logon/password_reset');
    }
    public function passwordResetPanelPost(Request $request){
        $goUrl = url()->previous();
        $mail = $request->get('email', false);
        $uye = User::where([ 'email'=>$mail, 'status'=>'active' ])->where('level', '>', '0')->first();
        if(!$uye){
            setAlertFixed('E-posta adresi kayıtlı veya aktif değil.', 'danger');
        }else{
            $token = md5(time().rand(999,999999));
            $time = date('Y-m-d H:i:s');
            $passwordReset = PasswordReset::create([
                'email' => $uye->email,
                'token' => $token,
                'created_at'    => $time
            ]);
            $this->passwordResetPanelSendMail($passwordReset);
            $goUrl = route('panel.passwordResetPostSuccess');
        }
        return redirect( $goUrl );
    }
    public function passwordResetPanelPostSuccess(){
        return view('panel/logon/password_reset_alert',
        ['class'=>'success',
        'message' => 'E-posta adresinize bir şifre sıfırlama postası gönderdik. Lütfen e-postanızı kontrol edin.
        <b>Spam</b> klasörünü kontrol etmeyi unutmayın.']);
    }//passwordResetPanelPostSuccess
    public function passwordResetPanelSendMail($passwordReset){
        $data = [
            'data' => $passwordReset,
            'resetUrl'  => route('panel.passwordResetForm', ['email'=>$passwordReset->email, 'token'=>$passwordReset->token])  ];
        Mail::send("panel/logon/password_reset_mail", $data, function($message) use ($passwordReset){
            $message->to($passwordReset->email, $passwordReset->email)->subject("Şifre sıfırlama isteği");
        });
    }
    public function passwordResetPanelForm($email, $token){
        $reset = PasswordReset::where([ 'email'=>$email, 'status'=>0 ])->orderBy('id', 'desc')->first();
        $result = view('panel/logon/password_reset_alert', ['class'=>'danger', 'message' => 'Hatalı veya zamanı geçmiş şifre sıfırlama isteği.']);
        if($reset && $reset->token == $token){
            $user = User::where(['email'=>$reset->email, 'status'=>'active'])->where('level', '>', '0')->first();
            if($user){
                $result = view('panel/logon/password_reset', ['user'=>$user]);
            }
        }
        return $result;
    }






























    // ŞİFRE GÜNCELLEME İŞLEMLERİ
    public function passwordResetFormPost(Request $request, User $user){
        $this->validatePasswordResetForm($request);
        $password = $request->get('password', null);
        $user->update([ 'password' => Hash::make($password) ]);
        setAlertFixed('Şifre güncelleme başarılı.');
        if($user->level > 1){
            return redirect( route('panel.login') );
        }else{
            return redirect( route('frontpage') );
        }
    }
    protected function validatePasswordResetForm(Request $request){
        $request->validate(
            [
                'password'  => 'required|string|min:8|max:32|required_with:repassword|same:repassword',
                'repassword'    => 'required'
            ],
            [
                'password.required'      => "Parola boş bırakılamaz",
                'password.min'  => "Parolanız en az 8 karakterden oluşmalıdır.",
                'password.max'  => "Parolanız en fazla 32 karakter olmalıdır.",
                'password.required_with'    => "Parolalar birbiri ile uyuşmuyor.",
                'password.same'    => "Parolalar birbiri ile uyuşmuyor.",

                'repassword.required'   => "Şifre tekrarını boş bıraktınız.",
            ]
        );
    }

}// class PasswordResetController
