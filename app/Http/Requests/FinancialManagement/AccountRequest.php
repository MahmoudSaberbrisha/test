
<?php

namespace App\Http\Requests\FinancialManagement;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
                'name'    => 'required|string|unique:account_translations,name',
                'description' => 'required|string',
                'icon'    => 'required|string',
                'account_type_id' => 'required|numeric|exists:account_types,id',
                'parent_id' => 'nullable|numeric|exists:accounts,id',
                'is_payment' => 'nullable|boolean',
            ];
        } else {
            return [
                'locale'  => [
                    'required',
                    'string',
                    Rule::in(config()->get('translatable.locales')),
                    'exists:languages,code'
                ],
                'name'    =>
                [
                    'required',
                    'string',
                    Rule::unique('account_type_translations')->ignore($this->account, 'account_id'),
                ],
                'description' => 'required|string',
                'icon'    => 'required|string',
                'account_type_id' => 'required|numeric|exists:account_types,id',
                'parent_id' => 'nullable|numeric|exists:accounts,id',
                'is_payment' => 'nullable|boolean',
                'active' => 'nullable|boolean',
            ];
        }
    }
}
