<?php

namespace PortedCheese\SiteNews\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use PortedCheese\SiteNews\Models\News;

class NewsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = NULL;
        $news = $this->route()->parameter('news', NULL);
        if (!empty($news)) {
            $id = $news->id;
        }
        return [
            'title' => "required|min:2|unique:news,title,{$id}",
            'slug' => "min:2|unique:news,slug,{$id}",
            'main_image' => 'nullable|image',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Заголовок',
            'main_image' => 'Главное изображение',
        ];
    }
}
