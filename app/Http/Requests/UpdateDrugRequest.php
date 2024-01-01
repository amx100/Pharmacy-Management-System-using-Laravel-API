<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDrugRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'NAME' => 'sometimes|required|string|max:50',
            'TYPE' => 'sometimes|required|string|max:20',
            'DOSE' => 'sometimes|required|string|max:20',
            'SELLING_PRICE' => 'sometimes|required|numeric',
            'EXPIRATION_DATE' => 'sometimes|required|date',
            'QUANTITY' => 'sometimes|required|integer',
        ];
    }
}
