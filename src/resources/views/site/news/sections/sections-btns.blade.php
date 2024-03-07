@if (! empty(base_config()->get("news", "useSections", false)))
    <div class="col-12">
        <ul class="list-inline news-sections">
            @foreach ($sections as $section)
                <a href="{{ route("site.news.sections.show", ['section' => $section]) }}"
                   class="btn btn-secondary px-4 py-2 my-1 news-sections__link{{ (isset(request()->section) && $section->slug ==  request()->section->slug) ? " disabled" : "" }}">
                    <li class="news-sections__item">
                        {{ $section->title }}
                    </li>
                </a>
            @endforeach
        </ul>
    </div>
@endif
