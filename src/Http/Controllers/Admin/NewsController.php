<?php

namespace PortedCheese\SiteNews\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Meta;
use App\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    const PAGER = 20;

    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(News::class, "news");
    }

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
        $news->orderBy('fixed', 'desc');
        $news->orderBy('published_at', 'desc');
        return view("site-news::admin.news.index", [
            'newsList' => $news->paginate(self::PAGER)->appends($request->input()),
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
        // Перевод с локальнного времени
        if ($news->published_at){
            $news->published_at = $this->dateTimeLocalToUTC($news->published_at);
            $news->save();
        }
        $news->uploadImage($request, "news/main");
        $news->updateSections($request->all(), true);
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
            "published_at" => ["nullable", "min:10", "max:20"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "image" => "Главное изображение",
            "description" => "Текст новости",
            "published_at" => "Дата публикации",
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
        // Перевод с локальнного времени 
        if ($news->published_at){
            $news->published_at = $this->dateTimeLocalToUTC($news->published_at);
            $news->save();
        }
        $news->uploadImage($request, "news/main");
        $news->updateSections($request->all(), true);

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
            "published_at" => ["nullable", "min:10", "max:20"],
        ], [], [
            'title' => 'Заголовок',
            "slug" => "Адресная строка",
            'main_image' => 'Главное изображение',
            "description" => "Текст новости",
            "published_at" => "Дата публикации",
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function metas(News $news)
    {
        $this->authorize("update", $news);
        $this->authorize("viewAny", Meta::class);
        return view('site-news::admin.news.metas', [
            'news' => $news,
        ]);
    }

    /**
     * Страница галлереи.
     *
     * @param News $news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function gallery(News $news)
    {
        $this->authorize("update", $news);
        return view("site-news::admin.news.gallery", [
            'news' => $news,
        ]);
    }

    /**
     * Удалить главное изображение.
     *
     * @param News $news
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deleteImage(News $news)
    {
        $this->authorize("update", $news);
        $news->clearImage();
        return redirect()
            ->back()
            ->with('success', 'Изображение удалено');
    }

    /**
     * Изменить статус публикации.
     *
     * @param News $news
     * @return \Illuminate\Http\RedirectResponse
     */
    public function publish(News $news)
    {
        $news->published_at = $news->published_at ? null : date('Y-m-d H:i');
        $news->save();

        return redirect()
            ->back()
            ->with("Статус публикации изменен");
    }

    /**
     * Изменить фиксацию в списке.
     *
     * @param News $news
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fix(News $news)
    {
        $news->fixed = $news->fixed ? null : 1;
        $news->save();

        return redirect()
            ->back()
            ->with("Фиксация изменена");
    }

    /**
     * Получить дату публикации в UTC из  datetime-local(+3) input & TZ (+3)
     *
     * @return string
     */
    protected function dateTimeLocalToUTC($string)
    {
        $carbon = Carbon::createFromFormat("Y-m-d H:i:s",  $string)->timezone(datehelper()->timeZone);
        $utcInt = - intval($carbon->format('O'))*2;
        $carbon = $carbon->timezone("$utcInt");
        return $carbon->toDateTimeString();
    }
}
