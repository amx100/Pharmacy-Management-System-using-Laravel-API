<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
            'CUSTOMER_ID' => 'required|exists:customers,CUSTOMER_ID',
            'DRUG_ID' => 'required|exists:drugs,DRUG_ID',
            'PURCHASE_DATE' => 'required|date',
            'QUANTITY_PURCHASED' => 'required|integer|min:1',
            'TOTAL_BILL' => 'numeric|min:0',
            'IS_REFUNDED' => 'sometimes|boolean',
        ];
    }
}
