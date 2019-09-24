@extends('admin.layout')

@section('admin')
    <div class="col-12 mb-2">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills">
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
            </div>
        </div>
    </div>

    @yield('show-content')

    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-body">
                <div role="toolbar" class="btn-toolbar">
                    <div class="btn-group mr-1">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-dark">
                            К списку новостей
                        </a>
                        <a href="{{ route("admin.news.edit", ["news" => $news]) }}" class="btn btn-primary">
                            <i class="far fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger" data-confirm="{{ "delete-form-{$news->id}" }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
                <confirm-form :id="'{{ "delete-form-{$news->id}" }}'">
                    <template>
                        <form action="{{ route('admin.news.destroy', ['news' => $news]) }}"
                              id="delete-form-{{ $news->id }}"
                              class="btn-group"
                              method="post">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </template>
                </confirm-form>
            </div>
        </div>
    </div>
@endsection