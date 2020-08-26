<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'group' => 'required|integer',
            'data' => 'required|array|min:1|max:35',
            'data.*.email' => 'required|email|unique:users|max:255',
            'data.*.login_code' => 'required|string|max:10',
            'data.*.phone' => 'required|unique:users|max:12'
        ];
    }

    public function attributes()
    {
        return [
            'data.*.email' => 'email address',
            'data.*.phone' => 'phone',
        ];
    }
}
