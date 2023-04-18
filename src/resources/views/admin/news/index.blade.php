@extends('admin.layout')

@section('page-title', 'Новости - ')
@section('header-title', 'Новости')

@section('admin')
    @include("site-news::admin.news.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <form action="{{ route($currentRoute) }}"
                      class="form-inline"
                      method="get">
                    <label class="sr-only" for="title">Заголовок</label>
                    <input type="text"
                           class="form-control mb-2 mr-sm-2"
                           id="title"
                           name="title"
                           value="{{ $query->get('title') }}"
                           placeholder="Заголовок">

                    <button type="submit" class="btn btn-primary mb-2 mr-sm-1">Применить</button>
                    <a href="{{ route($currentRoute) }}" class="btn btn-secondary mb-2">Сбросить</a>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Заголовок</th>
                            <th>Slug</th>
                            <th>Краткое описание</th>
                            @canany(["view", "update", "delete"], \App\News::class)
                                <th>Действия</th>
                            @endcanany
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($newsList as $item)
                            <tr>
                                <td>
                                    {{ $page * $per + $loop->iteration }}
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->slug }}</td>
                                <td>{{ $item->short }}</td>
                                @canany(["view", "update", "delete", "publish"], \App\News::class)
                                    <td>
                                        <div role="toolbar" class="btn-toolbar">
                                            <div class="btn-group btn-group-sm mr-1">
                                                @can("update", \App\News::class)
                                                    <a href="{{ route("admin.news.edit", ["news" => $item]) }}" class="btn btn-primary">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can("view", \App\News::class)
                                                    <a href="{{ route('admin.news.show', ['news' => $item]) }}" class="btn btn-dark">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can("delete", \App\News::class)
                                                    <button type="button" class="btn btn-danger" data-confirm="{{ "delete-form-{$item->id}" }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                            @can("publish", \App\News::class)
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button"
                                                            class="btn btn-{{ $item->published_at ? "success" : "secondary" }}"
                                                            data-confirm="{{ "publish-form-{$item->id}" }}"
                                                            title="Статус публикации">
                                                        <i class="fas fa-toggle-{{ $item->published_at ? "on" : "off" }}"></i>
                                                    </button>
                                                </div>
                                            @endcan
                                            @can("update", \App\News::class)
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button"
                                                            class="btn btn-{{ $item->fixed ? "primary" : "light" }}"
                                                            data-confirm="{{ "fix-form-{$item->id}" }}"
                                                            title="Фиксировать в списке">
                                                        <i class="far {{ $item->fixed ? "fa-check-circle" : "fa-circle" }}"></i>
                                                    </button>
                                                </div>
                                            @endcan
                                        </div>
                                        @can("publish", \App\News::class)
                                            <confirm-form :id="'{{ "publish-form-{$item->id}" }}'" text="Это изменит статус публикации новости" confirm-text="Да, изменить!">
                                                <template>
                                                    <form action="{{ route('admin.news.publish', ['news' => $item]) }}"
                                                          id="publish-form-{{ $item->id }}"
                                                          class="btn-group"
                                                          method="post">
                                                        @csrf
                                                        @method("put")
                                                    </form>
                                                </template>
                                            </confirm-form>
                                        @endcan
                                        @can("update", \App\News::class)
                                            <confirm-form :id="'{{ "fix-form-{$item->id}" }}'" text="Это изменит порядок публикации в разделе" confirm-text="Да, изменить!">
                                                <template>
                                                    <form action="{{ route('admin.news.fix', ['news' => $item]) }}"
                                                          id="fix-form-{{ $item->id }}"
                                                          class="btn-group"
                                                          method="post">
                                                        @csrf
                                                        @method("put")
                                                    </form>
                                                </template>
                                            </confirm-form>
                                        @endcan
                                        @can("delete", \App\News::class)
                                            <confirm-form :id="'{{ "delete-form-{$item->id}" }}'">
                                                <template>
                                                    <form action="{{ route('admin.news.destroy', ['news' => $item]) }}"
                                                          id="delete-form-{{ $item->id }}"
                                                          class="btn-group"
                                                          method="post">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                    </form>
                                                </template>
                                            </confirm-form>
                                        @endcan
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if ($newsList->lastPage() > 1)
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ $newsList->links() }}
                </div>
            </div>
        </div>
    @endif
@endsection
