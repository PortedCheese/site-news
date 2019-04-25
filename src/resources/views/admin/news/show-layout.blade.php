@extends('admin.layout')

@section('admin')
    <div class="col-12 mb-2">
        @include("site-news::admin.news.show-nav", ['news' => $news])
    </div>

    <div class="col-12">
        @yield('show-content')
    </div>

    <div class="col-12 mt-2">
        @include("site-news::admin.news.show-btns", ['news' => $news])
    </div>
@endsection