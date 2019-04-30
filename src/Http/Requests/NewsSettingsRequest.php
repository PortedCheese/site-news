<?php

namespace PortedCheese\SiteNews\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsSettingsRequest extends FormRequest
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
            'path' => 'required|min:4|max:10',
            'pager' => 'required|integer|min:5|max:30',
        ];
    }
}
