@extends('layouts.boot')

@section('page-title', base_config()->get("news","stitle")." - ")

@section('header-title', base_config()->get("news","stitle"))

@section('content')
    @includeIf("site-news::site.news.sections.list")
    <div class="col-12">
        <div class="row">
            @include("site-news::site.news.news-list", ["news" => $news])
        </div>
        <div class="row">
            <div class="col-12">
                {{ $news->links() }}
            </div>
        </div>
    </div>
@endsection
