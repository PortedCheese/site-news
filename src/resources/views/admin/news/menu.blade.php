@can("viewAny", \App\NewsSection::class)
    @if (base_config()->get("news", "useSections", false))
        @if ($theme == "sb-admin")
            @php($active = strstr($currentRoute, 'admin.news') !== FALSE)
            <li class="nav-item dropdown{{ $active ? ' active' : '' }}">
                <a class="nav-link"
                   href="#"
                   data-bs-toggle="collapse"
                   data-bs-target="#collapse-news-sections-menu"
                   aria-controls="#collapse-news-sections-menu"
                   aria-expanded="{{ $active ? "true" : "false" }}">
                    @isset($ico)
                        <i class="{{ $ico }}"></i>
                    @endisset
                    <span>{{ base_config()->get("news","stitle") }}</span>
                </a>
                <div id="collapse-news-sections-menu" class="collapse{{ $active ? " show" : "" }}" data-bs-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a href="{{ route('admin.news.index') }}"
                           class="collapse-item{{ strstr($currentRoute, 'admin.news.') !== FALSE  ? " active" : "" }}">
                            <span>{{ base_config()->get("news","stitle") }}</span>
                        </a>
                        <a href="{{ route('admin.newsSections.index') }}"
                           class="collapse-item{{strstr($currentRoute, 'admin.newsSections') !== FALSE ? ' active' : '' }}">
                            <span>Секции</span>
                        </a>
                    </div>
                </div>
            </li>
        @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle{{ strstr($currentRoute, 'admin.news') !== FALSE ? ' active' : '' }}"
                   href="#"
                   id="user-dropdown"
                   role="button"
                   data-bs-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false">
                    @isset($ico)
                        <i class="{{ $ico }}"></i>
                    @endisset
                    {{ base_config()->get("news","stitle") }}
                </a>
                <div class="dropdown-menu" aria-labelledby="user-dropdown">
                    <a href="{{ route('admin.news.index') }}"
                       class="dropdown-item">
                        {{ base_config()->get("news","stitle") }}
                    </a>
                    <a href="{{ route('admin.newsSections.index') }}"
                       class="dropdown-item">
                        Секции
                    </a>
                </div>
            </li>
        @endif

        @else

        @can("viewAny", \App\News::class)
            <li class="nav-item">
                <a href="{{ route('admin.news.index') }}"
                   class="nav-link{{ strstr($currentRoute, 'admin.news') !== FALSE ? ' active' : '' }}">
                    @isset($ico)
                        <i class="{{ $ico }}"></i>
                    @endisset
                    <span>{{ base_config()->get("news","stitle") }}</span>
                </a>
            </li>
        @endcan
    @endif

@endcan