@extends('panel/master')
@section('pageTitle', 'İçerik Ayarları')
@section('content')
<?php echo getAlert('fixed'); ?>
<div class="box box-primary">
<div class="box-body">
<div class="col-md-7">
<form action="{{ route('panel.setting.contentPost') }}" method="post">
@csrf

<br>
<h4 class="box-title mb20 "><i class="fa fa-cog"></i> Sayfa Ayarları</h4>
<div class="pl10">

    <div class="checkbox icheck">
        <label>
            <input type="checkbox" name="pages_allow_comments" value="1" {{ getBool($setting->pages_allow_comments, 1, 'checked', null) }}>
            Sayfalara yorum yapılmasına izin ver.
        </label>
    </div>

</div>
<hr>















<h4 class="box-title mb20 "><i class="fa fa-cog"></i> Makale Ayarları</h4>
<div class="pl10">

    <div class="checkbox icheck">
        <label>
            <input type="checkbox" name="articles_allow_commens" value="1" {{ getBool($setting->articles_allow_commens, 1, 'checked', null) }}>
            Makalelere yorum yapılmasına izin ver.
        </label>
    </div>

    <div class="form-group"><label>Listeleme sayfalarında gösterilecek makale sayısı</label>
        <input type="number" min="1" name="articles_list_limit" class="form-control input-sm" value="{{ $setting->articles_list_limit }}"></div>


    <div class="form-group"><label>Listeleme sayfalarında makale özetinin en fazla karakter sayısı</label>
        <input type="number" min="1" name="articles_summary_limit" class="form-control input-sm" value="{{ $setting->articles_summary_limit }}"></div>

</div>
<hr>















<h4 class="box-title mb20 "><i class="fa fa-cog"></i> Oyun Ayarları</h4>
<div class="pl10">

    <div class="checkbox icheck">
        <label>
            <input type="checkbox" name="games_allow_commens" value="1" {{ getBool($setting->games_allow_commens, 1, 'checked', null) }}>
            Oyunlara yorum yapılmasına izin ver.
        </label>
    </div>

    <div class="checkbox icheck">
        <label>
            <input type="checkbox" name="games_allow_detail_page" value="1" {{ getBool($setting->games_allow_detail_page, 1, 'checked', null) }}>
            Oyun oynama sayfasından önce oyun hakkında bilgi sayfası göster.
        </label>
    </div>

    <div class="form-group"><label>Listeleme sayfalarında gösterilecek oyun sayısı</label>
        <input type="number" min="1" name="games_list_limit" class="form-control input-sm" value="{{ $setting->games_list_limit }}"></div>


    <div class="form-group"><label>Listeleme sayfalarında oyun özetinin en fazla karakter sayısı</label>
        <input type="number" min="1" name="games_summary_limit" class="form-control input-sm" value="{{ $setting->games_summary_limit }}"></div>


    <div class="form-group"><label>Oyun oynama sayfasında oyun özetinin en fazla karakter sayısı</label>
        <input type="number" min="1" name="games_summary_play" class="form-control input-sm" value="{{ $setting->games_summary_play }}"></div>

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
