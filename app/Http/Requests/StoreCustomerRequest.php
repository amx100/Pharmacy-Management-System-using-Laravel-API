<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You may need to customize the authorization logic if necessary.
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    
    public function rules()
    {
        return [
            'FIRST_NAME' => 'required|string|max:45',
            'LAST_NAME' => 'required|string|max:45',
            'DOB' => 'required|date',
        ];
    }
}
