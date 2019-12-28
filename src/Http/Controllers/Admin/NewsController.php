<?php

namespace PortedCheese\SiteNews\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PortedCheese\SiteNews\Http\Requests\NewsSettingsRequest;

class NewsController extends Controller
{
    const PAGER = 20;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->query;
        $news = News::query();
        if ($query->get('title')) {
            $title = trim($query->get('title'));
            $news->where('title', 'LIKE', "%$title%");
        }
        $news->orderBy('created_at', 'desc');
        return view("site-news::admin.news.index", [
            'news' => $news->paginate(self::PAGER)->appends($request->input()),
            'query' => $query,
            'per' => self::PAGER,
            'page' => $query->get('page', 1) - 1
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("site-news::admin.news.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->storeValidator($request->all());
        $news = News::create($request->all());
        $news->uploadImage($request, "news/main");
        return redirect()
            ->route("admin.news.show", ['news' => $news])
            ->with('success', 'Новость успешно создана');
    }

    /**
     * Валидация сохранения.
     *
     * @param $data
     */
    protected function storeValidator($data)
    {
        Validator::make($data, [
            "title" => ["required", "min:2", "max:100", "unique:news,title"],
            "slug" => ["nullable", "min:2", "max:100", "unique:news,slug"],
            "image" => ["nullable", "image"],
            "description" => ["required"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "image" => "Главное изображение",
            "description" => "Текст новости",
        ])->validate();
    }

    /**
     * Display the specified resource.
     *
     * @param  News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return view("site-news::admin.news.show", [
            'news' => $news,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        return view("site-news::admin.news.edit", [
            'news' => $news,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param News $news
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, News $news)
    {
        $this->updateValidator($request->all(), $news);
        $news->update($request->all());
        $news->uploadImage($request, "news/main");
        return redirect()
            ->route('admin.news.show', ['news' => $news])
            ->with('success', 'Успешно обновленно');
    }

    /**
     * Валидация обновления.
     *
     * @param $data
     * @param News $news
     */
    protected function updateValidator($data, News $news)
    {
        $id = $news->id;
        Validator::make($data, [
            "title" => ["required", "min:2", "max:100", "unique:news,title,{$id}"],
            "slug" => ["nullable", "min:2", "max:100", "unique:news,slug,{$id}"],
            "image" => ["nullable", "image"],
            "description" => ["required"],
        ], [], [
            'title' => 'Заголовок',
            "slug" => "Адресная строка",
            'main_image' => 'Главное изображение',
            "description" => "Текст новости",
        ])->validate();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News $news
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(News $news)
    {
        $news->delete();
        return redirect()
            ->route("admin.news.index")
            ->with('success', 'Новость успешно удалена');
    }

    /**
     * Страница метатегов.
     *
     * @param News $news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function metas(News $news)
    {
        return view('site-news::admin.news.metas', [
            'news' => $news,
        ]);
    }

    /**
     * Страница галлереи.
     *
     * @param News $news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function gallery(News $news)
    {
        return view("site-news::admin.news.gallery", [
            'news' => $news,
        ]);
    }

    /**
     * Удалить главное изображение.
     *
     * @param News $news
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteImage(News $news)
    {
        $news->clearImage();
        return redirect()
            ->back()
            ->with('success', 'Изображение удалено');
    }

    public function settings()
    {
        $config = siteconf()->get('news');
        $themes = config('theme.themes');
        return view("site-news::admin.news.settings", [
            'config' => (object) $config,
            'themes' => $themes,
        ]);
    }

    /**
     * Сохранить настройки.
     *
     * @param NewsSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveSettings(NewsSettingsRequest $request)
    {
        $config = siteconf()->get('news');
        foreach ($config as $key => $value) {
            if ($request->has($key)) {
                $config[$key] = $request->get($key);
            }
        }
        if ($request->has('theme')) {
            $config['customTheme'] = $request->get('theme');
        }
        else {
            $config['customTheme'] = null;
        }

        if ($request->has('own-admin')) {
            $config['useOwnAdminRoutes'] = true;
        }
        else {
            $config['useOwnAdminRoutes'] = false;
        }

        if ($request->has('own-site')) {
            $config['useOwnSiteRoutes'] = true;
        }
        else {
            $config['useOwnSiteRoutes'] = false;
        }

        siteconf()->save('news', $config);
        return redirect()
            ->back()
            ->with('success', "Конфигурация обновлена");
    }
}
