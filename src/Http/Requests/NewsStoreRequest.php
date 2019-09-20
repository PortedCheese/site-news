<?php

namespace PortedCheese\SiteNews\Http\Requests;

use App\News;
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
        return News::requestNewsStore($this);
    }

    public function attributes()
    {
        return News::requestNewsStore($this, true);
    }
}
