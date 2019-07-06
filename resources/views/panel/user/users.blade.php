@extends('panel/master')
@section('content')
<div class="row">
     <?php echo getAlert("fixed"); ?>
     <div class="col-md-12">
          <h3 class="m5 pull-left">Kullanıcı Listesi</h3>
          <a href="{{ route('panel.user.create') }}" class="btn btn-primary pull-right">Yeni Kullanıcı</a>
          <div class="clearfix"></div>
     </div>
     <div class="clearfix"></div>
     <div class="col-md-12">



     <div class="box box-default">

          <div class="box-body no-padding table-responsive">
               <table id="aswdatatable" class="table table-bordered table-hover table-striped">
                    <thead>
                         <tr>
                              <th width="25">#</th>
                              <th width="40"></th>
                              <th>Kullanıcı</th>
                              <th>Tam İsim</th>
                              <th width="100">Seviye</th>
                              <th width="160">Kayıt Tarihi</th>
                              <th style="min-width:100px; width:100px;"></th>
                         </tr>
                    </thead>
                    <tbody>

                         @if($items)
                         @foreach($items as $item)
                         <tr>
                              <td align="center">{{ $item->id }}</td>
                              <td data-search="{{ $item->description }}">
                                  <?php $smallCover = empty($item->cover)? url('images/noimg.png') : getUserCover($item->cover, 's');
                                        $largeCover = empty($item->cover)? url('images/noimg.png') : getUserCover($item->cover); ?>
                                  <a data-fancybox="gallery" href="{{ $largeCover }}" class="tableCoverImg"><img src="{{ $smallCover }}" class="img-responsive"></a>
                              </td>
                              <td data-search="{{ $item->name }}" class="title">
                                  <a href="{{ route('panel.user.edit', ['user'=>$item]) }}">{{ $item->name }}</a><br>
                                  <cite>{{ $item->email }}</cite>
                              </td>
                              <td style="max-width:100px;">{{ $item->fullname }}</td>
                              <td style="max-width:100px;">{{ $item->getLevel() }}</td>
                              <td><?php echo timestampToString($item->created_at); ?></td>
                              <td class="row p0">
                                   <div class="col-xs-4 p0"><a href="{{ route('panel.user.edit', ['user'=>$item]) }}" class="btn btn-primary btn-xs"><span class="fa fa-edit"></span></a></div>
                                   <div class="col-xs-4 p0">

                                        <a href="{{ route('panel.user.change_status', ['user'=>$item]) }}" class="ajaxChangeStatus btn btn-{{ getBool($item->status, "active", "success", "danger") }} btn-xs"><span class="fa fa-eye"></span></a>

                                   </div>
                                   <div class="col-xs-4 p0">
                                        @if( $item->status != "trash" )
                                        <a href="{{ route('panel.user.destroy', ['user'=>$item]) }}" class="btn btn-warning btn-xs"><span class="fa fa-trash-o"></span></a>
                                        @else
                                        <a href="{{ route('panel.user.destroy', ['user'=>$item]) }}" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a>
                                        @endif
                                   </div>
                              </td>
                         </tr>
                         @endforeach
                         @endif

                    </tbody>
               </table>
          </div>
     </div>
     </div>






</div>

@endsection

@section('end')
@include('panel/inc/add-datatable')
@endsection
