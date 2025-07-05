<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use Modules\AdminRoleAuthModule\Models\Branch;
use Modules\AdminRoleAuthModule\Models\Type;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    public $fillable = [
        'booking_type',
        'branch_id',
        'sailing_boat_id',
        'type_id',
        'booking_date',
        'start_time',
        'end_time',
        'total_hours',
    ];

    public static $bookingTypes = [
        'private' => 'Private',
        'group' => 'Group',
    ];

    protected $casts = [
        'booking_date' => 'date:Y-m-d',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'booking_type' => 'string',
    ];

    protected $appends = ['total_members'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('bookings.id', 'DESC'));
    }

    public function getTotalMembersAttribute()
    {
        return $this->booking_group_members->sum('members_count');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function sailing_boat()
    {
        return $this->belongsTo(SailingBoat::class, 'sailing_boat_id', 'id');
    }

    public function booking_groups()
    {
        return $this->hasMany(BookingGroup::class);
    }

    public function booking_group_members()
    {
        return $this->hasMany(BookingGroupMember::class);
    }

    public function booking_group_payments()
    {
        return $this->hasMany(BookingGroupPayment::class);
    }

    public function booking_group_services()
    {
        return $this->hasMany(BookingGroupService::class);
    }
}
