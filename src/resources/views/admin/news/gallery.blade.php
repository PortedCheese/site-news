@extends('site-news::admin.news.show-layout')

@section('page-title', 'Галлерея - ')
@section('header-title', "Галлерея {$news->title}")

@section('show-content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <gallery csrf-token="{{ csrf_token() }}"
                         upload-url="{{ route('admin.vue.gallery.post', ['id' => $news->id, 'model' => 'news']) }}"
                         get-url="{{ route('admin.vue.gallery.get', ['id' => $news->id, 'model' => 'news']) }}">
                </gallery>
            </div>
        </div>
    </div>
@endsection