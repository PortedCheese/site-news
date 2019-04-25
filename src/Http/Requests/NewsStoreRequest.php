<?php

namespace PortedCheese\SiteNews\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsStoreRequest extends FormRequest
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
        return [
            'title' => 'required|min:2|unique:news,title',
            'slug' => 'nullable|min:2|unique:news,slug',
            'main_image' => 'nullable|image',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => "Поле Текст новости обязательно для заполнения",
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Заголовок',
            'main_image' => 'Главное изображение',
            'description' => 'Текст новости',
        ];
    }
}
