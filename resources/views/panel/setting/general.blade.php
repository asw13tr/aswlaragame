@extends('panel/master')
@section('pageTitle', 'Genel Ayarlar')
@section('content')
<?php echo getAlert('fixed'); ?>
<div class="box box-primary">
<div class="box-body">
<div class="col-md-7">
<form action="{{ route('panel.setting.generalPost') }}" method="post">
@csrf


<div class="form-group"><label>Website Adresi</label>
    <input type="text" name="url" class="form-control input-sm" value="{{ $setting->url }}"></div>
<hr>


<div class="form-group"><label>Site Başlığı <cite>(head:title)</cite></label>
    <input type="text" name="title" class="form-control input-sm" value="{{ $setting->title }}"></div>
<hr>


<div class="form-group"><label>Site Açıklaması <cite>(meta:description)</cite></label>
    <input type="text" name="description" class="form-control input-sm" value="{{ $setting->description }}"></div>
<hr>


<div class="form-group"><label>Yazar <cite>(meta:author)</cite></label>
    <input type="text" name="author" class="form-control input-sm" value="{{ $setting->author }}"></div>
<hr>


<div class="form-group"><label>Anasayfa kaç saniyede bir yenilensin <cite>(meta:refresh) [0=iptal]</cite></label>
    <input type="text" name="refresh" class="form-control input-sm" value="{{ $setting->refresh }}"></div>
<hr>


<div class="form-group">
<div class="checkbox icheck">
    <label>
        <input type="checkbox" name="site_offline" value="1" {{ getBool($setting->site_offline, 1, 'checked', null) }}> Site Kullanıma kapalı
    </label>
</div>
</div>

<div class="form-group"><label>Site kapalı mesajı</label>
    <textarea name="site_offline_message" rows="3" class="form-control">{{ $setting->site_offline_message }}</textarea></div>
<hr>


<div class="form-group">
<div class="checkbox icheck">
    <label>
        <input type="checkbox" name="allow_register" value="1" {{ getBool($setting->allow_register, 1, 'checked', null) }}> Siteye üyeler kayıt olabilir.
    </label>
</div>
</div>
<hr>


<div class="form-group">
<div class="checkbox icheck">
    <label>
        <input type="checkbox" name="allow_register_panel" value="1" {{ getBool($setting->allow_register_panel, 1, 'checked', null) }}> Panel kullanıcı kayıt sayfası aktif.
    </label>
</div>
</div>
<hr>


<div class="form-group">
    <button type="submit" class="btn btn-primary pull-right">Güncelle</button>
</div>



</form>
</div>
</div>
</div>
@endsection
