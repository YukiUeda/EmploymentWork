<?php

namespace App\Http\Requests\company;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'x'           => 'required|numeric',
            'y'           => 'required|numeric',
            'w'           => 'required|numeric',
            'h'           => 'required|numeric',
            'name'        => 'required',
            'url'         => 'required',
            'price'       => 'required',
            'click_price' => 'required',
            'path'        => 'required',
            'image'       => 'required|image',
        ];
    }
}
