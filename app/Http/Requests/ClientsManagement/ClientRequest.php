<?php

namespace App\Http\Requests\ClientsManagement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
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
                'name' => 'required|string|unique:clients,name',
                'phone' => [
                    'required',
                    'numeric',
                    'digits_between:1,14',
                    function ($attribute, $value, $fail) {
                        if (\DB::table('clients')->where('phone', $value)->orWhere('mobile', $value)->exists()) {
                            $fail(__('The phone number is already taken.'));
                        }
                    }
                ],
                'mobile' => [
                    'required',
                    'numeric',
                    'digits_between:1,14',
                    function ($attribute, $value, $fail) {
                        if (\DB::table('clients')->where('phone', $value)->orWhere('mobile', $value)->exists()) {
                            $fail(__('The mobile number is already taken.'));
                        }
                    }
                ],
                'national_id' => 'nullable|digits_between:1,14|unique:clients,national_id',
                'passport_number' => 'nullable|string|unique:clients,passport_number',
                'country' => 'required|string',
                'state' => 'nullable|string',
                'area' => 'required|string',
                'city' => 'nullable|string',
            ];
        } else {
            return [
                'name' => 
                [
                    'required', 
                    'string', 
                    Rule::unique('clients')->ignore($this->client),
                ],
                'phone' => [
                    'required',
                    'numeric',
                    'digits_between:1,14',
                    function ($attribute, $value, $fail) {
                        if (\DB::table('clients')
                            ->where('id', '!=', $this->client)
                            ->where(function ($query) use ($value) {
                                $query->where('phone', $value)
                                      ->orWhere('mobile', $value);
                            })
                            ->exists()) {
                            $fail(__('The phone number is already taken.'));
                        }
                    }
                ],
                'mobile' => [
                    'required',
                    'numeric',
                    'digits_between:1,14',
                    function ($attribute, $value, $fail) {
                        if (\DB::table('clients')
                            ->where('id', '!=', $this->client)
                            ->where(function ($query) use ($value) {
                                $query->where('phone', $value)
                                      ->orWhere('mobile', $value);
                            })
                            ->exists()) {
                            $fail(__('The mobile number is already taken.'));
                        }
                    }
                ],
                'national_id' => 
                [
                    'nullable', 
                    'numeric', 
                    'digits_between:1,14',
                    Rule::unique('clients')->ignore($this->client),
                ],
                'passport_number' => 
                [
                    'nullable', 
                    'string', 
                    Rule::unique('clients')->ignore($this->client),
                ],
                'country' => 'required|string',
                'state' => 'nullable|string',
                'area' => 'required|string',
                'city' => 'nullable|string',
            ];
        }
    }
}
