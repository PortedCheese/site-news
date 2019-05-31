<?php

namespace PortedCheese\SiteNews\Models;

use App\Image;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use PortedCheese\SeoIntegration\Models\Meta;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'short',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($news) {
            // Удаляем главное изображение.
            $news->clearMainImage();
            // Чистим галлерею.
            $news->clearImages();
            // Удаляем метатеги.
            $news->clearMetas();
            // Забыть кэш.
            $news->forgetCache();
        });

        static::updated(function ($news) {
            // Забыть кэш.
            $news->forgetCache();
        });

        static::creating(function ($news) {
            // Если пользователь авторизован, поставить автором.
            if (Auth::check()) {
                $news->user_id = Auth::user()->id;
            }
        });

        static::created(function ($news) {
            // Создать метатеги по умолчанию.
            $news->createDefaultMetas();
        });
    }

    /**
     * Может быть автор.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Может быть изображение.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo('App\Image', 'main_image');
    }

    /**
     * Галлерея.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images() {
        return $this->morphMany('App\Image', 'imageable');
    }

    /**
     * Метатеги.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function metas() {
        return $this->morphMany('PortedCheese\SeoIntegration\Models\Meta', 'metable');
    }

    /**
     * Подгружать по slug.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Создать метатеги по умолчанию.
     */
    public function createDefaultMetas()
    {
        $result = Meta::getModel('news', $this->id, "title");
        if ($result['success'] && !empty($this->title)) {
            $meta = Meta::create([
                'name' => 'title',
                'content' => $this->title,
            ]);
            $meta->metable()->associate($this);
            $meta->save();
        }
        $result = Meta::getModel('news', $this->id, "description");
        if ($result['success'] && !empty($this->short)) {
            $meta = Meta::create([
                'name' => 'description',
                'content' => $this->short,
            ]);
            $meta->metable()->associate($this);
            $meta->save();
        }
    }

    /**
     * Удаляем созданные теги.
     */
    public function clearMetas()
    {
        foreach ($this->metas as $meta) {
            $meta->delete();
        }
    }

    /**
     * Изменить/создать главное изображение.
     *
     * @param $request
     */
    public function uploadMainImage($request)
    {
        if ($request->hasFile('main_image')) {
            $this->clearMainImage();
            $path = $request->file('main_image')->store('news/main');
            $image = Image::create([
                'path' => $path,
                'name' => 'news-main-' . $this->id,
            ]);
            $this->image()->associate($image);
            $this->save();
        }
    }

    /**
     * Удалить изображение.
     */
    public function clearMainImage()
    {
        $image = $this->image;
        if (!empty($image)) {
            $image->delete();
        }
        $this->image()->dissociate();
        $this->save();
    }

    /**
     * Удалить все изображения.
     */
    public function clearImages()
    {
        foreach ($this->images as $image) {
            $image->delete();
        }
    }

    /**
     * Получить тизер новости.
     *
     * @return string
     * @throws \Throwable
     */
    public function getTeaser($grid = 3)
    {
        $cached = Cache::get("news-teaser:{$this->id}-{$grid}");
        if (!empty($cached)) {
            return $cached;
        }
        $view = view("site-news::site.news.teaser", [
            'news' => $this,
            'grid' => $grid,
        ]);
        $html = $view->render();
        Cache::forever("news-teaser:{$this->id}", $html);
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
