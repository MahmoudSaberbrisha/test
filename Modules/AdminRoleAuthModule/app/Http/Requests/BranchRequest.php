<?php

namespace Modules\AdminRoleAuthModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BranchRequest extends FormRequest
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
            $rule = [
                'name'      => 'required|string',
            ];
        } else {
            $rule = [
                'locale'    => [
                    'required', 
                    'string', 
                    Rule::in(config()->get('translatable.locales')),
                    'exists:languages,code',
                ],
                'name'      => [
                    'required', 
                    'string', 
                    Rule::unique('branch_translations')->ignore($this->branch, 'branch_id'),
                ],
            ];
        }
        if(feature('regions-branches-feature'))
            $rule['region_id'] = 'required|exists:regions,id';

        return $rule;
    }
}
