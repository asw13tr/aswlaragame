@extends('panel/master')
@section('content')
<?php
    echo getAlert("fixed");
    $postUrl = !isset($data)? route('panel.page.store') : route('panel.page.update', ['page'=>$data]);
    $checkedHideCover = (isset($data) && $data->hide_cover=="on")? 'checked' : null;
    $checkedAllowComments = "checked";
    if(isset($data) && $data->allow_comments=="off"){ $checkedAllowComments = null; }
    $coverPhotoActiveClass = (isset($data) && $data->cover)? 'active' : null ;
?>
<form action="{{ $postUrl }}" method="POST" class="form" enctype="multipart/form-data">
<div class="row">
<div class="col-md-12">
        @if(!isset($data))
            <h3 class="mt0">Yeni Sayfa Oluştur</h3>
        @else
            <h3 class="mt0">Sayfa Düzenle [{{ $data->title }}]</h3>
        @endif
</div>
<div class="clearfix"></div>
{{ csrf_field() }}
<div class="col-sm-8 col-md-8 col-lg-9">
<div class="box box-primary">
<div class="box-body">

     <div class="form-group"><label>Sayfa Başlığı*</label>
          <input type="text" class="form-control slugify" name="title" id="title" value="{{ @$data->title }}" required/></div>

     <div class="form-group"><label>Url yazısı</label>
          <input type="text" class="slugify_title form-control input-sm" name="slug" value="{{ @$data->slug }}" required/></div><hr>

     <div class="form-group"><label>Açıklama <small>Meta description</small></label>
          <textarea name="description" class="form-control" cols="30" rows="3">{{ @$data->description }}</textarea></div><hr>


     <div class="form-group"><label>İçerik</label><br/>
         <button type="button" class="mediaBoxButton btn btn-default btn-md mb5"><em class="fa fa-photo"></em> Medya Dosyaları</button>
          <textarea name="content" class="richeditor" cols="30" rows="10">{{ @$data->content }}</textarea>
     </div>

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
                    <img src="<?php if(isset($data) && $data->cover){ echo getPageCover($data->cover, 'm'); } ?>" class="img-responsive"/>
                    <a href="javascript:void(0);" class="removePhoto btn btn-danger btn-sm btn-block">Görseli Kaldır</a>
               </div>
          </div>
          <hr>
          <div class="checkbox icheck">
               <label><input type="checkbox" name="hide_cover" {{ $checkedHideCover }} class="minimal-red"> Detayda kapak fotoğrafını gizle</label>
          </div>
          <hr>
          <div class="form-group"><label for="">Video Url</label>
               <input type="text" class="form-control" name="video" value="{{ @$data->video }}">
          </div>
     </div>
     </div>

     <div class="box box-warning">
     <div class="box-body">
          <div class="form-group"><label>Üst Sayfa</label>
               <select name="parent" class="form-control">
                    <option value="0">Üst Sayfa Yok</option>
                    <?php
                    if($pages){
                        foreach(json_decode(json_encode($pages)) as $item){
                            $slct = (isset($data->parent) && @$data->parent==$item->data->id)? 'selected' : null ;
                            echo '<option value="'.$item->data->id.'" '.$slct.'>'.str_repeat('—', $item->repeat).$item->data->title.'</option>';
                        }
                    }
                    ?>
               </select>
          </div>
     </div>
     </div>


     <div class="box ">
     <div class="box-body">
     <div class="checkbox icheck">
          <label><input type="checkbox" {{ $checkedAllowComments }} name="allow_comments"> Yorumlara izin ver</label>
     </div>
     </div>
     </div>

     <div class="box box-success">
     <div class="box-body">
     <div class="row p10">
         <div class="form-group">
            <label for="">Zamanla <small>(Çift tıkla zamanla)</small></label>
            <div class="input-group removeDisabled">
                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                <input  type="datetime-local" disabled class="form-control pull-right"
                        min="<?php echo date('Y-m-d\TH:i'); ?>"
                        value="<?php echo isset($data->p_time)? timestampToDatetime($data->p_time) : date('Y-m-d\TH:i'); ?>"
                        name="p_time">
            </div>
         </div>
         <hr>

         @include('panel/inc/form-action-buttons')
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
