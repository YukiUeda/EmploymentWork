<?php

namespace App\Http\Requests\school;

use Illuminate\Foundation\Http\FormRequest;

class ObjectiveChoice extends FormRequest
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
            'grade'                => 'required|min:1|max:6',
            'year'                 => 'required|min:0|max:1',
            'subject'              => 'required|min:0|max:11',
        ];
    }
}
