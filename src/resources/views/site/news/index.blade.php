@extends('layouts.boot')

@section('page-title', "Новости - ")

@section('header-title', "Новости")

@section('content')
    <div class="col-12">
        <div class="row">
            @foreach ($news as $item)
                @php($grid = $loop->index % 5 ? '3' : '6' )
                <div class="col-lg-{{ $grid }} col-md-4 col-12 mb-3 mt-3">
                    {!! $item->getTeaser($grid) !!}
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12">
                {{ $news->links() }}
            </div>
        </div>
    </div>
@endsection
