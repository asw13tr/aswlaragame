<?php
$actualUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . ":/".@$_SERVER['HTTP_HOST'];
$GLOBALS['aswConfig'] = [

    // GENEL SİTE AYARLARI
    'url'                       => $actualUrl,
    'title'                     => 'Atabaş Software',
    'description'               => '',
    'author'                    => 'Atabassoft',
    'refresh'                   => 0,
    'site_offline'              => 0,
    'site_offline_message'      => 'Site bakım aşamasındadır.',
    'allow_register'            => 1,
    'allow_register_panel'      => 1,


    // İLETİŞİM & MAİL AYARLARI
    'contact_email'             => 'examplemail@atabassoft.com',
    'contact_sender_mail'       => 'examplemail@atabassoft.com',
    'contact_sender_name'       => 'Atabaş Software',
    'mail_driver'               => 'smtp',
    'mail_host'                 => 'smtp.gmail.com',
    'mail_port'                 => '587',
    'mail_username'             => 'gmail-hesabiniz@gmail.com',
    'mail_password'             => 'gmail-parolanız',
    'mail_encryption'           => 'tls',

    // MEDYA AYARLARI
    'path_media'                => 'media',
    'path_media_upload'         => 'media/upload',
    'path_media_page'           => 'media/page',
    'path_media_user'           => 'media/user',
    'path_media_article'        => 'media/article',
    'path_media_game'           => 'media/game',
    'path_media_game_category'  => 'media/game-category',
    'path_media_game_files'     => 'media/game-file',

    'img_allow_original'        => 1,
    'img_lg_crop'               => 0,
    'img_lg_quality'            => 90,
    'img_lg_w'                  => 1024,
    'img_lg_h'                  => 768,
    'img_md_crop'               => 0,
    'img_md_quality'            => 90,
    'img_md_w'                  => 700,
    'img_md_h'                  => 500,
    'img_sm_crop'               => 1,
    'img_sm_quality'            => 90,
    'img_sm_w'                  => 500,
    'img_sm_h'                  => 300,

    // İÇERİK AYARLARI
    'pages_allow_comments'       => 1,

    'articles_allow_commens'    => 1,
    'articles_list_limit'       => 10,
    'articles_summary_limit'    => 33,

    'games_allow_commens'       => 1,
    'games_allow_detail_page'   => 1,
    'games_list_limit'          => 10,
    'games_summary_limit'       => 33,
    'games_summary_play'        => 512,

    // PANEL AYARLARI
    'pre_panel_url'             => 'aswpanel'

];
function asw($key, $default=null){
    $item = App\Config::where('key', $key);
    return ($item->count() < 1)? $default :  $item->first()->val;
}
?>
