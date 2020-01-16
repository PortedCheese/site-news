@extends('site-news::admin.news.show-layout')

@section('page-title', 'Новость - ')
@section('header-title', "Новость {$news->title}")

@section('show-content')
    @if($news->image)
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Изображение</h5>
                </div>
                <div class="card-body">
                    <div class="d-inline-block">
                        <img src="{{ route('imagecache', ['template' => 'small', 'filename' => $news->image->file_name]) }}"
                             class="rounded mb-2"
                             alt="{{ $news->image->name }}">
                        @can("update", \App\News::class)
                            <button type="button" class="close ml-1" data-confirm="{{ "delete-form-{$news->id}" }}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        @endcan
                    </div>
                    @can("update", \App\News::class)
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
                    @endcan
                </div>
            </div>
        </div>
    @endif
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Короткое описание</h5>
            </div>
            <div class="card-body">
                {{ $news->short }}
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Описание</h5>
            </div>
            <div class="card-body">
                {!! $news->description !!}
            </div>
        </div>
    </div>
    <div class="col-12 d-none">
        <div>
            {!! $news->getTeaser() !!}
        </div>
    </div>
@endsection