@extends('layouts.boot')

@section('page-title', "Новости - ")

@section('header-title', "Новости")

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($news as $item)
                <div class="col-3 mb-3">
                    {!! $item->getTeaser() !!}
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
