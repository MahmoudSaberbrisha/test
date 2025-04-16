<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientSupplierRequest extends FormRequest
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
        if ($this->getMethod() == 'POST') {
            return [
                'name'    => 'required|string|unique:client_suppliers,name',
                'value'   => 'required|numeric|between:0,100',
            ];
        } else {
            return [
                'name'    => 
                [
                    'required', 
                    'string', 
                    Rule::unique('client_suppliers')->ignore($this->client_supplier),
                ],
                'value'    => 
                [
                    'required', 
                    'numeric',
                    'between:0,100',
                ],
            ];
        }
    }
}
