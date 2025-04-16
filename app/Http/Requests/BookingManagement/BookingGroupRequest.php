<?php

namespace App\Http\Requests\BookingManagement;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueClientBookingGroup;
use Illuminate\Validation\Validator;

class BookingGroupRequest extends FormRequest
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
            'booking_id'           => 'required|numeric|exists:bookings,id',
            'sales_area_id'        => 'required|integer|exists:sales_areas,id',
            'supplier_type'        => 'required|string|in:App\Models\EmployeeManagement\Employee,App\Models\ClientSupplier',
            'client_id'            => 'required|numeric|exists:clients,id',
            'client_id'      => [
                'required',
                'numeric',
                'exists:clients,id',
                new UniqueClientBookingGroup(
                    $this->client_id,
                    $this->booking_id
                ),
            ],
            'currency_id'          => 'required|numeric|exists:currencies,id',
            'hour_member_price'    => 'required|numeric',
            'price'                => 'required|numeric',
            'discounted'           => 'required|numeric',
            'total_after_discount' => 'required|numeric',
            'tax'                  => 'nullable|numeric',
            'final_total'          => 'required|numeric',
            'total'                => 'required|numeric',
            'description'          => 'nullable|string',
            'notes'                => 'nullable|string',
            'is_taxed'             => 'nullable|boolean',
            'out_marina'           => 'nullable|boolean',
            'client_type_id'       => 'required|array',
            'client_type_id.*'     => 'required|numeric|exists:client_types,id',
            'members_count'        => 'required|array',
            'members_count.*'      => 'required|integer',
            'discount_type'        => [
                'nullable', 
                'array', 
                'required_if:booking_type,group', 
            ],
            'discount_type.*'      => [
                'nullable', 
                'string', 
                'in:percentage,fixed',
                'required_if:booking_type,group',
            ],
            'discount_value'       => [
                'nullable', 
                'array', 
                'required_if:booking_type,group', 
            ],
            'discount_value.*'     => [
                'nullable', 
                'numeric', 
                'required_if:booking_type,group',
            ],
            'member_price'         => [
                'nullable', 
                'array', 
                'required_if:booking_type,group', 
            ],
            'member_price.*'       => [
                'nullable', 
                'numeric', 
                'required_if:booking_type,group',
            ],
            'member_total_price'   => [
                'nullable', 
                'array', 
                'required_if:booking_type,group', 
            ],
            'member_total_price.*' => [
                'nullable', 
                'numeric', 
                'required_if:booking_type,group',
            ],
            'credit_sales'         => 'nullable|boolean',
            'payment_method_id'    => 'required_if:credit_sales,0|array',
            'payment_method_id.*'  => 'required_if:credit_sales,0|numeric|exists:payment_methods,id',
            'paid'                 => 'required_if:credit_sales,0|array',
            'paid.*'               => 'required_if:credit_sales,0|numeric',
            
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->sometimes('client_supplier_id', 'required|numeric|exists:client_suppliers,id', function ($input) {
            return $input->supplier_type == "App\Models\ClientSupplier";
        });

        $validator->sometimes('client_supplier_id', 'required|numeric|exists:admins,id', function ($input) {
            return $input->supplier_type == "App\Models\EmployeeManagement\Employee";
        });
    }
}
