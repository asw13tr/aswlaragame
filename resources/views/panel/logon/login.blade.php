@extends('panel/logon')
@section('content')
<div class="login-box">
<div class="login-logo"><a href="#"><b>ASW</b>Panel</a></div>
<div class="login-box-body">
    <p class="login-box-msg">Panel erişimi için lütfen giriş yap.</p>


    <form action="{{ route('panel.loginPost') }}" method="post">
        @csrf

        <div>
            <div class="form-group has-feedback">
                <input type="text" name="username" class="thisslug form-control @error('username') is-invalid @enderror" placeholder="Kullanıcı Adı" required autofocus>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @error('username')<div class="clearfix"></div><span class="text-danger"><strong>{{ $message }}</strong></span>@enderror
            </div>

        </div>

        <div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Parola" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @error('password')<div class="clearfix"></div><span class="text-danger"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col-xs-8"><div class="checkbox icheck"><label><input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Beni Hatırla</label></div></div>
            <div class="col-xs-4"><button type="submit" class="btn btn-primary btn-block btn-flat">Giriş Yap</button></div>
        </div>
    </form>


    <hr>
    @if (Route::has('password.request'))
    <a href="{{ route('panel.passwordReset') }}">Şifremi Unuttum</a><br>
    @endif
    <?php //<a href="register.html" class="text-center">Register a new membership</a> ?>

</div>
</div>
@endsection
