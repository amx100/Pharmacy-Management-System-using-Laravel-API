<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkStoreDrugRequest extends FormRequest
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
            '*.NAME' => ['required', 'string', 'max:50'],
            '*.TYPE' => ['required', 'string', 'max:20'],
            '*.DOSE' => ['required', 'string', 'max:20'],
            '*.SELLING_PRICE' => ['required', 'numeric'],
            '*.EXPIRATION_DATE' => ['required', 'date'],
            '*.QUANTITY' => ['required', 'integer'],
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        foreach ($this->toArray() as $obj) {
            // Map the keys as needed
            $obj['name'] = $obj['NAME'] ?? null;
            $obj['type'] = $obj['TYPE'] ?? null;
            $obj['dose'] = $obj['DOSE'] ?? null;
            $obj['selling_price'] = $obj['SELLING_PRICE'] ?? null;
            $obj['expiration_date'] = $obj['EXPIRATION_DATE'] ?? null;
            $obj['quantity'] = $obj['QUANTITY'] ?? null;

            $data[] = $obj;
        }

        $this->merge($data);
    }


}
