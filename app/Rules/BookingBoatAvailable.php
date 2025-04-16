<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Booking;
use Carbon\Carbon;

class BookingBoatAvailable implements ValidationRule
{
    protected $sailing_boat_id;
    protected $start_time;
    protected $end_time;
    protected $booking_date;
    protected $bookingId;

    public function __construct($sailing_boat_id, $booking_date, $start_time, $end_time, $bookingId = null)
    {
        $this->sailing_boat_id = $sailing_boat_id;
        $this->booking_date = $booking_date;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->bookingId = $bookingId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $conflict = Booking::where('sailing_boat_id', $this->sailing_boat_id)
            ->whereDate('booking_date', $this->booking_date)
            ->where(function ($query) {
                $query->whereBetween('start_time', [$this->start_time, $this->end_time])
                    ->orWhereBetween('end_time', [$this->start_time, $this->end_time])
                    ->orWhere(function ($q) {
                        $q->where('start_time', '<=', $this->start_time)
                            ->where('end_time', '>=', $this->end_time);
                    });
            });

        if ($this->bookingId) {
            $conflict->where('id', '!=', $this->bookingId);
        }

        if ($conflict->exists()) {
            $fail(__('This vehicle is already occupied on this date and time period.'));
        }
    }

}
