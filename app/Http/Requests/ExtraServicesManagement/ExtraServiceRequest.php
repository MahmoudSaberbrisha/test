<?php

namespace App\Http\Requests\ExtraServicesManagement;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class ExtraServiceRequest extends FormRequest
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
                'name'      => 'required|string|unique:extra_service_translations,name',
                'parent_id' => 'nullable|numeric|exists:extra_services,id',
            ];
        } else {
            return [
                'locale'  => [
                    'required', 
                    'string', 
                    Rule::in(config()->get('translatable.locales')), 
                    'exists:languages,code'
                ],
                'name'      => 
                [
                    'required', 
                    'string', 
                    Rule::unique('extra_service_translations')->ignore($this->extra_service, 'extra_service_id'),
                ],
                'parent_id' => 'nullable|numeric|exists:extra_services,id',
            ];
        }
    }
}
