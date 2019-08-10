@extends('inc/master')
@section('content')
<div id="title"><h5>
<?php
if(isset($category)):
    echo  $category->title;
else:
?>
    TÜM OYUNLAR
<?php endif; ?>


</h5><span>{{ $totalGameCount }} ücretsiz oyun</span></div>
<div class="row">
@if($games)
@foreach($games as $game)
<section class="col-xs-6 col-sm-3 col-md-2 glitem">
    <a href="{{ route('game', ['slug'=>$game->slug]) }}">
        <img src="{{ getGameCover($game->cover, 'sm') }}" alt="{{ $game->title }}" class="img-responsive">
        <div class="info">
        <h3>{{ $game->title }}</h3>
        <span>Puan: <b>%{{ $game->getLike() }} </b> - Oynanma: <b>{{ $game->views }}</b></span>
        </div>
    </a>
</section>
@endforeach
<div class="clearfix"></div>
@include('inc/pagination', ['item'=>$games])
@if( $totalGameCount < 1 )
<div class="alert alert-danger">Hiç oyunn bulunamadı</div>
@endif
@endif
</div>
@endsection
