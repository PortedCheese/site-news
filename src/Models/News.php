<?php

namespace PortedCheese\SiteNews\Models;

use App\NewsTag;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use PortedCheese\BaseSettings\Traits\ShouldGallery;
use PortedCheese\BaseSettings\Traits\ShouldImage;
use PortedCheese\BaseSettings\Traits\ShouldSlug;
use PortedCheese\SeoIntegration\Traits\ShouldMetas;

class News extends Model
{
    use ShouldImage, ShouldSlug, ShouldMetas, ShouldGallery;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short',
        'user_id',
    ];
    protected $metaKey = "news";
    protected $imageKey = "main_image";

    protected static function booting()
    {
        parent::booting();

        static::creating(function (\App\News $model) {
            // Если пользователь авторизован, поставить автором.
            if (Auth::check()) {
                $model->user_id = Auth::user()->id;
            }
            $model->published_at = now();
        });

        static::updated(function (\App\News $model) {
            // Забыть кэш.
            $model->forgetCache();
        });

        static::deleting(function (\App\News $model) {
            // Забыть кэш.
            $model->forgetCache();

            $model->tags()->sync([]);
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
     * Изменить дату создания.
     *
     * @param $value
     * @return string
     */
    public function getPublishedAtAttribute($value)
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
        $model = $this;
        $news = Cache::rememberForever($key, function () use ($model) {
            $image = $model->image;
            return $model;
        });
        $view = view("site-news::site.news.teaser", [
            'news' => $news,
            'grid' => $grid,
        ]);
        return $view->render();
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
        $tags = $this->tags;
        $data = (object) [
            'gallery' => $gallery,
            'image' => $image,
            "tags" => $tags,
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

    /**
     * Теги новости
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     */
    public function tags()
    {
        return $this->belongsToMany(NewsTag::class);
    }

    /**
     * Есть ли тег у новости
     *
     * @param $id
     * @return mixed
     */

    public function hasTag($id)
    {
        return $this->tags->where('id',$id)->count();
    }

    /**
     * Обновить теги новости.
     *
     * @param $userInput
     */
    public function updateTags($userInput, $new = false)
    {
        $tagIds = [];
        foreach ($userInput as $key => $value) {
            if (strstr($key, "check-") == false) {
                continue;
            }
            $tagIds[] = $value;
        }
        $this->tags()->sync($tagIds);
        $this->forgetCache();
    }
}
