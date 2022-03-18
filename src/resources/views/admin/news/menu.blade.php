@can("viewAny", \App\NewsSection::class)
    @if (base_config()->get("news", "useSections", false))
        @if ($theme == "sb-admin")
            @php($active = strstr($currentRoute, 'admin.news') !== FALSE)
            <li class="nav-item dropdown{{ $active ? ' active' : '' }}">
                <a class="nav-link"
                   href="#"
                   data-toggle="collapse"
                   data-target="#collapse-news-sections-menu"
                   aria-controls="#collapse-news-sections-menu"
                   aria-expanded="{{ $active ? "true" : "false" }}">
                    @isset($ico)
                        <i class="{{ $ico }}"></i>
                    @endisset
                    <span>Новости</span>
                </a>
                <div id="collapse-news-sections-menu" class="collapse{{ $active ? " show" : "" }}" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a href="{{ route('admin.news.index') }}"
                           class="collapse-item{{ $currentRoute == "admin.news.index" ? " active" : "" }}">
                            <span>Новости</span>
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
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false">
                    @isset($ico)
                        <i class="{{ $ico }}"></i>
                    @endisset
                    Новости
                </a>
                <div class="dropdown-menu" aria-labelledby="user-dropdown">
                    <a href="{{ route('admin.news.index') }}"
                       class="dropdown-item">
                        Новости
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
                    <span>Новости</span>
                </a>
            </li>
        @endcan
    @endif

@endcan