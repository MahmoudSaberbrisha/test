<?php

namespace App\Http\Requests\FinancialManagement;

use Illuminate\Foundation\Http\FormRequest;

class ExpensesRequest extends FormRequest
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
            'expenses_type_id'  => 'required|exists:expenses_types,id',
            'currency_id'       => 'required|exists:currencies,id',
            'value'             => 'required|numeric|min:0',
            'note'              => 'nullable',
            'expense_date'      => 'nullable|date_format:Y-m-d',
            'image'             => 'nullable|file|image',
            'branch_id'         => 'required|numeric|exists:branches,id',
        ];
    }
}
