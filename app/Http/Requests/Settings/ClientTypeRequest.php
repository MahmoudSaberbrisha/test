<?php

namespace App\Http\Requests\Settings;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class ClientTypeRequest extends FormRequest
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
                'name'    => 'required|string|unique:client_type_translations,name',
                'discount_type' => 'required|in:fixed,percentage',
                'discount_value' => 'required|numeric',
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
                    Rule::unique('client_type_translations')->ignore($this->client_type, 'client_type_id'),
                ],
                'discount_type' => 'required|in:fixed,percentage',
                'discount_value' => 'required|numeric',
            ];
        }
    }
}
