<?php

use Illuminate\Support\Facades\Route;

if (! empty(base_config()->get("news", "path", false))) {
    Route::group([
        'namespace' => "App\Http\Controllers\Vendor\SiteNews\Site",
        'as' => 'site.news.',
        'prefix' => siteconf()->get('news', "path", "news"),
        'middleware' => ['web'],
    ], function () {
        // 301 to site news
        if (! empty(base_config()->get("news", "useSections", false))) {
        Route::get('/sections', function () {
            return redirect(route("site.news.index"), 301);
        });
        }
        Route::get('/{news}', 'NewsController@show')
            ->name('show');
        Route::get('/', 'NewsController@index')
            ->name('index');

        //news sections
        if (! empty(base_config()->get("news", "useSections", false))) {
            Route::group([
                'as' => 'sections.',
                'prefix' => 'sections',
            ], function () {
                Route::get('/{section}', 'NewsSectionController@show')
                    ->name('show');
            });
        }
        else {
            Route::get('/sections/{section}', function () {
                return redirect(route("site.news.index"), 301);
            });
        }
    });
}
