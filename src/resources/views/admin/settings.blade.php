<div class="form-group">
    <label for="path">Путь</label>
    <input type="text"
           id="path"
           name="data-path"
           value="{{ old("path", base_config()->get($name, "path", "news")) }}"
           class="form-control @error("data-path") is-invalid @enderror">
    @error("data-path")
        <div class="invalid-feedback" role="alert">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="form-group">
    <div class="custom-control custom-checkbox">
        <input type="checkbox"
               class="custom-control-input"
               id="useSections"
               {{ (! count($errors->all()) &&  base_config()->get($name, "useSections", false)) || old("data-useSections") ? "checked" : "" }}
               name="data-useSections">
        <label class="custom-control-label" for="useSections">Подключить секции</label>
    </div>
</div>

<div class="form-group">
    <label for="data-pager">Пагинация</label>
    <input type="number"
           min="5"
           max="50"
           step="1"
           id="data-pager"
           name="data-pager"
           value="{{ old("data-pager", base_config()->get($name, "pager", 20)) }}"
           class="form-control @error("data-pager") is-invalid @enderror">
    @error("data-pager")
        <div class="invalid-feedback" role="alert">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="form-group">
    <label for="route-name">Файл доплнительных адресов</label>
    <input type="text"
           id="route-name"
           name="data-route-name"
           value="{{ old("file-name", base_config()->get($name, "route-name", false)) }}"
           class="form-control @error("data-route-name") is-invalid @enderror">
    @error("data-route-name")
        <div class="invalid-feedback" role="alert">
            {{ $message }}
        </div>
    @enderror
</div>
