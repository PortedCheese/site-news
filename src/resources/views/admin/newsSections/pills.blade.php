<div class="col-12 mb-2">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills">
                @can("viewAny", \App\NewsSection::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.newsSections.index") }}"
                           class="nav-link{{ $currentRoute === "admin.newsSections.index" ? " active" : "" }}">
                            Секции
                        </a>
                    </li>
                @endcan
                @can("update", \App\NewsSection::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.newsSections.priority") }}"
                           class="nav-link{{ $currentRoute === "admin.newsSections.priority" ? " active" : "" }}">
                            Приоритет
                        </a>
                    </li>
                @endcan
                @can("create", \App\NewsSection::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.newsSections.create") }}"
                           class="nav-link{{ $currentRoute === "admin.newsSections.create" ? " active" : "" }}">
                            Добавить
                        </a>
                    </li>
                @endcan
                @if (! empty($newsSection))
                    @can("view", \App\NewsSection::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.newsSections.show", ["newsSection" => $newsSection]) }}"
                               class="nav-link{{ $currentRoute === "admin.newsSections.show" ? " active" : "" }}">
                                Просмотр
                            </a>
                        </li>
                    @endcan

                    @can("update", \App\NewsSection::class)
                        <li class="nav-item">
                            <a class="nav-link{{ $currentRoute == 'admin.newsSections.edit' ? ' active' : '' }}"
                               href="{{ route('admin.newsSections.edit', ['newsSection' => $newsSection]) }}">
                                Редактировать
                            </a>
                        </li>
                    @endcan

                    @can("delete", \App\NewsSection::class)
                        <li class="nav-item">
                            <button type="button" class="btn btn-link nav-link"
                                    data-confirm="{{ "delete-form-newsSection-{$newsSection->id}" }}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                            <confirm-form :id="'{{ "delete-form-newsSection-{$newsSection->id}" }}'">
                                <template>
                                    <form action="{{ route('admin.newsSections.destroy', ['newsSection' => $newsSection]) }}"
                                          id="delete-form-newsSection-{{ $newsSection->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        @method("delete")
                                    </form>
                                </template>
                            </confirm-form>
                        </li>
                    @endcan
                @endif

            </ul>
        </div>
    </div>
</div>