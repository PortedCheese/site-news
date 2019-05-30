<div class="card card-base news-teaser h-100">
    @isset ($news->image)
        @picture([
            'image' => $news->image,
            'template' => "sm-grid-12",
            'grid' => [
                "lg-grid-{$grid}" => 992,
                'md-grid-6' => 768,
            ],
            'imgClass' => 'card-img-top',
        ])@endpicture
    @endisset
    @empty ($news->image)
        <div class="empty-image">
            <i class="far fa-image fa-9x"></i>
        </div>
    @endempty
    <div class="card-body">
        <div class="line mb-4"></div>
        <h4 class="card-title">{{ $news->title }}</h4>
        <p class="card-text text-secondary">{{ $news->short }}</p>
    </div>
    <div class="card-footer">
        <a href="{{ route("site.news.show", ['news' => $news]) }}"
           class="btn btn-primary px-4 py-2">
            Подробнее
        </a>
    </div>
</div>