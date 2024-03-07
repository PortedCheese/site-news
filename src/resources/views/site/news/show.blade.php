@extends('layouts.boot')

@section('page-title', "{$news->title} - ")

@section('header-title', "{$news->title}")

@section('content')
    <div class="col-12 col-md-6 col-lg-4">
        <div class="left-content sticky-top pt-4">
            @if ($image)
                @image([
                    'image' => $image,
                    'template' => "sm-grid-12",
                    'grid' => [
                        'news-main' => 768,
                    ],
                    'imgClass' => 'img-fluid mb-2',
                ])@endimage
            @else
                <i class="far fa-image fa-9x"></i>
            @endif

                <div class="under-image px-3 mt-2">
                    <div class="row">
                        @include("site-news::site.news.sections.sections-btns", ["sections" => $news->sections])
                    </div>
                </div>

            <div class="under-image p-3 mt-2">
                <div class="line mb-4"></div>
                <p class="text-muted">
                    <span>Дата публикации: <b>{{ date("d.m.Y", strtotime($news->published_at)) }}</b></span>
                </p>
                <a href="{{ route('site.news.index') }}"
                   class="btn btn-primary btn-block mt-4 px-4 py-2">
                    Закрыть
                </a>
            </div>
        </div>
    </div>
    <div class="col mt-4">
        <div class="news-description description">
            {!! $news->description !!}
        </div>
        <div class="clearfix"></div>
    </div>
    @if($gallery->count())
        <div class="col-12">
            @gallery([
                'gallery' => $gallery,
                'lightbox' => 'news',
                'template' => 'sm-grid-6',
                'grid' => [
                    'lg-grid-3' => 992,
                    'md-grid-6' => 768,
                ],
                'imgClass' => 'img-fluid',
            ])@endgallery
        </div>
    @endif
@endsection
