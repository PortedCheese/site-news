@extends('admin.layout')

@section('page-title', 'Новости - ')
@section('header-title', 'Новости')

@section('admin')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
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

                    <button type="submit" class="btn btn-primary mb-2">Применить</button>
                    <a href="{{ route($currentRoute) }}" class="btn btn-link mb-2">Сбросить</a>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Заголовок</th>
                            <th>Slug</th>
                            <th>Краткое описание</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($news as $item)
                            <tr>
                                <td>
                                    {{ $page * $per + $loop->iteration }}
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->slug }}</td>
                                <td>{{ $item->short }}</td>
                                <td>
                                    <confirm-delete-model-button model-id="{{ $item->id }}">
                                        <template slot="edit">
                                            <a href="{{ route('admin.news.edit', ['news' => $item]) }}" class="btn btn-primary">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </template>
                                        <template slot="show">
                                            <a href="{{ route('admin.news.show', ['news' => $item]) }}" class="btn btn-dark">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </template>
                                        <template slot="delete">
                                            <form action="{{ route('admin.news.destroy', ['news' => $item]) }}"
                                                  id="delete-{{ $item->id }}"
                                                  class="btn-group"
                                                  method="post">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                            </form>
                                        </template>
                                    </confirm-delete-model-button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if ($news->lastPage() > 1)
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ $news->links() }}
                </div>
            </div>
        </div>
    @endif
@endsection
