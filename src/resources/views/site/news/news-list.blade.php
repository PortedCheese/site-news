@foreach ($news as $item)
    @php($grid = $loop->index % 5 ? '3' : '6' )
    <div class="col-lg-{{ $grid }} col-md-4 col-12 mb-3 mt-3">
        {!! $item->getTeaser($grid) !!}
    </div>
@endforeach