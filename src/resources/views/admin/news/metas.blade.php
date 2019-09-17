@extends('site-news::admin.news.show-layout')

@section('page-title', 'Meta - ')
@section('header-title', 'Meta')

@section('show-content')
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Добавить тег</h5>
            </div>
            <div class="card-body">
                @include("seo-integration::admin.meta.create", ['model' => 'news', 'id' => $news->id])
            </div>
        </div>
    </div>
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-body">
                @include("seo-integration::admin.meta.table-models", ['metas' => $news->metas])
            </div>
        </div>
    </div>
@endsection
