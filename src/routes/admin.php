<?php

if (! siteconf()->get('news.useOwnAdminRoutes')) {
    Route::group([
        'namespace' => 'PortedCheese\SiteNews\Http\Controllers\Admin',
        'middleware' => ['web', 'role:admin|editor'],
        'as' => 'admin.',
        'prefix' => 'admin',
    ], function () {
        Route::get('news/settings', "NewsController@settings")
            ->name('news.settings');
        Route::put('news/settings', "NewsController@saveSettings")
            ->name('news.settings-save');

        Route::resource('news', 'NewsController');

        Route::group([
            'prefix' => 'news/{news}',
            'as' => 'news.show.',
        ], function () {
            Route::get('metas', 'NewsController@metas')
                ->name('metas');
            Route::get('gallery', 'NewsController@gallery')
                ->name('gallery');
            Route::delete('delete-image', 'NewsController@deleteImage')
                ->name('delete-image');
        });
    });
}

if (! siteconf()->get('news.useOwnSiteRoutes')) {
    Route::group([
        'namespace' => "PortedCheese\SiteNews\Http\Controllers\Site",
        'as' => 'site.news.',
        'prefix' => !empty(siteconf()->get('news.path')) ? siteconf()->get('news.path') : 'news',
        'middleware' => ['web'],
    ], function () {
        Route::get('/{news}', 'NewsController@show')
            ->name('show');
        Route::get('/', 'NewsController@index')
            ->name('index');
    });
}