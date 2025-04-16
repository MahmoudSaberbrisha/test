<?php

namespace App\Http\Requests\CarManagement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarContractRequest extends FormRequest
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
            'car_supplier_id'           => 'required|exists:car_suppliers,id',
            'car_type'                  => 'required|string',
            'branch_id'                 => 'required|numeric|exists:branches,id',
            'currency_id'               => 'required|numeric|exists:currencies,id',
            'passengers_num'            => 'required|integer',
            'license_expiration_date'   => 'required|date_format:Y-m-d',
            'contract_start_date'       => 'required|date_format:Y-m-d|before:license_expiration_date',
            'contract_end_date'         => 'required|date_format:Y-m-d|after:contract_start_date|before:license_expiration_date',
            'image'                     => 'nullable|file|image',
            'notes'                     => 'nullable|string',
            'total'                     => 'required|numeric|gt:0',
            'paid'                      => 'required|numeric|gt:0|lte:total'
        ];
    }
}
