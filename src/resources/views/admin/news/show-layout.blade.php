@extends('admin.layout')

@section('admin')
    <div class="col-12 mb-2">
        @include("site-news::admin.news.show-nav", ['news' => $news])
    </div>

    @yield('show-content')

    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-body">
                @include("site-news::admin.news.show-btns", ['news' => $news])
            </div>
        </div>
    </div>
@endsection