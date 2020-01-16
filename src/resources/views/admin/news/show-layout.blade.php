@extends('admin.layout')

@section('admin')
    <div class="col-12 mb-2">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills">
                    @can("viewAny", \App\News::class)
                        <li class="nav-item">
                            <a class="nav-link{{ $currentRoute == 'admin.news.index' ? ' active' : '' }}"
                               href="{{ route('admin.news.index') }}">
                                Список
                            </a>
                        </li>
                    @endcan
                    @can("create", \App\News::class)
                        <li class="nav-item">
                            <a class="nav-link{{ $currentRoute == 'admin.news.create' ? ' active' : '' }}"
                               href="{{ route('admin.news.create') }}">
                                Добавить
                            </a>
                        </li>
                    @endcan
                    @if (! empty($news))
                        @can("view", \App\News::class)
                            <li class="nav-item">
                                <a class="nav-link{{ $currentRoute == 'admin.news.show' ? ' active' : '' }}"
                                   href="{{ route('admin.news.show', ['news' => $news]) }}">
                                    Просмотр
                                </a>
                            </li>
                        @endcan
                        @can("update", \App\News::class)
                            <li class="nav-item">
                                <a class="nav-link{{ $currentRoute == 'admin.news.edit' ? ' active' : '' }}"
                                   href="{{ route('admin.news.edit', ['news' => $news]) }}">
                                    Редактировать
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
                        @endcan
                        @can("delete", \App\News::class)
                            <li class="nav-item">
                                <button type="button" class="btn btn-danger btn-sm nav-link ml-3"
                                        data-confirm="{{ "delete-form-news-{$news->id}" }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <confirm-form :id="'{{ "delete-form-news-{$news->id}" }}'">
                                    <template>
                                        <form action="{{ route('admin.news.destroy', ['news' => $news]) }}"
                                              id="delete-form-news-{{ $news->id }}"
                                              class="btn-group"
                                              method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
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

    @yield('show-content')
@endsection