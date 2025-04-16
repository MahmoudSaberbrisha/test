<?php

namespace Modules\AdminRoleAuthModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LanguageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        if ($this->getMethod() == 'POST') {
            return [
                'code'    => [
                    'required', 
                    'string', 
                    'unique:languages', 
                    Rule::in(config()->get('translatable.locales')),
                ],
                'name'    => 'required|string',
                'image'   => 'required|file|image',
                'default' => 'required|boolean',
                'rtl'     => 'required|boolean',
            ];
        } else {
            return [
                'locale'  => [
                    'required', 
                    'string', 
                    Rule::in(config()->get('translatable.locales')),
                    'exists:languages,code'
                ],
                'name'    => 'required|string',
                'image'   => 'nullable|file|image',
                'default' => 'required|boolean',
                'rtl'     => 'required|boolean',
            ];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
