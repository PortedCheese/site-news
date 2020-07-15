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