@extends('admin.layout')

@section('page-title', 'Новость - ')
@section('header-title', "Новость {$news->title}")

@section('admin')
    @include("site-news::admin.news.pills")
    @if($news->image)
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Изображение</h5>
                </div>
                <div class="card-body">
                    <div class="d-inline-block">
                        @img([
                            "image" => $news->image,
                            "template" => "medium",
                            "lightbox" => "lightGroup" . $news->id,
                            "imgClass" => "rounded mb-2",
                            "grid" => [],
                        ])
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
        <div class="card mb-2">
            <div class="card-header">
                <h5 class="card-title">Короткое описание</h5>
            </div>
            <div class="card-body">
                {{ $news->short }}
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-header">
                <h5 class="card-title">Описание</h5>
            </div>
            <div class="card-body">
                {!! $news->description !!}
            </div>
        </div>
        @if (base_config()->get("news", "useSections", false))
            <div class="card mb-2">
                <div class="card-header">
                    <h5 class="card-title">Секции</h5>
                </div>
                <div class="card-body">
                    @foreach ($news->sections as $section)
                        <span class="badge badge-pill badge-secondary">{{ $section->title }}</span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    <div class="col-12 d-none">
        <div>
            {!! $news->getTeaser() !!}
        </div>
    </div>
@endsection