<?php

namespace Modules\AdminRoleAuthModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GeneralSettingsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'locale'           => [
                'required', 
                'string', 
                Rule::in(config()->get('translatable.locales')),
                'exists:languages,code'
            ],
            'site_name'             => 'required|string',
            'site_description'      => 'required|string',
            'site_keywords'         => 'required|string',
            'site_logo'             => 'nullable|file|image',
            'site_icon'             => 'nullable|file|image',
            'site_background_image' => 'nullable|file|image',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
