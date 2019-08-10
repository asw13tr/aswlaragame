<?php

Route::get('',"MainController@index")->name('frontpage');
Route::get('oyun/{slug}', "MainController@game")->name('game');
Route::get('kategori/{slug}', "MainController@category")->name('game.category');
Route::post('oyla/oyun/{id}/{oy}', "MainController@ajaxGameVote")->name('game.vote');
Route::get('en-iyi-oyunlar', "MainController@bestGames")->name('game.list.best');
Route::get('en-cok-oynanan-oyunlar', "MainController@popularGames")->name('game.list.popular');
Route::get('en-yeni-oyunlar', "MainController@lastGames")->name('game.list.last');

Route::get('blog', "BlogController@index")->name('blog');
Route::get('blog/{slug}/kategori', "BlogController@filterCategory")->name('blog.category');
Route::get('blog/{slug}', "BlogController@detail")->name('blog.detail');

//PAROLA SIFIRLAMA İŞLEMLERİ
Route::post('/password-reset-update/{user}',        "PasswordResetController@passwordResetFormPost"     )->name('password.reset.update.post');

// KURULUM YÖNLENDİRMELERİ
Route::prefix('setup')->group(function(){
    Route::get('', "SetupController@welcome")->name('setup');
    Route::get('database', "SetupController@database")->name('setup.database');
    Route::post('database', "SetupController@databasePost")->name('setup.databasePost');
    Route::get('migrate', "SetupController@migrate")->name('setup.migrate');
    Route::get('config', "SetupController@config")->name('setup.config');
    Route::get('general', "SetupController@general")->name('setup.general');
    Route::post('general', "SetupController@generalPost")->name('setup.generalPost');
    Route::get('administrator', "SetupController@administrator")->name('setup.administrator');
    Route::post('administrator', "SetupController@administratorPost")->name('setup.administratorPost');
    Route::get('finish', "SetupController@finish")->name('setup.finish');
});



