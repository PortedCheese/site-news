@extends('layouts.boot')

@section('page-title', "{$news->title} - ")

@section('header-title', "{$news->title}")

@section('content')
    <div class="container">
        <div class="row">
            @if ($image)
                <div class="col-12 col-md-4">
                    <img src="{{ route('imagecache', ['template' => 'medium', 'filename' => $image->file_name]) }}"
                         class="rounded img-fluid mb-2"
                         alt="{{ $image->name }}">
                </div>
            @endif
            <div class="col order-md-first">
                <div class="news-description description">
                    {!! $news->description !!}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="row justify-content-around gallery news-gallery">
            @if($gallery)
                @foreach ($gallery as $image)
                    <div class="col-12 col-sm-4 col-lg-3 mt-2 text-center">
                        <img src="{{ route('imagecache', [
                                    'template' => 'medium',
                                    'filename' => $image->file_name
                                ]) }}"
                             class="rounded mb-2"
                             alt="{{ $image->name }}">
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
