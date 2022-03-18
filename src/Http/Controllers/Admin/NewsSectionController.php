<?php

namespace PortedCheese\SiteNews\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\NewsSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsSectionController extends Controller
{
    const PAGER = 20;

    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(NewsSection::class, "newsSection");

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
        $newsSections = NewsSection::query();
        if ($query->get('title')) {
            $title = trim($query->get('title'));
            $newsSections->where('title', 'LIKE', "%$title%");
        }
        $newsSections->orderBy('priority');
        return view("site-news::admin.newsSections.index", [
            'newsSectionsList' => $newsSections->paginate(self::PAGER)->appends($request->input()),
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
        return view("site-news::admin.newsSections.create");
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
        $newsSection = NewsSection::create($request->all());
        return redirect()
            ->route("admin.newsSections.show", ['newsSection' => $newsSection])
            ->with('success', 'Секция успешно создана');
    }

    /**
     * Валидация сохранения.
     *
     * @param $data
     */
    protected function storeValidator($data)
    {
        Validator::make($data, [
            "title" => ["required", "min:2", "max:100", "unique:news_sections,title"],
            "slug" => ["nullable", "min:2", "max:100", "unique:news_sections,slug"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
        ])->validate();
    }

    /**
     * Display the specified resource.
     *
     * @param  NewsSection  $newsSection
     * @return \Illuminate\Http\Response
     */
    public function show(NewsSection $newsSection)
    {
        return view("site-news::admin.newsSections.show", [
            'newsSection' => $newsSection,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  NewsSection  $newsSection
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsSection $newsSection)
    {
        return view("site-news::admin.newsSections.edit", [
            'newsSection' => $newsSection,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param NewsSection $newsSection
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, NewsSection $newsSection)
    {
        $this->updateValidator($request->all(), $newsSection);
        $newsSection->update($request->all());
        return redirect()
            ->route('admin.newsSections.show', ['newsSection' => $newsSection])
            ->with('success', 'Успешно обновлено');
    }

    /**
     * Валидация обновления.
     *
     * @param $data
     * @param NewsSection $newsSection
     */
    protected function updateValidator($data, NewsSection $newsSection)
    {
        $id = $newsSection->id;
        Validator::make($data, [
            "title" => ["required", "min:2", "max:100", "unique:news_sections,title,{$id}"],
            "slug" => ["nullable", "min:2", "max:100", "unique:news_sections,slug,{$id}"],
        ], [], [
            'title' => 'Заголовок',
            "slug" => "Адресная строка",
        ])->validate();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param NewsSection $newsSection
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(NewsSection $newsSection)
    {
        if (! $newsSection->news()->firstOrFail()) {
            $newsSection->delete();
            return redirect()
                ->route("admin.newsSections.index")
                ->with('success', 'Успешно удалено');
        }
        return redirect()
            ->route("admin.newsSections.index")
            ->with('success', 'Секция не может быть удалена, есть объекты');
    }


    /**
     * Страница метатегов.
     *
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function priority()
    {
        $this->authorize("update", NewsSection::class);

        $newsSections = NewsSection::query()
            ->orderBy('priority')
            ->get();

        $groups = [];

        foreach ($newsSections as $item) {
            $groups[] = [
                "name" => $item->title,
                "id" => $item->id,
            ];
        }

        return view('site-news::admin.newsSections.priority', [
            'groups' => $groups,
        ]);
    }

}
