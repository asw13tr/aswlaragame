@extends('panel/master')
@section('pageTitle', 'İletişim Ayarları')
@section('content')
<?php echo getAlert('fixed'); ?>
<div class="box box-primary">
<div class="box-body">
<div class="col-md-7">
<form action="{{ route('panel.setting.contactPost') }}" method="post">
@csrf










<h4 class="box-title mb20 "><i class="fa fa-cog"></i> Posta Bilgileri</h4>
<div class="pl10">

    <div class="form-group"><label>E-posta alacağınız adresiniz</label>
        <input type="text" name="contact_email" class="form-control input-sm" value="{{ $setting->contact_email }}"></div>

    <div class="form-group"><label>Alıcıların göreceği e-posta adresiniz</label>
        <input type="text" name="contact_sender_mail" class="form-control input-sm" value="{{ $setting->contact_sender_mail }}"></div>

    <div class="form-group"><label>Alıcıların göreceği gönderen ismi</label>
        <input type="text" name="contact_sender_name" class="form-control input-sm" value="{{ $setting->contact_sender_name }}"></div>

</div>
<hr>















<h4 class="box-title mb20 "><i class="fa fa-cog"></i> E-posta gönderme ayarları</h4>
<div class="pl10">

    <div class="form-group"><label>E-posta Sürücüsü <cite>(Driver)</cite></label>
        <input type="text" name="mail_driver" class="form-control input-sm" value="{{ $setting->mail_driver }}" disabled></div>

    <div class="form-group"><label>E-posta sunucusu <cite>(Host)</cite></label>
        <input type="text" name="mail_host" class="form-control input-sm" value="{{ $setting->mail_host }}"></div>

    <div class="form-group"><label>E-posta portu <cite>(Port)</cite></label>
        <select name="mail_port" class="form-control input-sm">
            <option {{ getBool($setting->mail_port, 25, 'selected', null) }}>25</option>
            <option {{ getBool($setting->mail_port, 465, 'selected', null) }}>465</option>
            <option {{ getBool($setting->mail_port, 587, 'selected', null) }}>587</option>
        </select>
    </div>

    <div class="form-group"><label>E-posta <cite>(Username)</cite></label>
        <input type="text" name="mail_username" class="form-control input-sm" value="{{ $setting->mail_username }}"></div>

    <div class="form-group"><label>Şifre <cite>(Password)</cite></label>
        <input type="text" name="mail_password" class="form-control input-sm" value="{{ $setting->mail_password }}"></div>

    <div class="form-group"><label>Şifreleme <cite>(encryption)</cite></label>
        <select name="mail_encryption" class="form-control input-sm">
            <option value="ssl" {{ getBool($setting->mail_encryption, 'ssl', 'selected', null) }}>ssl</option>
            <option value="tls" {{ getBool($setting->mail_encryption, 'tls', 'selected', null) }}>tls</option>
            <option value="" {{ getBool($setting->mail_encryption, '', 'selected', null) }}>Yok</option>
        </select>
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
