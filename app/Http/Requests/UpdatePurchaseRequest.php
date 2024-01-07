<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user != null && $user->tokenCan('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'CUSTOMER_ID' => 'sometimes|required|exists:customers,CUSTOMER_ID',
            'DRUG_ID' => 'sometimes|required|exists:drugs,DRUG_ID',
            'PURCHASE_DATE' => 'sometimes|required|date',
            'QUANTITY_PURCHASED' => 'sometimes|required|integer|min:1',
            'TOTAL_BILL' => 'sometimes|required|numeric|min:0',
            'IS_REFUNDED' => 'sometimes|boolean',
        ];
    }
}
