<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'App\Http\Controllers\Vendor\SiteNews\Admin',
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