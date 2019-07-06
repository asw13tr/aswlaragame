@extends('panel/logon')
@section('content')
<div class="register-box">
  <div class="register-logo"><a href="#"><b>ASW</b>Panel</a></div>

  <div class="register-box-body">
    <p class="login-box-msg">Kayıt Ol</p>
    @include("panel/inc/add-errors")

    <form action="{{ route('panel.registerPost') }}" method="post">
        {{ csrf_field() }}
      <div class="form-group has-feedback">
        <input type="text" name="name" class="form-control thisslug" placeholder="Kullanıcı Adı (*)" value="{{ old('name') }}" autofocus required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="E-posta Adresi (*)" value="{{ old('email') }}" required>
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
      <div class="form-group has-feedback">
        <input type="text" name="fullname" class="form-control" placeholder="Ad ve Soyad" value="{{ old('fullname') }}">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <textarea name="description" rows="3" class="form-control" placeholder="Kendinizi tanıtın">{{ old('description') }}</textarea>
        <span class="glyphicon glyphicon-info-sign form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck"><label><input type="checkbox" name="conditions" required> Tüm <a href="">Şartları</a> kabul ediyorum.</label></div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Kayıt Ol</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <hr><a href="{{ route('panel.login') }}" class="text-center">Zaten bir hesabım var!</a>
  </div>
  <!-- /.form-box -->
</div>
@endsection
