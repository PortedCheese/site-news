@extends('admin.layout')

@section('page-title', 'Добавить новость - ')
@section('header-title', 'Добавить новость')

@section('admin')
    <div class="col-12">
        <form method="post"
              class="col-12 needs-validation"
              enctype="multipart/form-data"
              action="{{ route('admin.news.store') }}">
            @csrf
            {{ debugbar()->info($errors) }}
            <div class="form-group">
                <label for="title">Заголовок</label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title') }}"
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
                       value="{{ old('slug') }}"
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
                       value="{{ old('short') }}"
                       required
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Текст новости</label>
                <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                          required
                          name="description"
                          id="ckDescription"
                          rows="3">
                    {{ old('description') }}
                </textarea>
                @if ($errors->has('description'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
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
                <button type="submit" class="btn btn-success">Сохранить</button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-dark">К списку новостей</a>
            </div>
        </form>
    </div>
@endsection
