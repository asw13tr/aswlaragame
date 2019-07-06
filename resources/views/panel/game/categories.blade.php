@extends('panel/master')
@section('content')
<div class="row">
     <?php echo getAlert("fixed"); ?>
     <div class="col-md-12">
          <h3 class="m5">Oyun Kategorileri</h3>
          <?php echo listTableNavigation( route('panel.game.categories'), url(Request::getRequestUri()) ); ?>
     </div>
     <div class="clearfix"></div>
     <div class="col-md-8">



     <div class="box box-default">

          <div class="box-body no-padding table-responsive">
               <table class="table table-bordered table-hover table-striped" id="aswdatatable">
                    <thead>
                         <tr>
                              <th width="25">#</th>
                              <th width="25">#</th>
                              <th>Kategori</th>
                              <th width="120"></th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php

                         $getCategoriesWithSub = getGameCategoriesWithSub(0,-1, Request::query('s', null));
                         if($getCategoriesWithSub):
                         foreach(json_decode(json_encode($getCategoriesWithSub)) as $item): ?>
                         <tr>
                              <td>{{ $item->id }}</td>
                              <td data-search="{{ $item->description }}">
                                  <?php $smallCover = empty($item->cover)? url('images/noimg.png') : getGameCategoryCover($item->cover, 's');
                                        $largeCover = empty($item->cover)? url('images/noimg.png') : getGameCategoryCover($item->cover); ?>
                                  <a data-fancybox="gallery" href="{{ $largeCover }}" class="tableCoverImg"><img src="{{ $smallCover }}" class="img-responsive"></a>
                              </td>
                              <td><?php echo str_repeat('— ', $item->repeat); ?>{{ $item->title }}</td>
                              <td class="row p0" style="margin:0px;">
                                   <div class="col-xs-4 p0"><a href="{{ route('panel.game.category.edit', ['gameCategory'=>$item->id]) }}" class="btn btn-primary btn-xs"><span class="fa fa-edit"></span></a></div>
                                   <div class="col-xs-4 p0">
                                        @if( $item->status != "published" )
                                        <a href="{{ route('panel.game.category.published', ['gameCategory'=>$item->id]) }}" class="btn btn-danger btn-xs"><span class="fa fa-eye-slash"></span></a>
                                        @endif
                                        @if( $item->status == "published" )
                                        <a href="{{ route('panel.game.category.draft', ['gameCategory'=>$item->id]) }}" class="btn btn-success btn-xs"><span class="fa fa-eye"></span></a>
                                        @endif
                                   </div>
                                   <div class="col-xs-4 p0">
                                        @if( $item->status != "trash" )
                                        <a href="{{ route('panel.game.category.delete', ['gameCategory'=>$item->id]) }}" class="btn btn-warning btn-xs"><span class="fa fa-trash-o"></span></a>
                                        @else
                                        <a href="{{ route('panel.game.category.delete', ['gameCategory'=>$item->id]) }}" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a>
                                        @endif
                                   </div>
                              </td>
                         </tr>
                         <?php
                    endforeach;
               endif;
                         ?>

                    </tbody>
               </table>
          </div>
     </div>
     </div>







