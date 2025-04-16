<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GoodSupplierRequest extends FormRequest
{
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
                'name'    => 'required|string',
                'phone'   => 'required|numeric|regex:/^01?\d{9}$/|digits:11|unique:good_suppliers,phone',
            ];
        } else {
            return [
                'name'    => 'required|string',
                'phone'    => 
                [
                    'required', 
                    'numeric', 
                    'regex:/^01?\d{9}$/',
                    'digits:11',
                    Rule::unique('good_suppliers')->ignore($this->goods_supplier),
                ],
            ];
        }
    }
}
