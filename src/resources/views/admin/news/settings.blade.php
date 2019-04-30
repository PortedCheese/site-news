@extends('admin.layout')

@section('page-title', 'Настройки новостей - ')
@section('header-title', 'Настройки новостей')

@section('admin')
    <div class="col-12">
        <form action="{{ route('admin.news.settings-save') }}" method="post">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="path">Путь</label>
                <input type="text"
                       id="path"
                       name="path"
                       value="{{ old('path') ? old('path') : $config->path }}"
                       required
                       class="form-control{{ $errors->has('path') ? ' is-invalid' : '' }}">
                @if ($errors->has('path'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('path') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="pager">Количество на страницу</label>
                <input type="text"
                       id="pager"
                       name="pager"
                       value="{{ old('pager') ? old('pager') : $config->pager }}"
                       required
                       class="form-control{{ $errors->has('pager') ? ' is-invalid' : '' }}">
                @if ($errors->has('pager'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('pager') }}</strong>
                    </span>
                @endif
            </div>

            <label>Тема</label>
            <div class="form-check">
                <input class="form-check-input"
                       type="radio"
                       value=""
                       @if (empty($config->customTheme))
                       checked
                       @endif
                       id="check-default"
                       name="theme">
                <label class="form-check-label" for="check-default">
                    default
                </label>
            </div>
            @foreach($themes as $key => $theme)
                <div class="form-check">
                    <input class="form-check-input"
                           type="radio"
                           @if (old('theme') == $theme)
                           checked
                           @elseif ($config->customTheme == $theme)
                           checked
                           @endif
                           value="{{ $theme }}"
                           id="check-{{ $key }}"
                           name="theme">
                    <label class="form-check-label" for="check-{{ $key }}">
                        {{ $key }}
                    </label>
                </div>
            @endforeach

            <div class="btn-group mt-2"
                 role="group">
                <button type="submit" class="btn btn-success">
                    Обновить
                </button>
            </div>

        </form>
    </div>
@endsection
