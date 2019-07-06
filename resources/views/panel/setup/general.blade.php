@extends('panel/setup')
@section('content')
<form action="{{ route('setup.generalPost') }}" method="post">@csrf
<div class="box box-success">
    <div class="box-header text-center"><strong class="box-title">Site Ayarları</strong></div>
    <div class="box-body">

        <?php $actualUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".@$_SERVER['HTTP_HOST']; ?>
        <div class="form-group"><label>Site Adresi</label>
            <input type="url" name="url" class="form-control" value="{{ $actualUrl }}"></div>

        <div class="form-group"><label>Site Başlığı <cite>(Title)</cite></label>
            <input type="text" name="title" class="form-control"></div>

        <div class="form-group"><label>Site açıklaması <cite>(Description)</cite></label>
            <textarea name="description" class="form-control" rows="3" autofocus></textarea></div>

        <div class="form-group"><label>Yazar <cite>(Author)</cite></label>
            <input type="text" name="author" class="form-control">
        </div>

    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-info btn-block btn-md">Sonraki Adım</a>
    </div>
</div>
</form>
@endsection
