<?php

namespace Modules\AdminRoleAuthModule\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $id = auth()->guard('admin')->user()->id;
        return [
            'name'        => 'required|string',
            'user_name'   => ['required', 'string', Rule::unique('admins')->ignore($id)],
            'phone'       => ['required', 'numeric', 'regex:/^01?\d{9}$/', 'digits:11', Rule::unique('admins')->ignore($id)],
            'national_id' => ['nullable', 'numeric', 'digits:14', Rule::unique('admins')->ignore($id)],
            'email'       => ['nullable', 'email', Rule::unique('admins')->ignore($id)],
            'image'       => 'nullable|file|image',
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
