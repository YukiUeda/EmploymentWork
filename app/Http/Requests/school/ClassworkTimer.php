<?php

namespace App\Http\Requests\school;

use Illuminate\Foundation\Http\FormRequest;

class ClassworkTimer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lesson1_str'          => 'required',
            'lesson2_str'          => 'required',
            'lesson3_str'          => 'required',
            'lesson4_str'          => 'required',
            'lesson5_str'          => 'required',
            'lesson6_str'          => 'required',
            'lesson1_end'          => 'required',
            'lesson2_end'          => 'required',
            'lesson3_end'          => 'required',
            'lesson4_end'          => 'required',
            'lesson5_end'          => 'required',
            'lesson6_end'          => 'required',

        ];
    }
}
