@extends('panel/setup')
@section('content')
<form action="{{ route('setup.databasePost') }}" method="post">@csrf
<div class="box box-success">
    <div class="box-header text-center"><strong class="box-title">Veritabanı Ayarları</strong></div>
    <div class="box-body">



        <div class="form-group"><label>Bağlantı Tipi</label>
            <input type="text" class="form-control" disabled value="mysql"></div>

        <div class="form-group"><label>Sunucu adresi</label>
            <input type="text" name="host" class="form-control" value="{{ old('host', 'localhost') }}" autofocus></div>

        <div class="form-group"><label>Veritabanı adı</label>
            <input type="text" name="database" class="form-control" value="{{ old('database') }}">
            @error('database')<span class="label label-danger">Boş bırakılamaz</span>@enderror
        </div>

        <div class="form-group"><label>Kullanıcı adı</label>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}">
            @error('username')<span class="label label-danger">Boş bırakılamaz</span>@enderror
        </div>

        <div class="form-group"><label>Parola</label>
            <input type="password" name="password" class="form-control"></div>

        <div class="form-group"><label>Port</label>
            <input type="number" name="port" class="form-control" value="{{ old('port', 3306) }}"></div>

    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-info btn-block btn-md">Sonraki Adım</a>
    </div>
</div>
</form>
@endsection
