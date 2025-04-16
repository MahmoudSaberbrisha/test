<?php

namespace App\Http\Requests\ExtraServicesManagement;

use Illuminate\Foundation\Http\FormRequest;

class BookingGroupServiceRequest extends FormRequest
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
            'booking_group_id' => 'required|numeric|exists:booking_groups,id',
            'services' => ['required', 'array', 'min:1'],
            'services.*.services_count' => ['required', 'integer', 'min:1'],
            'services.*.extra_service_id' => ['required', 'exists:extra_services,id'],
            'services.*.price' => ['required', 'numeric', 'min:0'],
            'services.*.total' => ['required', 'numeric', 'min:0'],
            'services.*.currency_id' => ['required', 'exists:currencies,id'],
            'services.*.payments' => ['nullable', 'array'],
            'services.*.payments.*.payment_method_id' => [
                'required_with:services.*.payments', 
                'exists:payment_methods,id'
            ],
            'services.*.payments.*.paid' => [
                'required_with:services.*.payments', 
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    $serviceIndex = explode('.', $attribute)[1];  
                    $requestData = request()->input("services.{$serviceIndex}");
                    
                    if (!isset($requestData['payments']) || !is_array($requestData['payments'])) {
                        return;
                    }

                    $totalPrice = $requestData['total'] ?? 0;
                    $totalPaid = array_sum(array_column($requestData['payments'], 'paid'));

                    if ($totalPaid > $totalPrice) {
                        $fail('Total paid amount cannot exceed the service total price.');
                    }
                }
            ],
        ];
    }

    public function withValidator($validator)
    {
        /*$validator->after(function ($validator) {
            $services = $this->input('services', []);

            foreach ($services as $index => $service) {
                if (isset($service['price']) && $service['price'] > 0 && !isset($service['payments'])) {
                    $validator->errors()->add("services.{$index}.payments", 'Payments are required when the total price is greater than zero.');
                }
            }
        });*/
    }
}
