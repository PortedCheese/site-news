<?php

namespace PortedCheese\SiteNews\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Meta;
use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Просмотр новости.
     *
     * @param News $news
     * @return mixed|string
     * @throws \Throwable
     */
    public function show(News $news)
    {
        $newsData = $news->getFullData();
        return view("site-news::site.news.show", [
            'news' => $news,
            'pageMetas' => Meta::getByModelKey($news),
            'gallery' => $newsData->gallery,
            'image' => $newsData->image,
        ]);
    }

    /**
     * Все новости.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $news = News::query()->where("published", 1)->orderBy('created_at', 'desc');
        return view("site-news::site.news.index", [
            'news' => $news
                ->paginate(base_config()->get("news", "pager", 20))
                ->appends($request->input()),
            'pageMetas' => Meta::getByPageKey('news'),
        ]);
    }
}


