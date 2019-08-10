@extends('inc/master')
@section('content')
<div class="row">
    <div class="col-md-1"></div>
    <section class="col-md-10" id="game-fullscreen-single">
    <div id="game-desc" class="game-box">
        <h1  title="{{ $page->title }}">{{ $page->title }}</h1><hr>
        <?php echo $page->content; ?>
    </div>
    </section>
</div>
@endsection
