<?php

namespace App\Http\Requests\EmployeeManagement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NationalityRequest extends FormRequest
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
                'name'    => 'required|string|unique:employee_nationality_translations,name',
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
                    Rule::unique('employee_nationality_translations')->ignore($this->nationality, 'employee_nationality_id'),
                ],
            ];
        }
    }
}
