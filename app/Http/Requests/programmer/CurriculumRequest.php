<?php

namespace App\Http\Requests\programmer;

use Illuminate\Foundation\Http\FormRequest;

class CurriculumRequest extends FormRequest
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
            'x.*'            => 'required|numeric',
            'y.*'            => 'required|numeric',
            'w.*'            => 'required|numeric',
            'h.*'            => 'required|numeric',
            'title'          => 'required',
            'description'    => 'required',
            'image'          => 'required|image',
            'subject'        => 'required',
            'grade'          => 'required',
            'time'           => 'required',
            'contents.*'     => 'required',
            'images.*'       => 'required',
            'objective.*'    => 'required|requestExist',
        ];
    }
}
