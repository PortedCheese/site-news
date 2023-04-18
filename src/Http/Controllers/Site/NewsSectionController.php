<?php

namespace PortedCheese\SiteNews\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\NewsSection;

class NewsSectionController extends Controller
{

    /**
     * Просмотр новости.
     *
     * @param NewsSection $newsSection
     * @return mixed|string
     * @throws \Throwable
     */
    public function show(Request $request, NewsSection $section)
    {
        $news = $section->news()
            ->whereNotNull('published_at')
            ->orderByDesc('fixed')
            ->orderByDesc('published_at');
        return view("site-news::site.news.sections.show", [
           "newsSection" => $section,
           "news" => $news
            ->paginate(siteconf()->get("news", "pager"))
            ->appends($request->input),
        ]);
    }
}


