<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkStoreCustomerRequest extends FormRequest
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
            '*.FIRST_NAME' => ['required', 'string', 'max:45'],
            '*.LAST_NAME' => ['required', 'string', 'max:45'],
            '*.DOB' => ['required', 'date'],
           
        ];
    }
    protected function prepareForValidation()
    {
        $data = [];

        foreach ($this->toArray() as $obj) {
            $obj['first_name'] = $obj['FIRST_NAME'] ?? null;
            $obj['last_name'] = $obj['LAST_NAME'] ?? null;
            $obj['dob'] = $obj['DOB'] ?? null;


            $data[] = $obj;
        }

        $this->merge($data);
    }
}
