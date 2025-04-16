<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class BookingGroupServicePayment extends Model
{
    protected $table = 'booking_group_service_payments';

    public $fillable = [
        'booking_group_service_id', 
        'payment_method_id', 
        'paid',
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('booking_group_service_payments.id', 'ASC'));
    }

    public function booking_group_service()
    {
        return $this->belongsTo(BookingGroupService::class, 'booking_group_service_id', 'id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
