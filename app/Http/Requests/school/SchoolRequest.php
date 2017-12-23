<?php

namespace App\Http\Requests\school;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
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
            'name'             => 'required',
            'address'          => 'required',
            'password'         => 'required|min:7',
            'telephone_number' => 'required|numeric',
            'semester'         => 'required|numeric|min:2|max:3',
        ];
    }
}
