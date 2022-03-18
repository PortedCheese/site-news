@extends('admin.layout')

@section('page-title', 'Секция новостей - ')
@section('header-title', "Секция новостей {$newsSection->title}")

@section('admin')
    @include("site-news::admin.newsSections.pills")
    <div class="col-12">
        <div class="card mb-2">
            <div class="card-header">
                <h5 class="card-title">Заголовок</h5>
            </div>
            <div class="card-body">
                {{ $newsSection->title }}
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-header">
                <h5 class="card-title">Slug</h5>
            </div>
            <div class="card-body">
                {!! $newsSection->slug !!}
            </div>
        </div>
    </div>

@endsection