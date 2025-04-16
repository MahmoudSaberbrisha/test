<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class Client extends Model
{
    use softDeletes;
    
    protected $table = 'clients';

    public $fillable = ['active', 'name', 'phone', 'mobile', 'national_id', 'passport_number', 'country', 'state', 'area', 'city'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('clients.id', 'DESC'));
    }

    public function feed_backs()
    {
        return $this->hasMany(FeedBack::class);
    }

    public function booking_groups()
    {
        return $this->hasMany(BookingGroup::class);
    }

    public function bookings()
    {
        return $this->hasManyThrough(
            Booking::class, 
            BookingGroup::class, 
            'client_id',
            'id', 
            'id',
            'booking_id'
        );
    }

}
