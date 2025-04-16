<?php

namespace App\Http\Requests\CarManagement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarTaskRequest extends FormRequest
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
            'car_contract_id'      => 'required|exists:car_contracts,id',
            'currency_id'          => 'required|numeric|exists:currencies,id',
            'date'                 => 'required|date_format:Y-m-d',
            'car_expenses_id'      => 'nullable|array',
            'car_expenses_id.*'    => 'nullable|numeric|exists:car_expenses,id',
            'total'                => 'nullable|array',
            'total.*'              => 'nullable|numeric',
            'total_expenses'       => 'nullable|numeric',
            'car_income'           => 'required|numeric|gte:0',
            'paid'                 => 'required|numeric|gte:0|lte:car_income',
            'notes'                => 'nullable|string',
            'time'                 => 'required|array|min:1',
            'time.*'               => 'required',
            'from'                 => 'required|array|min:1',
            'from.*'               => 'required|string',
            'to'                   => 'required|array|min:1',
            'to.*'                 => 'required|string',
        ];
    }
}