//MAIN ROUTE
Route::group(['middleware', 'aswMiddleware'], function(){
$prePanel = !env('APP_SETUP', false)? 'aswpanel' : asw('pre_panel_url');

// YÖNETİCİ PANELİ GRUBU
Route::get($prePanel.'/login',                 "Panel\LogonController@login"               )->name('panel.login');
Route::post($prePanel.'/login',                "Panel\LogonController@loginPost"           )->name('panel.loginPost');
Route::get($prePanel.'/register',              "Panel\LogonController@register"            )->name('panel.register');
Route::post($prePanel.'/register',             "Panel\LogonController@registerPost"        )->name('panel.registerPost');
Route::get($prePanel.'/register-success',      "Panel\LogonController@registerSuccess"     )->name('panel.registerSuccess');
Route::get($prePanel.'/password-reset',        "PasswordResetController@passwordResetPanel"     )->name('panel.passwordReset');
Route::post($prePanel.'/password-reset',        "PasswordResetController@passwordResetPanelPost"     )->name('panel.passwordResetPost');
Route::get($prePanel.'/password-reset-sent',   "PasswordResetController@passwordResetPanelPostSuccess"     )->name('panel.passwordResetPostSuccess');
Route::get($prePanel.'/password-reset/{email}/{token}',        "PasswordResetController@passwordResetPanelForm"     )->name('panel.passwordResetForm');
Route::prefix($prePanel)->middleware('panelLoginControl')->group(function(){

        Route::get('',                      "Panel\MainController@index"          )->name('panel.dashboard');
        Route::get('logout',                "Panel\LogonController@logout"              )->name('panel.logout');

        // YÖNETİCİ PANELİ BLOG YÖNETİMİ YÖNLENDİRMELERİ
        Route::prefix('/blog')->group(function(){
                Route::get('categories',                            "Panel\BlogCategoryController@index")->name('panel.blog.categories');
                Route::post('categories',                           "Panel\BlogCategoryController@store")->name('panel.blog.category.store');
                Route::get('category/{blogCategory}/edit',          "Panel\BlogCategoryController@edit")->name('panel.blog.category.edit');
                Route::patch('category/{blogCategory}/edit',        "Panel\BlogCategoryController@update")->name('panel.blog.category.update');
                Route::get('category/{blogCategory}/destroy',       "Panel\BlogCategoryController@destroy")->name('panel.blog.category.delete');
                Route::get('category/{blogCategory}/published',     "Panel\BlogCategoryController@published")->name('panel.blog.category.published');
                Route::get('category/{blogCategory}/draft',         "Panel\BlogCategoryController@draft")->name('panel.blog.category.draft');

                Route::get('',                                                  "Panel\ArticleController@index")->name('panel.blog.articles');
                Route::get('article/create',                                    "Panel\ArticleController@create")->name("panel.blog.article.create");
                Route::post('article/create',                                   "Panel\ArticleController@store")->name("panel.blog.article.store");
                Route::get('article/{article}/edit',                            "Panel\ArticleController@edit")->name('panel.blog.article.edit');
                Route::post('article/{article}/update',                         "Panel\ArticleController@update")->name('panel.blog.article.update');
                Route::get('article/{article}/destroy',                         "Panel\ArticleController@destroy")->name('panel.blog.article.destroy');
                Route::get('article/{article}/change_cover_visibilty',          "Panel\ArticleController@change_cover_visibilty")->name('panel.blog.article.change_cover_visibilty');
                Route::get('article/{article}/change_comments_permissions',     "Panel\ArticleController@change_comments_permissions")->name('panel.blog.article.change_comments_permissions');
                Route::get('article/{article}/change_status',                   "Panel\ArticleController@change_status")->name('panel.blog.article.change_status');
        });


        // YÖNETİCİ PANELİ OYUN YÖNETİMİ YÖNLENDİRMELERİ
        Route::prefix('/game')->group(function(){
                Route::get('categories', "Panel\GameCategoryController@index")->name('panel.game.categories');
                Route::post('categories', "Panel\GameCategoryController@store")->name('panel.game.category.store');
                Route::get('category/{gameCategory}/edit', "Panel\GameCategoryController@edit")->name('panel.game.category.edit');
                Route::patch('category/{gameCategory}/edit', "Panel\GameCategoryController@update")->name('panel.game.category.update');
                Route::get('category/{gameCategory}/destroy', "Panel\GameCategoryController@destroy")->name('panel.game.category.delete');
                Route::get('category/{gameCategory}/published', "Panel\GameCategoryController@published")->name('panel.game.category.published');
                Route::get('category/{gameCategory}/draft', "Panel\GameCategoryController@draft")->name('panel.game.category.draft');

                Route::get('', "Panel\GameController@index")->name('panel.game.games');
                Route::get('create', "Panel\GameController@create")->name("panel.game.create");
                Route::post('create', "Panel\GameController@store")->name("panel.game.store");
                Route::get('{game}/edit', "Panel\GameController@edit")->name('panel.game.edit');
                Route::post('{game}/update', "Panel\GameController@update")->name('panel.game.update');
                Route::get('{game}/destroy', "Panel\GameController@destroy")->name('panel.game.destroy');
                Route::get('{game}/change_comments_permissions', "Panel\GameController@change_comments_permissions")->name('panel.game.change_comments_permissions');
                Route::get('{game}/change_status', "Panel\GameController@change_status")->name('panel.game.change_status');
        });


        // YÖNETİCİ PANELİ SAYFA YÖNETİMİ YÖNLENDİRMELERİ
        Route::prefix('/page')->group(function(){
                Route::get('', "Panel\PageController@index")->name('panel.page.pages');
                Route::get('create', "Panel\PageController@create")->name("panel.page.create");
                Route::post('create', "Panel\PageController@store")->name("panel.page.store");
                Route::get('{page}/edit', "Panel\PageController@edit")->name('panel.page.edit');
                Route::post('{page}/update', "Panel\PageController@update")->name('panel.page.update');
                Route::get('{page}/destroy', "Panel\PageController@destroy")->name('panel.page.destroy');
                Route::get('{page}/change_cover_visibilty', "Panel\PageController@change_cover_visibilty")->name('panel.page.change_cover_visibilty');
                Route::get('{page}/change_comments_permissions', "Panel\PageController@change_comments_permissions")->name('panel.page.change_comments_permissions');
                Route::get('{page}/change_status', "Panel\PageController@change_status")->name('panel.page.change_status');
        });


        // YÖNETİCİ PANELİ SAYFA YÖNETİMİ YÖNLENDİRMELERİ
        Route::prefix('/user')->group(function(){
                Route::get('', "Panel\UserController@index")->name('panel.user.users');
                Route::get('create', "Panel\UserController@create")->name("panel.user.create");
                Route::post('create', "Panel\UserController@store")->name("panel.user.store");
                Route::get('{user}/edit', "Panel\UserController@edit")->name('panel.user.edit');
                Route::post('{user}/update', "Panel\UserController@update")->name('panel.user.update');
                Route::get('profile', "Panel\UserController@profile")->name('panel.user.profile');
                Route::post('profile', "Panel\UserController@profilePost")->name('panel.user.profilePost');
                Route::get('{user}/destroy', "Panel\UserController@destroy")->name('panel.user.destroy');
                Route::get('{user}/change_status', "Panel\UserController@change_status")->name('panel.user.change_status');
        });

        // YÖNETİCİ PANELİ AYARLAR YÖNLENDİRMELERİ
        Route::prefix('settings')->group(function(){
                Route::get('general', "Panel\SettingController@general")->name('panel.setting.general');
                Route::post('general', "Panel\SettingController@generalPost")->name('panel.setting.generalPost');

                Route::get('content', "Panel\SettingController@content")->name('panel.setting.content');
                Route::post('content', "Panel\SettingController@contentPost")->name('panel.setting.contentPost');

                Route::get('media', "Panel\SettingController@media")->name('panel.setting.media');
                Route::post('media', "Panel\SettingController@mediaPost")->name('panel.setting.mediaPost');

                Route::get('contact', "Panel\SettingController@contact")->name('panel.setting.contact');
                Route::post('contact', "Panel\SettingController@contactPost")->name('panel.setting.contactPost');
        });

        // YÖNETİCİ PANELİ MEDYA SAYFASI
        Route::prefix('media')->group(function(){
            Route::get('', "Panel\MediaController@index")->name('panel.media');
        });


        // YÖNETİCİ PANELİİ AJAX İŞLEMLERİ
        Route::prefix('ajax')->group(function(){
            Route::post('image-upload', "Panel\AjaxController@imageUpload")->name('panel.ajax.image.upload');
            Route::get('mediabox', "Panel\AjaxController@mediaBox")->name('panel.ajax.media.box');
            Route::post('mediabox/update', "Panel\AjaxController@mediaBoxImageUpdate")->name('panel.ajax.media.box.image.update');
            Route::post('mediabox/destroy', "Panel\AjaxController@mediaBoxImageDestroy")->name('panel.ajax.media.box.image.destroy');
        });



}); // YÖNETİCİ PANELİ YÖNLENDİRME GRUBU SONU




// KURULUM YÖNLENDİRMELERİ
Route::prefix('setup')->group(function(){
    Route::get('', "SetupController@welcome")->name('setup.welcome');
    Route::get('database', "SetupController@database")->name('setup.database');
    Route::post('database', "SetupController@databasePost")->name('setup.databasePost');
    Route::get('config', "SetupController@config")->name('setup.config');
});

Auth::routes();



}); //END MAIN ROUTE
Route::get('{slug}',"MainController@page")->name('page');
