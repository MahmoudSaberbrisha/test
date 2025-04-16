<?php

namespace App\Http\Requests\ClientsManagement;

use Illuminate\Foundation\Http\FormRequest;

class FeedBackRequest extends FormRequest
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
        return [
            'client_id'          => 'required|exists:clients,id',
            'booking_group_id'   => 'required|exists:booking_groups,id',
            'experience_type_id' => 'required|exists:experience_types,id',
            'comment'            => 'nullable|string|max:1000',
            'rating'             => 'required|integer|between:1,5',
            'service_quality'    => 'required|integer|between:1,5',
            'staff_behavior'     => 'required|integer|between:1,5',
            'cleanliness'        => 'required|integer|between:1,5',
        ];
    }
}
