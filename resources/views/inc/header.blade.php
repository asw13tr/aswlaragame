<header id="header" class="navbar navbar-default navbar-fixed-top">
<div class="container">
<div class="row">
    <div class="col-xs-6 col-md-4">
        <a href="{{ url('') }}" id="logo" class="pull-left"><img src="{{ url('images/logo.png') }}" class="img-responsive"></a>
        <div id="search" class="hidden-xs">
            <form action="{{ url('') }}" method="get">
            <input type="search" name="ara" autocomplete="off" aria-label="Oyun ara" placeholder="Oyunları ara"/>
            <button class="glyphicon glyphicon-search"></button>
            </form>
        </div>
    </div>
    <div class="col-xs-6 col-md-8">
    <button id="buttonToggleMenu" class="btn btn-default glyphicon glyphicon-menu-hamburger pull-right"
        type="button" data-toggle="collapse" data-target="#collapseMobileMenu" aria-expanded="false" aria-controls="collapseMobileMenu"></button>
    <ul id="headerMenu" class="nav nav-pills hidden-sm hidden-xs">

        <?php
        $headerMenu = config('navigation.header');
        if($headerMenu){
            foreach($headerMenu as $item){
                list($title, $url) = configToNavItem($item);
                echo '<li><a href="'.$url.'">'.$title.'</a></li>';
            }
        }
        ?>
    </ul>
    </div>
</div>

<section id="collapseMobileMenu" class="collapse">
<nav id="mobileMenu">
    <?php
    $headerMenu = config('navigation.header');
    if($headerMenu){
        foreach($headerMenu as $item){
            list($title, $url) = configToNavItem($item);
            echo '<div><a href="'.$url.'">'.$title.'</a></div>';
        }
    }
    ?>
    <?php
        $gameCategories = App\GameCategory::where('status', 'published')->orderBy('title')->get();
        if($gameCategories){
            foreach($gameCategories as $item){
                echo '<div><a href="'.route("game.category", ['slug'=>$item->slug]).'">'.$item->title.'</a></div>';
            }
        }
    ?>
</nav>
</section>

</div>
</header>
