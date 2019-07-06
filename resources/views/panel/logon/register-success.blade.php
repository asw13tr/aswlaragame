@extends('panel/logon')
@section('content')
<div class="register-box">
  <div class="register-logo"><a href="#"><b>ASW</b>Panel</a></div>

  <div class="register-box-body">
    <h3 class="login-box-msg text-success">Kayıt Başarılı</h3>
    <p>Kullanıcı kaydınız başarılı bir şekilde tamamlanmıştır. Hesabınız onaylandıktan sonra giriş yapabilirsiniz.</p>

    <hr><a href="{{ route('panel.login') }}" class="text-center">Giriş Yap</a>
  </div>
  <!-- /.form-box -->
</div>
@endsection
