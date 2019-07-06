@extends('panel/logon')
@section('content')
<div class="login-box">
<div class="login-logo"><a href="#"><b>ASW</b>Panel</a></div>
<div class="login-box-body">
@if( !isset($user) )

        <p class="login-box-msg">Şifre sıfırlamak için kayıtlı e-posta adresinizi yazın</p>
        <form action="{{ route('panel.passwordResetPost') }}" method="post">
            @csrf
            <div>
                <div class="form-group has-feedback">
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-posta adresi" required autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @error('email')<div class="clearfix"></div><span class="text-danger"><strong>{{ $message }}</strong></span>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12"><button type="submit" class="btn btn-primary btn-block btn-flat">Şifre sıfırlama e-postası gönder.</button></div>
            </div>
        </form>
        <hr><a href="{{ route('panel.login') }}">Giriş Yap</a><br>

@else


        <p class="login-box-msg">Şifre Sıfırla</p>
        @include("panel/inc/add-errors")

        <form action="{{ route('password.reset.update.post', ['user'=>$user]) }}" method="post">
            {{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="email" disabled class="form-control" placeholder="E-posta Adresi (*)" value="{{ $user->email }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Parola (*)" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="repassword" class="form-control" placeholder="Parolanızı Tekrarlayın (*)" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
              <div class="col-xs-6"></div>
              <div class="col-xs-6"><button type="submit" class="btn btn-primary btn-block btn-flat">Şifremi Değiştir</button></div>
          </div>

        </form>


@endif
</div>
</div>
@endsection
