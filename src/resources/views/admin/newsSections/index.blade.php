@extends('admin.layout')

@section('page-title', 'Секции Новостей - ')
@section('header-title', 'Секции Новостей')

@section('admin')
    @include("site-news::admin.newsSections.pills")
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
                            @canany(["view", "update", "delete"], \App\NewsSection::class)
                                <th>Действия</th>
                            @endcanany
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($newsSectionsList as $item)
                            <tr>
                                <td>
                                    {{ $page * $per + $loop->iteration }}
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->slug }}</td>
                                @canany(["view", "update", "delete"], \App\NewsSection::class)
                                    <td>
                                        <div role="toolbar" class="btn-toolbar">
                                            <div class="btn-group btn-group-sm mr-1">
                                                @can("update", \App\News::class)
                                                    <a href="{{ route("admin.newsSections.edit", ["newsSection" => $item]) }}" class="btn btn-primary">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can("view", \App\News::class)
                                                    <a href="{{ route('admin.newsSections.show', ['newsSection' => $item]) }}" class="btn btn-dark">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can("delete", \App\NewsSection::class)
                                                    <button type="button" class="btn btn-danger" data-confirm="{{ "delete-form-{$item->id}" }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                        </div>

                                        @can("delete", \App\NewsSection::class)
                                            <confirm-form :id="'{{ "delete-form-{$item->id}" }}'">
                                                <template>
                                                    <form action="{{ route('admin.newsSections.destroy', ['newsSection' => $item]) }}"
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

    @if ($newsSectionsList->lastPage() > 1)
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ $newsSectionsList->links() }}
                </div>
            </div>
        </div>
    @endif
@endsection
