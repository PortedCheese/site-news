<confirm-delete-model-button model-id="{{ $news->id }}">
    <template slot="edit">
        <a href="{{ route('admin.news.edit', ['news' => $news]) }}" class="btn btn-primary">
            <i class="far fa-edit"></i>
        </a>
    </template>
    <template slot="other">
        <a href="{{ route('admin.news.index') }}" class="btn btn-dark">
            К списку новостей
        </a>
    </template>
    <template slot="delete">
        <form action="{{ route('admin.news.destroy', ['news' => $news]) }}"
              id="delete-{{ $news->id }}"
              class="btn-group"
              method="post">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
        </form>
    </template>
</confirm-delete-model-button>