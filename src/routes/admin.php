<?php

Route::group([
    'namespace' => 'PortedCheese\SiteNews\Http\Controllers\Admin',
    'middleware' => ['web', 'role:admin|editor'],
    'as' => 'admin.',
    'prefix' => 'admin',
], function () {
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