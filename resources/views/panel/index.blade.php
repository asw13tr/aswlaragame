@extends("panel/master")
@section('content')


<div class="row">
<?php // ##################### SON YAZILAN YAZILAR ?>
<div class="col-md-6">
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Son Yazılanlar</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
        <table class="table no-margin">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Yazı</th>
                    <th>Durum</th>
                    <th class="text-center"><span class="fa fa-eye"></span></th>
                    <th width="67"></th>
                </tr>
            </thead>
            <tbody>
                @if($lastArticles) @foreach($lastArticles as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td><?php echo getStatusLabel($item->status); ?></td>
                    <td class="text-center">{{ $item->views }}</td>
                    <td>
                        <a href="{{ route('panel.blog.article.edit', ['article'=>$item]) }}" class="fa fa-eye btn btn-xs btn-success"></a>
                        @if(auth()->user()->level > 2 || request()->user()->id==$item->author)
                        <a href="{{ route('panel.blog.article.edit', ['article'=>$item]) }}" class="fa fa-edit btn btn-xs btn-primary"></a>
                        @endif
                    </td>
                </tr>
                @endforeach @endif
            </tbody>
        </table>
        </div>
    </div>
    <div class="box-footer clearfix">
    <a href="{{ route('panel.blog.article.create') }}" class="btn btn-sm btn-info btn-flat pull-left">Yeni Yazı</a>
    <a href="{{ route('panel.blog.articles') }}" class="btn btn-sm btn-default btn-flat pull-right">Hepsini Gör</a>
    </div>
</div>
</div>


<?php // ##################### SON EKLENEN OYUNLAR ?>
<div class="col-md-6">
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Son Eklenen Oyunlar</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
        <table class="table no-margin">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Yazı</th>
                    <th>Durum</th>
                    <th class="text-center"><span class="fa fa-eye"></span></th>
                    <th width="67"></th>
                </tr>
            </thead>
            <tbody>
                @if($lastGames) @foreach($lastGames as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td><?php echo getStatusLabel($item->status); ?></td>
                    <td class="text-center">{{ $item->views }}</td>
                    <td>
                        <a href="{{ route('panel.game.edit', ['game'=>$item]) }}" class="fa fa-eye btn btn-xs btn-success"></a>
                        @if(auth()->user()->level > 2 || request()->user()->id==$item->author)
                        <a href="{{ route('panel.game.edit', ['game'=>$item]) }}" class="fa fa-edit btn btn-xs btn-primary"></a>
                        @endif
                    </td>
                </tr>
                @endforeach @endif
            </tbody>
        </table>
        </div>
    </div>
    <div class="box-footer clearfix">
    <a href="{{ route('panel.game.create') }}" class="btn btn-sm btn-info btn-flat pull-left">Oyun Ekle</a>
    <a href="{{ route('panel.game.games') }}" class="btn btn-sm btn-default btn-flat pull-right">Hepsini Gör</a>
    </div>
</div>
</div>
</div>




@endsection
