@extends('panel/logon')
@section('content')
<div class="login-box">
<div class="login-logo"><a href="#"><b>ASW</b>Panel</a></div>
<div class="login-box-body">
    <p class="text-{{ $class }}"><?php echo $message; ?></p>
    <hr>
    <a href="{{ route('panel.login') }}">Giriş Yap</a><br>
</div>
</div>
@endsection
