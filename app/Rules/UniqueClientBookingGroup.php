<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Booking;

class UniqueClientBookingGroup implements Rule
{
    protected $clientId;
    protected $startTime;
    protected $endTime;
    protected $bookingDate;
    protected $bookingId; 

    public function __construct($clientId, $bookingId)
    {
        $this->clientId = $clientId;
        $this->bookingId = $bookingId;
    }

    public function passes($attribute = null, $value = null)
    {
        $booking = Booking::find($this->bookingId);
        $this->startTime = $booking->start_time;
        $this->endTime = $booking->end_time;
        $this->bookingDate = $booking->booking_date;
        return !Booking::where('booking_date', $this->bookingDate) 
            ->where('id', '!=', $this->bookingId) 
            ->whereHas('booking_groups', function ($query) {
                $query->where('client_id', $this->clientId);
            })
            ->where(function ($query) {
                $query->whereBetween('start_time', [$this->startTime, $this->endTime])
                      ->orWhereBetween('end_time', [$this->startTime, $this->endTime])
                      ->orWhere(function ($q) {
                          $q->where('start_time', '<=', $this->startTime)
                            ->where('end_time', '>=', $this->endTime);
                      });
            })
            ->exists();
    }

    public function message()
    {
        return __('This Client has another booking at the same time.');
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }
}
