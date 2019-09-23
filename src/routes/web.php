<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => "App\Http\Controllers\Vendor\SiteNews\Site",
    'as' => 'site.news.',
    'prefix' => siteconf()->get('news', "path"),
    'middleware' => ['web'],
], function () {
    if (! empty(siteconf()->get("news", "path"))) {
        Route::get('/{news}', 'NewsController@show')
            ->name('show');
        Route::get('/', 'NewsController@index')
            ->name('index');
    }
});