<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExperienceTypeRequest extends FormRequest
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
                'name'    => 'required|string|unique:experience_type_translations,name',
                'color'    => 'required|string|unique:experience_types,color',
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
                    Rule::unique('experience_type_translations')->ignore($this->experience_type, 'experience_type_id'),
                ],
                'color'   => [
                    'required',
                    'string',
                    Rule::unique('experience_types')->ignore($this->experience_type),
                ]
            ];
        }
    }
}
