@extends('layouts.boot')

@section('page-title', "{$newsSection->title} - ")

@section('header-title', "{$newsSection->title}")

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
