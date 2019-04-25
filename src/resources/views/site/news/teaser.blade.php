<div class="card news-teaser h-100">
    @isset ($news->image)
        <img src="{{ route('imagecache', ['template' => 'medium', 'filename' => $news->image->file_name]) }}"
             class="card-img-top"
             alt="{{ $news->image->name }}">
    @endisset
    <div class="card-body">
        <h5 class="card-title">{{ $news->title }}</h5>
        <p class="card-text">{{ $news->short }}</p>
    </div>
        <div class="card-footer">
            <a href="{{ route("site.news.show", ['news' => $news]) }}"
               class="card-link">
                Подробнее
            </a>
        </div>
</div>