<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class BookingGroupMember extends Model
{
    protected $table = 'booking_group_members';

    public $fillable = [
        'booking_id', 
        'booking_group_id', 
        'client_type_id', 
        'members_count',
        'discount_type',
        'discount_value',
        'member_price',
        'member_total_price',
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('booking_group_members.id', 'ASC'));
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function booking_group()
    {
        return $this->belongsTo(BookingGroup::class, 'booking_group_id', 'id');
    }

    public function client_type()
    {
        return $this->belongsTo(ClientType::class, 'client_type_id', 'id');
    }
}
