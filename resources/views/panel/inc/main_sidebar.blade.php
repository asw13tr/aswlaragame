<?php $user = Auth::user();
$fullLevel = 3;
?>
<aside class="main-sidebar">
<section class="sidebar">
<?php /*
<!-- search form (Optional) -->
<form action="#" method="get" class="sidebar-form">
<div class="input-group">
<input type="text" name="q" class="form-control" placeholder="Hızlı Arama">
<span class="input-group-btn">
<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
</button>
</span>
</div>
</form>
<!-- /.search form -->
*/ ?>
<!-- Sidebar Menu -->
<ul class="sidebar-menu" data-widget="tree">


    <li><a href="{{ route('panel.dashboard') }}"><i class="fa fa-dashboard"></i> <span>Başlangıç</span></a></li>


    <li class="header">İÇERİK</li>
    @if($user->level==$fullLevel)
    <li><a href="{{ route('panel.page.pages') }}"><i class="fa fa-file-text-o"></i> <span>Sayfalar</span></a></li>
    @endif

    <li class="treeview <?php if( strpos(url()->current(), "/blog") ){ echo 'active menu-open'; } ?>">
        <a href="#"><i class="fa fa-align-left"></i> <span>Yazılar</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
        <ul class="treeview-menu">
            <li><a href="{{ route('panel.blog.article.create') }}"><i class="fa fa-plus"></i> Yeni Yazı</a></li>
            <li><a href="{{ route('panel.blog.articles') }}"><i class="fa fa-align-left"></i> Tüm Yazılar</a></li>
            <?php echo getBool($user->level, $fullLevel, '<li><a href="'.route("panel.blog.categories").'"><i class="fa fa-sitemap"></i> Kategoriler</a></li>', null); ?>
        </ul>
    </li>

    <li class="treeview <?php if( strpos(url()->current(), "/game") ){ echo 'active menu-open'; } ?>">
        <a href="#"><i class="fa fa-gamepad"></i> <span>Oyunlar</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
        <ul class="treeview-menu">
            <li><a href="{{ route('panel.game.create') }}"><i class="fa fa-plus-circle"></i> Yeni Oyun</a></li>
            <li><a href="{{ route('panel.game.games') }}"><i class="fa fa-list"></i> Tüm Oyunlar</a></li>
            <?php echo getBool($user->level, $fullLevel, '<li><a href="'.route("panel.game.categories").'"><i class="fa fa-sitemap"></i> Kategoriler</a></li>', null); ?>
        </ul>
    </li>

    @if($user->level == $fullLevel)
    <li class="header">GENEL</li>

    <li class="treeview <?php if( strpos(url()->current(), "/user") ){ echo 'active menu-open'; } ?>">
        <a href="#"><i class="fa fa-users"></i> <span>Kullanıcılar</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
        <ul class="treeview-menu">
            <li><a href="{{ route('panel.user.create') }}"><i class="fa fa-user-plus"></i> Yeni Kullanıcı</a></li>
            <li><a href="{{ route('panel.user.users') }}"><i class="fa fa-list"></i> Tüm Kullanıcılar</a></li>
        </ul>
    </li>

    <li class="treeview <?php if( strpos(url()->current(), "/settings") ){ echo 'active menu-open'; } ?>">
        <a href="#"><i class="fa fa-cogs"></i> <span>Ayarlar</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
        <ul class="treeview-menu">
            <li><a href="{{ route('panel.setting.general') }}"><i class="fa fa-circle-o"></i> Genel</a></li>
            <li><a href="{{ route('panel.setting.content') }}"><i class="fa fa-circle-o"></i> İçerik</a></li>
            <li><a href="{{ route('panel.setting.media') }}"><i class="fa fa-circle-o"></i> Medya</a></li>
            <li><a href="{{ route('panel.setting.contact') }}"><i class="fa fa-circle-o"></i> İletişim & Mail</a></li>
        </ul>
    </li>

    <li><a href="{{ route('panel.media') }}"><i class="fa fa-photo"></i> <span>Medya</span></a></li>
    @endif

    <li class="header">SİTE</li>
    <li><a href="{{ route('frontpage') }}" target="_blank"><i class="fa fa-desktop"></i> <span>Siteyi Aç</span></a></li>


</ul>
</section>
</aside>
