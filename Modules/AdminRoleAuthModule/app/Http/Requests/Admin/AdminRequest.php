<?php

namespace Modules\AdminRoleAuthModule\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        if ($this->getMethod() == 'POST') {
            $rules = [
                'name'        => 'required|string',
                'user_name'   => 'required|string|unique:admins',
                'phone'       => 'required|numeric|regex:/^01?\d{9}$/|digits:11|unique:admins',
                'national_id' => 'nullable|numeric|digits:14|unique:admins',
                'email'       => 'nullable|email|unique:admins',
                'password'    => ['required','string','confirmed',Password::defaults()],
                'role'        => 'required|string|min:1',
                'image'       => 'nullable|file|image',
                'region_id'   => 'nullable|numeric|exists:regions,id',
                'branch_id'   => 'nullable|numeric|exists:branches,id',
                'setting_job_id' => 'nullable|numeric|exists:setting_jobs,id',
            ];
        } else {
            $rules = [
                'name'        => 'required|string',
                'user_name'   => ['required', 'string', Rule::unique('admins')->ignore($this->admin)],
                'phone'       => ['required', 'numeric', 'regex:/^01?\d{9}$/', 'digits:11', Rule::unique('admins')->ignore($this->admin)],
                'national_id' => ['nullable', 'numeric', 'digits:14', Rule::unique('admins')->ignore($this->admin)],
                'email'       => ['nullable', 'email', Rule::unique('admins')->ignore($this->admin)],
                'password'    => ['nullable','string','confirmed',Password::defaults()],
                'role'        => 'required|string|min:1',
                'image'       => 'nullable|file|image',
                'region_id'   => 'nullable|numeric|exists:regions,id',
                'branch_id'   => 'nullable|numeric|exists:branches,id',
                'setting_job_id' => 'nullable|numeric|exists:setting_jobs,id',
            ];
        }
        if ( $this->role_id != SUPER_ADMIN_ROLE_ID && feature('regions-branches-feature') ) 
            $rules['region_id'] = 'required|numeric|exists:regions,id';
        if ( ! in_array($this->role_id, UPPER_ROLES_IDs) && feature('branches-feature') )
            $rules['branch_id'] = 'required|numeric|exists:branches,id';

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
