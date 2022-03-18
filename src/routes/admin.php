<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'App\Http\Controllers\Vendor\SiteNews\Admin',
    'middleware' => ['web', 'management'],
    'as' => 'admin.',
    'prefix' => 'admin',
], function () {
    Route::resource('news', 'NewsController');

    Route::put("news/{news}/publish", "NewsController@publish")
        ->name("news.publish");

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


    if (base_config()->get("news", "useSections", false))
    {
        // рубрики новостей
        Route::resource('newsSections', 'NewsSectionController');

        // приоритет
        Route::get('newsSections/list/priority', 'NewsSectionController@priority')
            ->name("newsSections.priority");

    }


});