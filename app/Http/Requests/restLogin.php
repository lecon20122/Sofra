<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class restLogin extends FormRequest
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
            'password' => 'required',
            'email' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'password.required' => 'The Password field is required for login',
            'phone.required' => 'The phone field is required for login',
        ];
    }
}
