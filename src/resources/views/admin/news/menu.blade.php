<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle{{ strstr($currentRoute, 'admin.news') !== FALSE ? ' active' : '' }}"
       href="#"
       id="user-dropdown"
       role="button"
       data-toggle="dropdown"
       aria-haspopup="true"
       aria-expanded="false">
        Новости
    </a>
    <div class="dropdown-menu" aria-labelledby="user-dropdown">
        <a href="{{ route('admin.news.index') }}"
           class="dropdown-item">
            Список
        </a>
        <a href="{{ route('admin.news.create') }}"
           class="dropdown-item">
            Создать
        </a>
    </div>
</li>