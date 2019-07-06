@extends('panel/master')
@section('content')
<?php
    echo getAlert("fixed");
    $postUrl = !isset($data)? route('panel.game.store') : route('panel.game.update', ['game'=>$data]);
    $checkedAllowComments = "checked";
    if(isset($data) && $data->allow_comments=="off"){ $checkedAllowComments = null; }
    $coverPhotoActiveClass = (isset($data) && $data->cover)? 'active' : null ;
?>
<form action="{{ $postUrl }}" method="POST" class="form" enctype="multipart/form-data">
<div class="row">
<div class="col-md-12">
        @if(!isset($data))
            <h3 class="mt0">Yeni Oyun Ekle</h3>
        @else
            <h3 class="mt0">Oyun Düzenle [{{ $data->title }}]</h3>
        @endif
</div>
<div class="clearfix"></div>
{{ csrf_field() }}
<div class="col-sm-8 col-md-8 col-lg-9">
<div class="box box-primary">
<div class="box-body">

     <div class="form-group"><label>Oyun Başlığı*</label>
          <input type="text" class="form-control slugify" name="title" id="title" value="{{ @$data->title }}" required/></div>

     <div class="form-group"><label>Url yazısı</label>
          <input type="text" class="slugify_title form-control input-sm" name="slug" value="{{ @$data->slug }}" required/></div><hr>

     <div class="form-group"><label>Açıklama <cite>(Meta description)</cite></label>
          <textarea name="description" class="form-control" cols="30" rows="3">{{ @$data->description }}</textarea></div><hr>

     <div class="form-group"><label>Özet <cite>(Oyun listesi için)</cite></label>
          <textarea name="summary" class="form-control" cols="30" rows="3">{{ @$data->summary }}</textarea></div><hr>

</div>
</div>

<div class="box box-danger">
<div class="box-body">

    <div class="form-group"><label>Oyun Dosyası <cite>(.swf uzantılı flash dosyası)</cite></label>
         <input type="file" class="form-control slugify" name="game_file" />
         <?php echo getAlert('game_file');
            if( isset($data->game_file) && @!empty($data->game_file) ){
                echo '  <div class="checkbox icheck">
                            <a href="'.url(asw('path_media_game_files')."/{$data->game_file}").'" target="_blank">'.$data->game_file.'</a><br/>
                            <label><input type="checkbox" name="removeSwf"> Oyun dosyasını sil.</label>
                        </div>';
            }
         ?>

     </div>

    <div class="form-group"><label>Oyun Url <cite>(Uzak bağlantı url)</cite></label>
         <input type="text" class="form-control slugify" name="game_url" id="game_url" value="{{ @$data->game_url }}"/></div>

     <div class="form-group"><label>Oyun Kaynak Kodu <cite>(iframe, object, vs)</cite></label>
          <textarea name="game_code" class="form-control" cols="30" rows="3">{{ @$data->game_code }}</textarea></div><hr>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group"><label>Oyun Sayfası Tarzı</label>
                 <select name="game_screen" class="form-control">
                     <option value="normal" <?php if(isset($data->game_screen) && @$data->game_screen=="normal"){ echo 'selected'; } ?>>Normal Ekran</option>
                     <option value="fullsize" <?php if(isset($data->game_screen) && @$data->game_screen=="full"){ echo 'selected'; } ?>>Tam Ekran</option>
                 </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group"><label>Oyun Ölçüsü</label>
                <?php $scales =["4x3", "5x3", "2x1", "16x9", "1x2", "3x4", "3x5", "1x1"]; ?>
                 <select name="game_scale" class="form-control">
                    <?php foreach($scales as $scale){
                        $slct = ( isset($data->game_scale) && @$data->game_scale==$scale )? 'selected' : null ;
                        echo '<option value="'.$scale.'" '.$slct.'>'.$scale.'</option>';
                    } ?>
                 </select>
             </div>
        </div>
    </div>






     <div class="form-group"><label>İçerik</label>
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
                    <img src="<?php if(isset($data) && $data->cover){ echo getGameCover($data->cover, 'm'); } ?>" class="img-responsive"/>
                    <a href="javascript:void(0);" class="removePhoto btn btn-danger btn-sm btn-block">Görseli Kaldır</a>
               </div>
          </div>
          <hr>
          <div class="form-group"><label for="">Video Url</label>
               <input type="text" class="form-control" name="game_video" value="{{ @$data->game_video }}">
          </div>
     </div>
     </div>

     <div class="box box-warning">
     <div class="box-body">
          <div class="form-group">
               <label>Kategori</label>
               <div class="checkboxlist">
                <?php
                    $getCategoriesWithSub = getGameCategoriesWithSub();
                    if($getCategoriesWithSub){
                        foreach(json_decode(json_encode($getCategoriesWithSub)) as $c){
                            $checked = ( isset($checkedCategories) && in_array($c->id, $checkedCategories) )? 'checked' : null ;
                            echo '<div class="checkbox icheck"><label>'.str_repeat('       ',$c->repeat).'<input type="checkbox" name="category[]" '.$checked.' value="'.$c->id.'"> '.$c->title.'</label></div>';
                        }
                    }
                ?>
               </div>
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
         <?php if( isset($data) && Auth::user()->level == 3 ): ?>
         <div class="form-group"><label>Yazar</label>
         <select name="author" class="form-control">
             <?php foreach (getUsers([2,3], "active") as $user): ?>
                 <option value="{{ $user->id }}" {{ getBool($data->author, $user->id, 'selected', null) }}>{{ $user->name }}</option>
             <?php endforeach; ?>
         </select>
         </div><hr>
         <?php endif;?>

         <div class="form-group">
            <label for="">Zamanla <small>(Çift tıkla zamanla)</small></label>
            <div class="input-group removeDisabled">
                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                <input  type="datetime-local" disabled class="form-control pull-right"
                        min="<?php echo date('Y-m-d\TH:i'); ?>"
                        value="<?php echo isset($data->p_time)? timestampToDatetime($data->p_time) : date('Y-m-d\TH:i'); ?>"
                        name="p_time">
            </div>
            <hr>
         </div>
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
