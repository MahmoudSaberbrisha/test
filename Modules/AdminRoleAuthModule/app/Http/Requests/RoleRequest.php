<?php

namespace Modules\AdminRoleAuthModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        if ($this->getMethod() == 'POST') {
            return [
                'name'          => 'required|string|unique:roles',
                'guard_name'    => [
                    'required', 
                    'string',
                    Rule::in(config()->get('permission.guards')),
                ],
                'permissions'   => 'nullable|array',
                'permissions.*' => 'nullable|string|distinct',
            ];
        } else {
            return [
                'name'          => ['required', 'string', Rule::unique('roles')->ignore($this->role)],
                'guard_name'    => [
                    'required', 
                    'string',
                    Rule::in(config()->get('permission.guards')),
                ],
                'permissions'   => 'nullable|array',
                'permissions.*' => 'nullable|distinct',
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
