<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class restRegister extends FormRequest
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
            'name' => 'required',
            'email' => 'required|unique:restaurants|email',
            'phone' => 'required',
            'password' => 'required|confirmed',
            // 'image' => 'required|mimes:jpg,jpeg,png',
            'min_order' => 'required',
            'delivery_fees' => 'required',
            'contact_phone' => 'required',
            'contact_whatsapp' => 'required',
            'district_id' => 'required',
        ];


    }
}
