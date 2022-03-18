@extends('admin.layout')

@section('page-title', 'Приоритет секций - ')
@section('header-title', 'Приоритет секций ')

@section('admin')
    @include("site-news::admin.newsSections.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <universal-priority
                        :elements="{{ json_encode($groups) }}"
                        url="{{ route("admin.vue.priority", ["table" => "news_sections", "field" => "priority"]) }}"
                >

                </universal-priority>
            </div>
        </div>
    </div>
@endsection
