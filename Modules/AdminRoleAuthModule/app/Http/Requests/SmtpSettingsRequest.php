<?php

namespace Modules\AdminRoleAuthModule\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SmtpSettingsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        if ($this->getMethod() == 'PUT') {
            return [
                'mail_encryption' => ['required', 'string', Rule::in(['ssl', 'tls'])],
                'mail_host'       => 'required|string',
                'mail_port'       => 'required|numeric',
                'mail_useremail'  => 'required|string|email',
                'mail_password'   => 'required|string',
            ];
        } else {
            return [
                'email'  => 'required|string|email'
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
