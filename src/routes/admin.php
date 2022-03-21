<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'App\Http\Controllers\Vendor\SiteNews\Admin',
    'middleware' => ['web', 'management'],
    'as' => 'admin.',
    'prefix' => 'admin',
], function () {

    if (base_config()->get("news", "useSections", false))
    {
        // рубрики новостей
        Route::get('/news/sections', 'NewsSectionController@index')
            ->name('newsSections.index');
        Route::get('/news/sections/create', 'NewsSectionController@create')
            ->name('newsSections.create');
        Route::post('/news/sections/store', 'NewsSectionController@store')
            ->name('newsSections.store');
        Route::get('/news/sections/{newsSection}', 'NewsSectionController@show')
            ->name('newsSections.show');
        Route::get('/news/sections/{newsSection}/edit', 'NewsSectionController@edit')
            ->name('newsSections.edit');
        Route::put('/news/sections/{newsSection}', 'NewsSectionController@update')
            ->name('newsSections.update');
        Route::delete('/news/sections/{newsSection}', 'NewsSectionController@destroy')
            ->name('newsSections.destroy');

        // Route::resource('newsSections', 'NewsSectionController',);

        // приоритет
        Route::get('news/sections/list/priority', 'NewsSectionController@priority')
            ->name("newsSections.priority");

    }

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





});