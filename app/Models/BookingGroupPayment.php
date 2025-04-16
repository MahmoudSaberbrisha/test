<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class BookingGroupPayment extends Model
{
    protected $table = 'booking_group_payments';

    public $fillable = [
        'booking_id', 
        'booking_group_id', 
        'payment_method_id', 
        'paid',
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('booking_group_payments.id', 'ASC'));
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function booking_group()
    {
        return $this->belongsTo(BookingGroup::class, 'booking_group_id', 'id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
