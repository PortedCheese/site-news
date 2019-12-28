<?php

namespace PortedCheese\SiteNews\Models;

use App\Image;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use PortedCheese\BaseSettings\Traits\HasImage;
use PortedCheese\BaseSettings\Traits\HasSlug;
use PortedCheese\SeoIntegration\Traits\HasMetas;

class News extends Model
{
    use HasImage, HasSlug, HasMetas;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short',
        'user_id',
    ];

    protected $metaKey = "news";

    protected static function boot()
    {
        parent::boot();
        static::slugBoot();
        static::imageBoot();
        static::metasBoot();

        static::creating(function (\App\News $news) {
            // Если пользователь авторизован, поставить автором.
            if (Auth::check()) {
                $news->user_id = Auth::user()->id;
            }
        });

        static::updated(function (\App\News $news) {
            // Забыть кэш.
            $news->forgetCache();
        });

        static::deleting(function (\App\News $news) {
            // Забыть кэш.
            $news->forgetCache();
        });
    }

    /**
     * Может быть автор.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Может быть изображение.
     * (переопределено из-за названия в таблице)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class, 'main_image');
    }

    /**
     * Изменить дату создания.
     *
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return datehelper()->changeTz($value);
    }

    /**
     * Получить тизер новости.
     *
     * @return string
     * @throws \Throwable
     */
    public function getTeaser($grid = 3)
    {
        $key = "news-teaser:{$this->id}-{$grid}";
        $cached = Cache::get($key);
        if (!empty($cached)) {
            return $cached;
        }
        $view = view("site-news::site.news.teaser", [
            'news' => $this,
            'grid' => $grid,
        ]);
        $html = $view->render();
        Cache::forever($key, $html);
        return $html;
    }

    /**
     * Получить галлерею.
     * @return object
     */
    public function getFullData()
    {
        $cacheKey = "news-full:{$this->id}";
        $cached = Cache::get($cacheKey);
        if (!empty($cached)) {
            return $cached;
        }
        $gallery = $this->images->sortBy('weight');
        $image = $this->image;
        $data = (object) [
            'gallery' => $gallery,
            'image' => $image,
        ];
        Cache::forever($cacheKey, $data);
        return $data;
    }

    /**
     * Очистить кэш.
     */
    public function forgetCache($full = FALSE)
    {
        if (!$full) {
            Cache::forget("news-teaser:{$this->id}-3");
            Cache::forget("news-teaser:{$this->id}-6");
        }
        Cache::forget("news-full:{$this->id}");
    }
}
