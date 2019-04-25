@extends('site-news::admin.news.show-layout')

@section('page-title', 'Новость - ')
@section('header-title', "Новость {$news->title}")

@section('show-content')
    <div class="row">
        <div class="col-md-8">
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
        <div class="col-md-4">
            <h2>Предпросмотр</h2>
            <div>
                {!! $news->getTeaser() !!}
            </div>
        </div>
    </div>
@endsection