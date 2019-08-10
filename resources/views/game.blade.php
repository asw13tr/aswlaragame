@extends('inc/master')
@section('content')
<div class="row">
    <!-- SOL KISIM -->
    <section class="col-md-8" id="game-single">
    <div id="scaleToObjGame" class="text-center wb p10 mb10">
        <label>Ölçek %100</label>
        <input type="range" min="0" max="200" step="5" value="100">
    </div>
    <div id="game-obj" class="scaleto scale-{{ $game->game_scale }}">
        <input type="hidden" id="objWidth" />
        <input type="hidden" id="objHeight" />
        <?php echo $game->getGame(); ?>
    </div>

    <!-- OYUN BİLGİLERİ -->
    <div id="game-info" class="game-box">
        <h1 class="title" title="{{ $game->title }}">{{ $game->title }}</h1>
        <div id="game-info-buttons" class="hidden-xs">
            <button onclick="jsShowScaleBar()" class="btn btn-default btn-xs"><em class="glyphicon glyphicon-search"></em> Boyutlandır</button>
            <button onclick="jsFocus()" class="btn btn-default btn-xs"><em class="glyphicon glyphicon-lamp"></em> Odaklan</button>
        </div>
        <div class="clearfix"></div>
        <small>{{ timestampToString($game->p_time) }} tarihinde eklendi {{ $game->views }} kez oynandı.</small>
    </div>

    <!-- OYUNU BEĞENDİN Mİ -->
    <div id="game-likes" class="game-box">
        <h4 class="title">Bu oyunu beğendiniz mi?</h4><hr>
        <div class="row mt15">
            <div class="col-sm-5">
                <?php if(!$voteCookie): ?>
                <button class="btn btn-success gameVoteButton" data-url="{{ route('game.vote', ['id'=>$game->id, 'oy'=>'olumlu']) }}"><em class="glyphicon glyphicon-thumbs-up"></em> Evet</button>
                <button class="btn btn-danger gameVoteButton" data-url="{{ route('game.vote', ['id'=>$game->id, 'oy'=>'olumsuz']) }}"><em class="glyphicon glyphicon-thumbs-down"></em> Hayır</button>
                <?php else: ?>
                    <label for="" class="label label-success">Oyunuz için teşekkürler (:</label>
                <?php endif; ?>
            </div>
            <div class="col-sm-7">
                <div class="row">
                    <div class="col-xs-11">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success progress-bar-striped" style="width: {{ $game->getLike() }}%"></div>
                            <div class="progress-bar progress-bar-danger progress-bar-striped" style="width: {{ $game->getDislike() }}%"></div>
                        </div>
                    </div>
                    <div class="col-xs-1 pl0" style="line-height: 33px;"><small><b>{{ $game->getLike() }}%</b></small></div>
                </div>

            </div>
        </div>
    </div>

    <div id="game-desc" class="game-box">
        <h4 class="title">Oyun açıklaması</h4><hr>
        <?php echo $game->content; ?>
    </div>




    </section>
    <!-- SOL KISIM SON -->



    <!-- SAĞ KISIM -->
    <aside class="col-md-4">

        @isset($relatedGames)
        <div class="row">
            @foreach($relatedGames as $game)
            <section class="col-xs-6 col-sm-3 col-md-6 glitem">
                <a href="{{ $game->getUrl() }}">
                    <img src="{{ getGameCover($game->cover, 'sm') }}" class="img-responsive">
                    <div class="info"><h3>{{ $game->title }}</h3><span>Puan: <b>%{{ $game->getLike() }}</b> - Oynanma: <b>{{ $game->views }}</b></span></div>
                </a>
            </section>
            @endforeach
        </div>
        @endisset

    </aside>
    <!-- SAĞ KISIM SON -->
</div>
@endsection


@section('end')
<script>
$(function(){


    $('button.gameVoteButton').on('click', function(){
        var url = $(this).data('url');
        var obje = $(this);
        $.ajax({
            url: url,
            type: 'POST',
            data: null,
            success: function(cvp){
                if(cvp==1){
                    obje.after('<div class="label label-success">Oyunuz alındı. Teşekkürler :)</div>');
                    $('button.gameVoteButton').remove();
                }
            }
        });
    });


});
</script>
@endsection
