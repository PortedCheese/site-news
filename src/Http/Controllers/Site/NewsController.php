<?php

namespace PortedCheese\SiteNews\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PortedCheese\SeoIntegration\Models\Meta;
use PortedCheese\SiteNews\Models\News;

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
            'customTheme' => siteconf()->get('news.customTheme'),
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
        $news = News::query()->orderBy('created_at', 'desc');
        return view("site-news::site.news.index", [
            'customTheme' => siteconf()->get('news.customTheme'),
            'news' => $news
                ->paginate(siteconf()->get('reviews.pager'))
                ->appends($request->input()),
            'pageMetas' => Meta::getByPageKey('news'),
        ]);
    }
}

