<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkStorePurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.CUSTOMER_ID' => ['required', 'integer'],
            '*.DRUG_ID' => ['required', 'integer'],
            '*.PURCHASE_DATE' => ['required', 'date'],
            '*.QUANTITY_PURCHASED' => ['required', 'integer'],
            '*.TOTAL_BILL' => ['required', 'numeric'],
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        foreach ($this->toArray() as $obj) {
            // Map the keys as needed
            $obj['customer_id'] = $obj['CUSTOMER_ID'] ?? null;
            $obj['drug_id'] = $obj['DRUG_ID'] ?? null;
            $obj['purchase_date'] = $obj['PURCHASE_DATE'] ?? null;
            $obj['quantity_purchased'] = $obj['QUANTITY_PURCHASED'] ?? null;
            $obj['total_bill'] = $obj['TOTAL_BILL'] ?? null;

            $data[] = $obj;
        }

        $this->merge($data);
    }


}
