<?php

namespace App\Http\Requests\school;

use Illuminate\Foundation\Http\FormRequest;

class WeekdaySetting extends FormRequest
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
            'class'                => 'required',
            'class'                => 'required|min:0|max:1',
            'week'                 => 'required|min:0|max:6',
            'subject.0'            => 'required',
            'subject.*'            => 'required',
        ];
    }
}