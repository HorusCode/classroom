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
            'data' => 'required|array|min:1',
            'data.*.email' => 'required|email|unique:users|max:255',
            'data.*.login_code' => 'required|string|max:10'
        ];
    }

    public function attributes()
    {
        return [
            'data.*.email' => 'email address',
        ];
    }
}
