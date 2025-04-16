<?php

namespace App\Http\Requests\EmployeeManagement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class EmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        if ($this->getMethod() == 'POST') {
            $rules = [
                'name'                      => 'required|string|max:255',
                'employee_type_id'          => 'required|exists:employee_types,id',
                'birthdate'                 => 'required|date',
                'employee_identity_type_id' => 'required|exists:employee_identity_types,id',
                'identity_num'              => 'required|numeric|unique:admins,identity_num',
                'setting_job_id'            => 'required|numeric|exists:setting_jobs,id',
                'salary'                    => 'required|numeric|min:0',
                'phone'                     => [
                    'required',
                    'numeric',
                    'digits_between:1,14',
                    function ($attribute, $value, $fail) {
                        if (\DB::table('admins')->where('phone', $value)->orWhere('mobile', $value)->exists()) {
                            $fail(__('The phone number is already taken.'));
                        }
                    }
                ],
                'user_name' => 'nullable|string|unique:admins',
                'password' => ['nullable', 'string', 'confirmed', Password::defaults()],
                'image' => 'nullable|file|image',
                'active' => 'nullable|boolean',
                'employee_nationality_id' => 'nullable|exists:employee_nationalities,id',
                'employee_religion_id' => 'nullable|exists:employee_religions,id',
                'employee_marital_status_id' => 'nullable|exists:employee_marital_status,id',
                'mobile' => [
                    'nullable',
                    'numeric',
                    'digits_between:1,14',
                    function ($attribute, $value, $fail) {
                        if (\DB::table('admins')->where('phone', $value)->orWhere('mobile', $value)->exists()) {
                            $fail(__('The mobile number is already taken.'));
                        }
                    }
                ],
                'employee_card_issuer_id' => 'nullable|exists:employee_card_issuers,id',
                'release_date' => 'nullable|date',
                'expiry_date' => 'nullable|date',
                'commission_rate' => 'nullable|numeric|min:0|max:100',
            ];
        } else {
            $rules = [
                'name'                      => 'required|string|max:255',
                'employee_type_id'          => 'required|exists:employee_types,id',
                'birthdate'                 => 'required|date',
                'employee_identity_type_id' => 'required|exists:employee_identity_types,id',
                'identity_num'              => [
                    'required', 
                    'numeric', 
                    Rule::unique('admins', 'identity_num')->ignore($this->employee)],
                'setting_job_id'            => 'required|numeric|exists:setting_jobs,id',
                'salary'                    => 'required|numeric|min:0',
                'phone'                     => [
                    'required',
                    'numeric',
                    'digits_between:1,14',
                    Rule::unique('admins', 'phone')->ignore($this->employee),
                    Rule::unique('admins', 'mobile')->ignore($this->employee),
                ],
                'user_name' => ['nullable', 'string', Rule::unique('admins')->ignore($this->employee)],
                'password' => ['nullable', 'string', 'confirmed', Password::defaults()],
                'image' => 'nullable|file|image',
                'active' => 'nullable|boolean',

                'employee_nationality_id' => 'nullable|exists:employee_nationalities,id',
                'employee_religion_id' => 'nullable|exists:employee_religions,id',
                'employee_marital_status_id' => 'nullable|exists:employee_marital_status,id',
                'mobile' => [
                    'nullable',
                    'numeric',
                    'digits_between:1,14',
                    Rule::unique('admins', 'phone')->ignore($this->employee),
                    Rule::unique('admins', 'mobile')->ignore($this->employee),
                ],
                
                'employee_card_issuer_id' => 'nullable|exists:employee_card_issuers,id',
                'release_date' => 'nullable|date',
                'expiry_date' => 'nullable|date',
                'commission_rate' => 'nullable|numeric|min:0|max:100',
            ];
        }

        if (feature('regions-branches-feature')) {
            $rules['region_id'] = 'required|exists:regions,id';
        }

        if (feature('branches-feature')) {
            $rules['branch_id'] = 'required|exists:branches,id';
        }

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