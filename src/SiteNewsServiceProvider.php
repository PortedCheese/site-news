<?php

namespace PortedCheese\SiteNews;

use App\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use PortedCheese\SeoIntegration\Models\Meta;
use PortedCheese\SiteNews\Console\Commands\NewsMakeCommand;
use PortedCheese\SiteNews\Console\Commands\NewsOverrideCommand;
use PortedCheese\SiteNews\Models\News;

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

        // Console.
        if ($this->app->runningInConsole()) {
            $this->commands([
                NewsMakeCommand::class,
                NewsOverrideCommand::class,
            ]);
        }

        // Подключаем метатеги.
        $seo = app()->config['seo-integration.models'];
        $seo['news'] = 'PortedCheese\SiteNews\Models\News';
        app()->config['seo-integration.models'] = $seo;

        // Подключаем галлерею.
        $gallery = app()->config['gallery.models'];
        $gallery['news'] = 'PortedCheese\SiteNews\Models\News';
        app()->config['gallery.models'] = $gallery;

        $imagecache = app()->config['imagecache.paths'];
        $imagecache[] = 'storage/gallery/news';
        $imagecache[] = 'storage/news/main';
        app()->config['imagecache.paths'] = $imagecache;

        $this->forgetImages();
    }

    /**
     * Еcли у новости обновили изображения, нужно почистить кэш.
     * @param $image
     */
    private function checkImage($image)
    {
        if (empty($image->imageable)) {
            return;
        }
        $morph = $image->imageable;
        $class = get_class($morph);
        if ($class == "PortedCheese\SiteNews\Models\News") {
            $morph->forgetCache(TRUE);
        }
    }

    /**
     * Если обновили изображение, возможно надо сбросить кеш.
     */
    private function forgetImages()
    {
        Image::created(function ($image) {
            $this->checkImage($image);
        });
        Image::updated(function ($image) {
            $this->checkImage($image);
        });
        Image::deleting(function ($image) {
            $this->checkImage($image);
        });
    }

    public function register()
    {

    }

}
