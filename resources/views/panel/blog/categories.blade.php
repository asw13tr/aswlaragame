@extends('panel/master')
@section('content')
<div class="row">
     <?php echo getAlert("fixed"); ?>
     <div class="col-md-12">
          <h3 class="m5">Kategori Listesi</h3>
          <?php echo listTableNavigation( route('panel.blog.categories'), url(Request::getRequestUri()) ); ?>
     </div>
     <div class="clearfix"></div>
     <div class="col-md-8">



     <div class="box box-default">

          <div class="box-body no-padding table-responsive">
               <table class="table table-bordered table-hover table-striped" id="aswdatatable">
                    <thead>
                         <tr>
                              <th width="25">#</th>
                              <th>Kategori</th>
                              <th width="120"></th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php
                         $getCategoriesWithSub = getCategoriesWithSub(0,-1, Request::query('s', null));
                         if($getCategoriesWithSub):
                         foreach(json_decode(json_encode($getCategoriesWithSub)) as $item): ?>
                         <tr>
                              <td>{{ $item->id }}</td>
                              <td><?php echo str_repeat('— ', $item->repeat); ?>{{ $item->title }}</td>
                              <td class="row p0" style="margin:0px;">
                                   <div class="col-xs-4 p0"><a href="{{ route('panel.blog.category.edit', ['blogCategory'=>$item->id]) }}" class="btn btn-primary btn-xs"><span class="fa fa-edit"></span></a></div>
                                   <div class="col-xs-4 p0">
                                        @if( $item->status != "published" )
                                        <a href="{{ route('panel.blog.category.published', ['blogCategory'=>$item->id]) }}" class="btn btn-danger btn-xs"><span class="fa fa-eye-slash"></span></a>
                                        @endif
                                        @if( $item->status == "published" )
                                        <a href="{{ route('panel.blog.category.draft', ['blogCategory'=>$item->id]) }}" class="btn btn-success btn-xs"><span class="fa fa-eye"></span></a>
                                        @endif
                                   </div>
                                   <div class="col-xs-4 p0">
                                        @if( $item->status != "trash" )
                                        <a href="{{ route('panel.blog.category.delete', ['blogCategory'=>$item->id]) }}" class="btn btn-warning btn-xs"><span class="fa fa-trash-o"></span></a>
                                        @else
                                        <a href="{{ route('panel.blog.category.delete', ['blogCategory'=>$item->id]) }}" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a>
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
@if( isset($category) )
     <div class=" box box-success">
     <div class="box-header with-border"><h3 class="box-title">Kategori Düzenle</h3></div>
     <div class="box-body">
     <?php echo getAlert('right'); ?>
     <form action="{{ route('panel.blog.category.update', ['blogCategory'=>$category]) }}" method="POST" class="form">
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
               <div class="form-group"><label>Üst Kategori</label>
                    <select name="parent" class="form-control">
                         <option value="0">Üst Kategori Yok</option>
                         <?php
                         $getCategoriesWithSub = getCategoriesWithSub(0,-1);
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
     <div class="box-header with-border"><h3 class="box-title">Kategori Oluştur</h3></div>
     <div class="box-body">
     <?php echo getAlert('right'); ?>
     <form action="{{ route('panel.blog.category.store') }}" method="POST" class="form">
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
          <div class="form-group"><label>Üst Kategori</label>
               <select name="parent" class="form-control">
                    <option value="0">Üst Kategori Yok</option>
                    <?php
                    $getCategoriesWithSub = getCategoriesWithSub(0,-1);
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
