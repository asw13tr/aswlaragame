@extends('panel/master')
@section('pageTitle', 'Medya Ayarları')
@section('content')
<?php echo getAlert('fixed'); ?>
<div class="box box-primary">
<div class="box-body">
<div class="col-md-7">
<form action="{{ route('panel.setting.mediaPost') }}" method="post">
@csrf

<br>
<h4 class="box-title mb20 "><i class="fa fa-cog"></i> Medya Dosyaları Yol Ayarları</h4>
<small><b>NOT:</b> Bu ayarları emin olmadan değiştirmeyiniz. Web sitenizde görsel problemleri yaşayabilirsiniz.</small>
<div class="pl20">

    <div class="form-group"><label>Medya dosyaları upload klasörü</label>
        <input type="text" name="path_media" class="form-control input-sm" value="{{ $setting->path_media }}"></div>

    <div class="form-group"><label>Sayfa görselleri</label>
        <input type="text" name="path_media_page" class="form-control input-sm" value="{{ $setting->path_media_page }}"></div>

    <div class="form-group"><label>Makale görselleri</label>
        <input type="text" name="path_media_article" class="form-control input-sm" value="{{ $setting->path_media_article }}"></div>

    <div class="form-group"><label>Oyun görselleri</label>
        <input type="text" name="path_media_game" class="form-control input-sm" value="{{ $setting->path_media_game }}"></div>

    <div class="form-group"><label>Oyun kategorisi görselleri</label>
        <input type="text" name="path_media_game_category" class="form-control input-sm" value="{{ $setting->path_media_game_category }}"></div>

    <div class="form-group"><label>Oyun dosyasları <cite>(.swf)</cite></label>
        <input type="text" name="path_media_game_files" class="form-control input-sm" value="{{ $setting->path_media_game_files }}"></div>

    <div class="form-group"><label>Kullanıcı görselleri</label>
        <input type="text" name="path_media_user" class="form-control input-sm" value="{{ $setting->path_media_user }}"></div>

    <div class="form-group"><label>Diğer tüm dosyaların upload yolu</label>
        <input type="text" name="path_media_upload" class="form-control input-sm" value="{{ $setting->path_media_upload }}"></div>



</div>
<hr>















<h4 class="box-title mb20 "><i class="fa fa-cog"></i> Görsel Upload Ayarları</h4>
<div class="pl20">

    <div class="checkbox icheck">
        <label>
            <input type="checkbox" name="img_allow_original" value="1" {{ getBool($setting->img_allow_original, 1, 'checked', null) }}>
            Orjinal görsel de upload edilsin. <br><cite>(orjinal görselin upload edilmesi görsel optimize edilmemiş ise hafızada fazla yer kaplayacaktır. )</cite>
        </label>
    </div>
    <hr>




    <h5 class="box-title mb10"><i class="fa fa-arrow-right"></i> Büyük boyut görsel ayarları</h5>
    <div class="pl20">
        <div class="checkbox icheck">
            <label>
                <input type="checkbox" name="img_lg_crop" value="1" {{ getBool($setting->img_lg_crop, 1, 'checked', null) }}>
                Büyük boyut görseller kırpılsın mı? <cite>(Crop)</cite>
            </label>
        </div>

        <div class="row">
            <div class="col-sm-4">
            <div class="form-group"><label>Genişlik <cite>(Width)</cite></label>
                <input type="number" min="1" name="img_lg_w" class="form-control input-sm" value="{{ $setting->img_lg_w }}"></div>
            </div>

            <div class="col-sm-4">
            <div class="form-group"><label>Yükseklik <cite>(Height)</cite></label>
                <input type="number" min="1" name="img_lg_h" class="form-control input-sm" value="{{ $setting->img_lg_h }}"></div>
            </div>

            <div class="col-sm-4">
            <div class="form-group"><label>Kalite %..</label>
                <input type="number" min="1" name="img_lg_quality" class="form-control input-sm" value="{{ $setting->img_lg_quality }}"></div>
            </div>
        </div>
    </div>
    <hr>





    <h5 class="box-title mb10"><i class="fa fa-arrow-right"></i> Orta boyut görsel ayarları</h5>
    <div class="pl20">
        <div class="checkbox icheck">
            <label>
                <input type="checkbox" name="img_md_crop" value="1" {{ getBool($setting->img_md_crop, 1, 'checked', null) }}>
                Orta boyut görseller kırpılsın mı? <cite>(Crop)</cite>
            </label>
        </div>

        <div class="row">
            <div class="col-sm-4">
            <div class="form-group"><label>Genişlik <cite>(Width)</cite></label>
                <input type="number" min="1" name="img_md_w" class="form-control input-sm" value="{{ $setting->img_md_w }}"></div>
            </div>

            <div class="col-sm-4">
            <div class="form-group"><label>Yükseklik <cite>(Height)</cite></label>
                <input type="number" min="1" name="img_md_h" class="form-control input-sm" value="{{ $setting->img_md_h }}"></div>
            </div>

            <div class="col-sm-4">
            <div class="form-group"><label>Kalite %..</label>
                <input type="number" min="1" name="img_md_quality" class="form-control input-sm" value="{{ $setting->img_md_quality }}"></div>
            </div>
        </div>
    </div>
    <hr>




    <h5 class="box-title mb10"><i class="fa fa-arrow-right"></i> Küçük boyut görsel ayarları</h5>
    <div class="pl20">
        <div class="checkbox icheck">
            <label>
                <input type="checkbox" name="img_sm_crop" value="1" {{ getBool($setting->img_sm_crop, 1, 'checked', null) }}>
                Küçük boyut görseller kırpılsın mı? <cite>(Crop)</cite>
            </label>
        </div>

        <div class="row">
            <div class="col-sm-4">
            <div class="form-group"><label>Genişlik <cite>(Width)</cite></label>
                <input type="number" min="1" name="img_sm_w" class="form-control input-sm" value="{{ $setting->img_sm_w }}"></div>
            </div>

            <div class="col-sm-4">
            <div class="form-group"><label>Yükseklik <cite>(Height)</cite></label>
                <input type="number" min="1" name="img_sm_h" class="form-control input-sm" value="{{ $setting->img_sm_h }}"></div>
            </div>

            <div class="col-sm-4">
            <div class="form-group"><label>Kalite %..</label>
                <input type="number" min="1" name="img_sm_quality" class="form-control input-sm" value="{{ $setting->img_sm_quality }}"></div>
            </div>
        </div>
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
