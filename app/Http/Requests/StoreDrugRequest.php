<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDrugRequest extends FormRequest
{
    public function authorize()
    {
        $user = $this->user();

        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    
    public function rules()
    {
        return [
            'NAME' => 'required|string|max:50',
            'TYPE' => 'required|string|max:20',
            'DOSE' => 'required|string|max:20',
            'SELLING_PRICE' => 'required|numeric',
            'EXPIRATION_DATE' => 'required|date',
            'QUANTITY' => 'required|integer',
        ];
    }
}
