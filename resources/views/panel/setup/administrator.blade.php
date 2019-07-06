@extends('panel/setup')
@section('content')
<form action="{{ route('setup.administratorPost') }}" method="POST">{{ csrf_field() }}
<div class="box box-success">
    <div class="box-header text-center"><strong class="box-title">Yönetici Oluştur</strong></div>
    <div class="box-body">







        @include("panel/inc/add-errors")
          <div class="form-group has-feedback">
            <input type="text" name="name" class="form-control thisslug" placeholder="Kullanıcı Adı (*)" autofocus required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback">
            <input type="email" name="email" class="form-control" placeholder="E-posta Adresi (*)" required>
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











    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-info btn-block btn-md">Kurulumu Bitir</a>
    </div>
</div>
</form>
@endsection
