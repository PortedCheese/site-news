<ul class="nav nav-tabs mb-2">
    <li class="nav-item">
        <a class="nav-link{{ $currentRoute == 'admin.news.show' ? ' active' : '' }}"
           href="{{ route('admin.news.show', ['news' => $news]) }}">
            Просмотр
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ $currentRoute == 'admin.news.show.gallery' ? ' active' : '' }}"
           href="{{ route('admin.news.show.gallery', ['news' => $news]) }}">
            Галерея
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link{{ $currentRoute == 'admin.news.show.metas' ? ' active' : '' }}"
           href="{{ route('admin.news.show.metas', ['news' => $news]) }}">
            Метатеги
        </a>
    </li>
</ul>