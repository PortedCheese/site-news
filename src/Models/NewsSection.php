<?php

namespace PortedCheese\SiteNews\Models;

use App\News;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PortedCheese\BaseSettings\Traits\HasSlug;
use PortedCheese\SeoIntegration\Traits\ShouldMetas;


class NewsSection extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = ["slug", "title"];

    protected static function boot()
    {
        parent::boot();
        static::slugBoot();
        static::deleting(function (self $model){
            $model->news()->sync([]);
        });
    }

    /**
     * Новости по тегу
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function news()
    {
        return $this->belongsToMany(News::class);
    }
}
