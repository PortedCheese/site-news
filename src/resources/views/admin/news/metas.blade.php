@extends('site-news::admin.news.show-layout')

@section('page-title', 'Meta - ')
@section('header-title', 'Meta')

@section('show-content')
    <div class="col-12 mt-2">
        <h2>Добавить тег</h2>
        @include("seo-integration::admin.meta.create", ['model' => 'news', 'id' => $news->id])
    </div>
    <div class="col-12 mt-2">
        @include("seo-integration::admin.meta.table-models", ['metas' => $news->metas])
    </div>
@endsection
