<?php

namespace Modules\AdminRoleAuthModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CurrencyRequest extends FormRequest
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
                'name'    => 'required|string|unique:currency_translations,name',
                'code'    => 'required|string|unique:currencies,code',
                'symbol'  => 'required|string|unique:currencies,symbol',
                'color'   => 'required|string|unique:currencies,color',
                'default' => 'nullable|boolean',
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
                    Rule::unique('currency_translations')->ignore($this->currency, 'currency_id'),
                ],
                'code'    => 
                [
                    'required', 
                    'string', 
                    Rule::unique('currencies')->ignore($this->currency),
                ],
                'symbol'    => 
                [
                    'required', 
                    'string', 
                    Rule::unique('currencies')->ignore($this->currency),
                ],
                'color'    => 
                [
                    'required', 
                    'string', 
                    Rule::unique('currencies')->ignore($this->currency),
                ],
                'default' => 'nullable|boolean',
            ];
        }
    }
}
