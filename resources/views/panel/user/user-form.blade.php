@extends('panel/master')
@section('content')
<?php
    echo getAlert("fixed");
    $postUrl = !isset($data)? route('panel.user.store') : route('panel.user.update', ['user'=>$data]);
    $coverPhotoActiveClass = (isset($data) && $data->cover)? 'active' : null ;
?>
<form action="{{ $postUrl }}" method="POST" class="form" enctype="multipart/form-data">
<div class="row">
<div class="col-md-12">
        @if(!isset($data))
            <h3 class="mt0">Yeni Kullanıcı Oluştur</h3>
        @else
            <h3 class="mt0">Düzenle [{{ $data->name }}]</h3>
        @endif
</div>
<div class="clearfix"></div>
{{ csrf_field() }}
<div class="col-sm-8 col-md-8 col-lg-9">
<div class="box box-primary">
<div class="box-body">

     <div class="form-group"><label>Kullanıcı Adı*</label>
          <input type="text" class="form-control thisslug" name="name" value="{{ @$data->name }}" required/></div>

     <div class="form-group"><label>E-posta Adresi*</label>
          <input type="email" class="slugify_title form-control input-sm" name="email" value="{{ @$data->email }}" required/></div><hr>

     <div class="form-group"><label>Ad & Soyad</label>
          <input type="text" class="form-control input-sm" name="fullname" value="{{ @$data->fullname }}"/></div><hr>

     <div class="form-group"><label>Parola <?php echo isset($data)? '<cite>(Parola değiştirilmeyecekse boş bırakın.)</cite>' : '*'; ?></label>
          <input type="password" class="form-control input-sm" <?php echo isset($data)? 'name="change_password"' : 'name="password" required'; ?>/>
          <label
                class="togglePassword nos btn bg-purple btn-sm"
                data-name="<?php echo isset($data)? 'change_password' : 'password'; ?>">
                <em class="fa fa-eye"></em>
                Göster/Gizle
            </label>

      </div><hr>

     <div class="form-group"><label>Açıklama</label>
          <textarea name="description" class="form-control" cols="30" rows="10">{{ @$data->description }}</textarea>
     </div>

</div>
</div>

<div class="box box-success">
<div class="box-body">
    <?php $others = isset($data)? json_decode($data->datas, false) : [];
    ?>
    <div class="form-group"><label>Website</label>
        <input type="text" name="others[website]" class="form-control" value="{{ @$others->website }}"></div>

    <div class="form-group"><label>Facebook</label>
        <input type="text" name="others[facebook]" class="form-control" value="{{ @$others->facebook }}"></div>

    <div class="form-group"><label>Twitter</label>
        <input type="text" name="others[twitter]" class="form-control" value="{{ @$others->twitter }}"></div>

    <div class="form-group"><label>Instagram</label>
        <input type="text" name="others[instagram]" class="form-control" value="{{ @$others->instagram }}"></div>

    <div class="form-group"><label>Youtube</label>
        <input type="text" name="others[youtube]" class="form-control" value="{{ @$others->youtube }}"></div>

    <div class="form-group"><label>Linkedin</label>
        <input type="text" name="others[linledin]" class="form-control" value="{{ @$others->linledin }}"></div>

    <div class="form-group"><label>Pinterest</label>
        <input type="text" name="others[pinterest]" class="form-control" value="{{ @$others->pinterest }}"></div>



</div>
</div>
</div>



<div class="col-sm-4 col-md-4 col-lg-3">
     <div class="box box-info">
     <div class="box-body">

          <div class="form-group coverPhoto <?php echo $coverPhotoActiveClass; ?>" data-name="cover"><label>Kapak Fotoğrafı</label>
               <input type="file" class="form-control" name="cover">
               <input type="hidden" name="removeCover" value="0" />
               <div class="null">Tıkla ve Yükle</div>
               <div class="full">
                    <img src="<?php if(isset($data) && $data->cover){ echo getUserCover($data->cover, 'm'); } ?>" class="img-responsive"/>
                    <a href="javascript:void(0);" class="removePhoto btn btn-danger btn-sm btn-block">Görseli Kaldır</a>
               </div>
          </div>
          <hr>
          <div class="form-group"><label for="">Doğum Tarihi</label>
                <input type="date" name="birthday" class="form-control" value="{{ @$data->birthday }}"></div>
            <div class="form-group"><label>Cinsiyet</label>
                <select name="gender" class="form-control">
                    <option <?php echo getBool(@$data->gender, 'Belirtilmedi', 'selected', null); ?> value="Belirtilmedi">Belirtilmedi</option>
                    <option <?php echo getBool(@$data->gender, 'Erkek', 'selected', null); ?> value="Erkek">Erkek</option>
                    <option <?php echo getBool(@$data->gender, 'Kadın', 'selected', null); ?> value="Kadın">Kadın</option>
                </select>
            </div>


     </div>
     </div>



     <div class="box box-success">
     <div class="box-body">

    <div class="form-group"><label for="">Hesap Seviyesi</label>
         <select name="level" class="form-control">
             <option <?php echo getBool(@$data->level, '1', 'selected', null); ?> value="1">Kullanıcı</option>
             <option <?php echo getBool(@$data->level, '2', 'selected', null); ?> value="2">Yetkili</option>
             <option <?php echo getBool(@$data->level, '3', 'selected', null); ?> value="3">Yönetici</option>
             <option <?php echo getBool(@$data->level, '0', 'selected', null); ?> value="0">Yasaklı Üye</option>
         </select>
    </div>

    <div class="form-group"><label for="">Hesap Durumu</label>
         <select name="status" class="form-control">
             <option <?php echo getBool(@$data->status, 'active', 'selected', null); ?> value="active">Aktif</option>
             <option <?php echo getBool(@$data->status, 'passive', 'selected', null); ?> value="passive">Pasif</option>
             <option <?php echo getBool(@$data->status, 'trash', 'selected', null); ?> value="trash">Çöp</option>
         </select>
    </div>

     <div class="row p10">
          <div class="col-xs-12 p3">
              @if( isset($data) )
                  <button class="btn btn-success btn-block p2 pt7 pb7 balon" title="Güncelle"><span class="fa fa-user-plus"></span>Hesabı Güncelle</button>
              @else
                  <button class="btn btn-primary btn-block p2 pt7 pb7 balon" title="Oluştur"><span class="fa fa-user-plus"></span> Hesabı Oluştur</button>
              @endif
          </div>
     </div>
     </div>
     </div>

</div>
</div>
</form>
@endsection

@section("end")
@include("panel/inc/add-richeditor")
@endsection
