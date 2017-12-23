<?php

namespace App\Http\Requests\teacher;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'code'     => 'required|size:4',
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:7'
        ];
    }
}
