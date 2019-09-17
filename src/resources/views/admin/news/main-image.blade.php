@if($news->image)
    <img src="{{ route('imagecache', ['template' => 'small', 'filename' => $news->image->file_name]) }}"
         class="img-thumbnail mb-1"
         alt="{{ $news->image->name }}">
    <confirm-delete-model-button model-id="{{ $news->id }}">
        <template slot="delete">
            <form action="{{ route('admin.news.show.delete-image', ['news' => $news]) }}"
                  id="delete-{{ $news->id }}"
                  class="btn-group"
                  method="post">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
            </form>
        </template>
    </confirm-delete-model-button>
@endif