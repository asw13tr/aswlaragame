<?php
return [

    // ÜST MENÜ
    'header' => [
        [
            'title' => '<em class="glyphicon glyphicon-home"></em> Anasayfa',
            'route'   => 'frontpage'
        ],
        [
            'title' => '<em class="glyphicon glyphicon-comment"></em> Blog</a>',
            'route'   => 'blog'
        ],
        [
            'title' => '<em class="glyphicon glyphicon-fire"></em> Yeni Oyunlar</a>',
            'route'   => 'game.list.last'
        ],
        [
            'title' => '<em class="glyphicon glyphicon-signal"></em> En İyileri</a>',
            'route'   => 'game.list.best'
        ],
        [
            'title' => '<em class="glyphicon glyphicon-star"></em> Popüler</a>',
            'route'   => 'game.list.popular'
        ],
        [
            'title' => '<em class="glyphicon glyphicon-road"></em> İletişim</a>',
            'route'   => ['page', ['slug' => 'iletisim']]
        ]
    ],







    // EN ALT MENU
    'footer' => [
        [
            'title' => '<em class="glyphicon glyphicon-home"></em> Anasayfa',
            'route'   => 'frontpage'
        ],
        [
            'title' => '<em class="glyphicon glyphicon-comment"></em> Blog</a>',
            'route'   => 'blog'
        ],
        [
            'title' => '<em class="glyphicon glyphicon-fire"></em> Yeni Oyunlar</a>',
            'route'   => 'game.list.last'
        ],
        [
            'title' => '<em class="glyphicon glyphicon-signal"></em> En İyileri</a>',
            'route'   => 'game.list.best'
        ],
        [
            'title' => '<em class="glyphicon glyphicon-star"></em> Popüler</a>',
            'route'   => 'game.list.popular'
        ],
        [
            'title' => '<em class="glyphicon glyphicon-road"></em> İletişim</a>',
            'route'   => ['page', ['slug' => 'iletisim']]
        ]
    ],

];
?>
