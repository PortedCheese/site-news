@extends('admin.layout')

@section('page-title', 'Редактировать новость - ')
@section('header-title', "Редактировать {$news->title}")

@section('admin')
    @include("site-news::admin.news.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post"
                      class="col-12 needs-validation"
                      enctype="multipart/form-data"
                      action="{{ route('admin.news.update', ['news' => $news]) }}">
                    @csrf
                    @method('put')

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
                        <label for="ckDescription">Текст новости</label>
                        <textarea class="form-control"
                                  name="description"
                                  id="ckDescription"
                                  rows="3">{{ old('description') ? old('description') : $news->description }}</textarea>
                    </div>

                    <div class="form-group">
                        @if($news->image)
                            <div class="d-inline-block">
                                <img src="{{ route('imagecache', ['template' => 'small', 'filename' => $news->image->file_name]) }}"
                                     class="rounded mb-2"
                                     alt="{{ $news->image->name }}">
                                <button type="button" class="close ml-1" data-confirm="{{ "delete-form-{$news->id}" }}">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="custom-file">
                            <input type="file"
                                   class="custom-file-input{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                   id="custom-file-input"
                                   lang="ru"
                                   name="image"
                                   aria-describedby="inputGroupMain">
                            <label class="custom-file-label"
                                   for="custom-file-input">
                                Выберите файл главного изображения
                            </label>
                            @if ($errors->has('image'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="btn-group mt-2"
                         role="group">
                        <button type="submit" class="btn btn-success">Обновить</button>
                    </div>
                </form>

                @if($news->image)
                    <confirm-form :id="'{{ "delete-form-{$news->id}" }}'">
                        <template>
                            <form action="{{ route('admin.news.show.delete-image', ['news' => $news]) }}"
                                  id="delete-form-{{ $news->id }}"
                                  class="btn-group"
                                  method="post">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                        </template>
                    </confirm-form>
                @endif
            </div>
        </div>
    </div>
@endsection
