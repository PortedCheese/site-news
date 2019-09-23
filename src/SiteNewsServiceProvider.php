<?php

namespace PortedCheese\SiteNews;

use App\News;
use Illuminate\Support\ServiceProvider;
use PortedCheese\BaseSettings\Events\ImageUpdate;
use PortedCheese\SiteNews\Console\Commands\NewsMakeCommand;
use PortedCheese\SiteNews\Filters\NewsShowMain;
use PortedCheese\SiteNews\Listeners\ClearCacheOnUpdateImage;

class SiteNewsServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // Подгрузка миграций.
         $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

         // Подгрузка шаблонов.
         $this->loadViewsFrom(__DIR__ . '/resources/views', 'site-news');

         // Копирование шаблонов.
        $this->publishes([
            __DIR__ . '/resources/views/site/news' => resource_path('views/vendor/site-news/site/news'),
        ], 'views-site');
        $this->publishes([
            __DIR__ . '/resources/views/admin/news' => resource_path('views/vendor/site-news/admin/news'),
        ], 'views-admin');

        // Подгрузка роутов.
         $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');
         $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Console.
        if ($this->app->runningInConsole()) {
            $this->commands([
                NewsMakeCommand::class,
            ]);
        }

        // Подключаем метатеги.
        $seo = app()->config['seo-integration.models'];
        $seo['news'] = News::class;
        app()->config['seo-integration.models'] = $seo;

        // Подключаем галлерею.
        $gallery = app()->config['gallery.models'];
        $gallery['news'] = News::class;
        app()->config['gallery.models'] = $gallery;

        $imagecache = app()->config['imagecache.paths'];
        $imagecache[] = 'storage/gallery/news';
        $imagecache[] = 'storage/news/main';
        app()->config['imagecache.paths'] = $imagecache;

        $imagecache = app()->config['imagecache.templates'];
        $imagecache['news-main'] = NewsShowMain::class;
        app()->config['imagecache.templates'] = $imagecache;

        // Подписаться на обновление изображений.
        $this->app['events']->listen(ImageUpdate::class, ClearCacheOnUpdateImage::class);
    }

    public function register()
    {

    }

}