<div class="col-md-4">
<?php $coverPhotoActiveClass = (isset($category) && $category->cover)? 'active' : null ; ?>
@if( isset($category) )
     <div class=" box box-success">
     <div class="box-header with-border"><h3 class="box-title">Oyun Kategorisi Düzenle</h3></div>
     <div class="box-body">
     <?php echo getAlert('right'); ?>
     <form action="{{ route('panel.game.category.update', ['gameCategory'=>$category]) }}" method="POST" class="form" enctype="multipart/form-data">
               {{ csrf_field() }}
               {{ method_field("PATCH") }}
               <div class="form-group"><label>Kategori Adı</label>
                    <input type="text" class="form-control slugify" name="title" id="categoryTitle" required value="{{ $category->title }}">
               </div>
               <div class="form-group"><label>Url Kısaltması</label>
                    <input type="text" class="slugify_categoryTitle form-control" name="slug" required value="{{ $category->slug }}" data-slugify="disabled">
               </div>
               <div class="form-group"><label>Açıklaması</label>
                    <textarea name="description" id="" cols="30" rows="4" class="form-control">{{ $category->description }}</textarea>
               </div>
               <div class="form-group coverPhoto <?php echo $coverPhotoActiveClass; ?>" data-name="cover"><label>Kapak Fotoğrafı</label>
                    <input type="file" class="form-control" name="cover">
                    <input type="hidden" name="removeCover" value="0" />
                    <div class="null">Tıkla ve Yükle</div>
                    <div class="full" style="max-width:200px;">
                         <img src="<?php if(isset($category) && $category->cover){ echo getGameCategoryCover($category->cover, 'm'); } ?>" class="img-responsive"/>
                         <a href="javascript:void(0);" class="removePhoto btn btn-danger btn-sm btn-block">Görseli Kaldır</a>
                    </div>
               </div>
               <div class="form-group"><label>Üst Kategori</label>
                    <select name="parent" class="form-control">
                         <option value="0">Üst Kategori Yok</option>
                         <?php
                         $getCategoriesWithSub = getGameCategoriesWithSub(0,-1);
                         if($getCategoriesWithSub){
                             foreach(json_decode(json_encode($getCategoriesWithSub)) as $item){
                                 $slct = $category->parent==$item->id? 'selected' : null ;
                                 echo '<option value="'.$item->id.'" '.$slct.'>'.str_repeat('—', $item->repeat).$item->title.'</option>';
                             }
                         }
                         ?>
                    </select>
               </div>
               <div class="box-footer">
                    <button type="submit" class="btn btn-success pull-right" name="status" value="published">Güncelle</button>
                    <div class="pull-right p5"></div>
                    <button type="submit" class="btn btn-default pull-right" name="status" value="draft">Kaydet (Taslak)</button>
               </div>
     </form>
     </div>
     </div>
@else
     <div class=" box box-primary">
     <div class="box-header with-border"><h3 class="box-title">Oyun Kategorisi Oluştur</h3></div>
     <div class="box-body">
     <?php echo getAlert('right'); ?>
     <form action="{{ route('panel.game.category.store') }}" method="POST" class="form" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group"><label>Kategori Adı</label>
               <input type="text" class="form-control slugify" name="title" id="categoryTitle" required autofocus="on">
          </div>
          <div class="form-group"><label>Url Kısaltması</label>
               <input type="text" class="slugify_categoryTitle form-control" name="slug" required>
          </div>
          <div class="form-group"><label>Açıklaması</label>
               <textarea name="description" id="" cols="30" rows="4" class="form-control"></textarea>
          </div>
          <div class="form-group coverPhoto <?php echo $coverPhotoActiveClass; ?>" data-name="cover"><label>Kapak Fotoğrafı</label>
               <input type="file" class="form-control" name="cover">
               <input type="hidden" name="removeCover" value="0" />
               <div class="null">Tıkla ve Yükle</div>
               <div class="full" style="max-width:200px;">
                    <img src="<?php if(isset($category) && $category->cover){ echo getGameCategoryCover($category->cover, 'm'); } ?>" class="img-responsive"/>
                    <a href="javascript:void(0);" class="removePhoto btn btn-danger btn-sm btn-block">Görseli Kaldır</a>
               </div>
          </div>
          <div class="form-group"><label>Üst Kategori</label>
               <select name="parent" class="form-control">
                    <option value="0">Üst Kategori Yok</option>
                    <?php
                    $getCategoriesWithSub = getGameCategoriesWithSub(0,-1);
                    if($getCategoriesWithSub){
                        foreach(json_decode(json_encode($getCategoriesWithSub)) as $item){
                            echo '<option value="'.$item->id.'">'.str_repeat('—', $item->repeat).$item->title.'</option>';
                        }
                    }
                    ?>
               </select>
          </div>
          <div class="box-footer">
               <button type="submit" class="btn btn-primary pull-right" name="status" value="published">Yayımla</button>
               <div class="pull-right p5"></div>
               <button type="submit" class="btn btn-default pull-right" name="status" value="draft">Kaydet (Taslak)</button>
          </div>
     </form>
     </div>
     </div>
@endif


</div>
</div>

@endsection
@section('end')
@include('panel/inc/add-datatable')
@endsection
