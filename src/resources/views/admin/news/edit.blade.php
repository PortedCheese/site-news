@extends('admin.layout')

@section('page-title', 'Редактировать новость - ')
@section('header-title', "Редактировать {$news->title}")

@section('admin')
    <div class="col-12">
        <form method="post"
              class="col-12 needs-validation"
              enctype="multipart/form-data"
              action="{{ route('admin.news.update', ['news' => $news]) }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">

            <div class="form-group">
                <label for="title">Заголовок</label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title') ? old('title') : $news->title }}"
                       required
                       class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}">
                @if ($errors->has('title'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text"
                       id="slug"
                       name="slug"
                       value="{{ old('slug') ? old('slug') : $news->slug }}"
                       class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}">
                @if ($errors->has('slug'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('slug') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="short">Краткое описание</label>
                <input type="text"
                       id="short"
                       name="short"
                       value="{{ old('short') ? old('short') : $news->short }}"
                       required
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Текст новости</label>
                <textarea class="form-control" name="description" id="ckDescription" rows="3">
                    {{ old('description') ? old('description') : $news->description }}
                </textarea>
            </div>

            <div class="form-group">
                @include("site-news::admin.news.main-image", ['news' => $news])
            </div>

            <div class="custom-file">
                <input type="file"
                       class="custom-file-input{{ $errors->has('main_image') ? ' is-invalid' : '' }}"
                       id="custom-file-input"
                       lang="ru"
                       name="main_image"
                       aria-describedby="inputGroupMain">
                <label class="custom-file-label"
                       for="custom-file-input">
                    Выберите файл главного изображения
                </label>
                @if ($errors->has('main_image'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('main_image') }}</strong>
                    </div>
                @endif
            </div>

            <div class="btn-group mt-2"
                 role="group">
                <button type="submit" class="btn btn-success">Обновить</button>
                <a href="{{ route('admin.news.show', ['news' => $news]) }}"
                   class="btn btn-primary">
                    Просмотр
                </a>
                <a href="{{ route('admin.news.index') }}" class="btn btn-dark">К списку новостей</a>
            </div>
        </form>
    </div>
@endsection
