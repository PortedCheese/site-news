<?php

namespace PortedCheese\SiteNews\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Meta;
use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Все новости.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $collection = News::query()
            ->whereNotNull("published_at")
            ->orderBy('published_at', 'desc');
        $news = $collection
            ->paginate(base_config()->get("news", "pager", 20))
            ->appends($request->input());
        $pageMetas = Meta::getByPageKey('news');
        return view("site-news::site.news.index", compact("news", "pageMetas"));
    }

    /**
     * Просмотр новости.
     *
     * @param News $news
     * @return mixed|string
     * @throws \Throwable
     */
    public function show(News $news)
    {
        if (empty($news->published_at)) {
            abort(404);
        }
        $newsData = $news->getFullData();
        $pageMetas = Meta::getByModelKey($news);
        $gallery = $newsData->gallery;
        $image = $newsData->image;
        return view("site-news::site.news.show", compact("news", "pageMetas", "gallery", "image"));
    }
}


