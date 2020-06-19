<?php

use Illuminate\Support\Facades\Route;

if (! empty(base_config()->get("news", "path", false))) {
    Route::group([
        'namespace' => "App\Http\Controllers\Vendor\SiteNews\Site",
        'as' => 'site.news.',
        'prefix' => siteconf()->get('news', "path", "news"),
        'middleware' => ['web'],
    ], function () {
        Route::get('/{news}', 'NewsController@show')
            ->name('show');
        Route::get('/', 'NewsController@index')
            ->name('index');
    });
}