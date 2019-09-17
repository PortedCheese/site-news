@extends('site-news::admin.news.show-layout')

@section('page-title', 'Новость - ')
@section('header-title', "Новость {$news->title}")

@section('show-content')
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="mt-2">
                    <h2>Изображение</h2>
                    @include("site-news::admin.news.main-image", ['news' => $news])
                </div>
                <div class="mt-2">
                    <h2>Короткое описание</h2>
                    {{ $news->short }}
                </div>
                <div class="mt-2">
                    <h2>Описание</h2>
                    {!! $news->description !!}
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div>
            {!! $news->getTeaser() !!}
        </div>
    </div>
@endsection