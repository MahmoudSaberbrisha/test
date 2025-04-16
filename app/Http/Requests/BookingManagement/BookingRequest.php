<?php

namespace App\Http\Requests\BookingManagement;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\BookingBoatAvailable;

class BookingRequest extends FormRequest
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
            'booking_type'         => 'required|string|in:private,group',
            'type_id'              => 'required|numeric|exists:types,id',
            'booking_date'         => 'required|after_or_equal:today|date_format:Y-m-d',
            'start_time'           => 'required|date_format:H:i',
            'end_time'             => 'required|date_format:H:i|after:start_time',
            'total_hours'          => 'required|string',
            'sailing_boat_id'      => [
                'required',
                'numeric',
                'exists:sailing_boats,id',
                new BookingBoatAvailable(
                    $this->sailing_boat_id,
                    $this->booking_date,
                    $this->start_time,
                    $this->end_time,
                    $this->booking??null
                ),
            ],
        ];
    }
}
