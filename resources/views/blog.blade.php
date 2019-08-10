@extends('inc/master')
@section('content')
<div class="row">
    <section class="col-md-8">
    @isset($items)
    @isset($category)
    <div class="alert alert-info"><b>Kategori:</b> {{ $category->title }}</div>
    @endisset
    @foreach($items as $item)
    <div class="row blog-item">
        <div class="col-sm-4 p5">
            <a href="{{ route('blog.detail', ['slug'=>$item->slug]) }}"><img src="{{ getArticleCover($item->cover, 'sm') }}" alt="{{ $item->title }}" class="img-responsive"></a>
        </div>
        <div class="col-sm-8 p5">
            <h3 title="{{ $item->title }}"><a href="{{ route('blog.detail', ['slug'=>$item->slug]) }}" name="{{ $item->title }}">{{ $item->title }}</a></h3>
            <p>{{ $item->getSummary() }}</p>
        </div>
    </div>
    @endforeach
    @include('inc/pagination', ['item'=>$items])
    @endisset
    </section>
    @include('blog-sidebar')
</div>
@endsection
