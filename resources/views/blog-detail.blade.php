@extends('inc/master')
@section('content')
<div class="row">
    <section class="col-md-8">
    @isset($item)
    <div id="game-info" class="game-box">
        <h1 class="title" title="{{ $item->title }}">{{ $item->title }}</h1>
        <div class="clearfix"></div>
        <small>{{ timestampToString($item->p_time) }} tarihinde yazıldı {{ $item->views }} kez okundu.</small>
        <hr>
        <div><img src="{{ getArticleCover($item->cover, 'lg') }}" alt="{{ $item->title }}" class="img-responsive"></div>
        <hr>
        <?php echo $item->content; ?>

    </div>

    @endisset
    </section>
    @include('blog-sidebar')
</div>
@endsection
