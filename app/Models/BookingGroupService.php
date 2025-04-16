<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminRoleAuthModule\Models\Branch;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use Modules\AdminRoleAuthModule\Models\Currency;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class BookingGroupService extends Model
{
    protected $table = 'booking_group_services';

    public $fillable = [
        'booking_id', 
        'branch_id', 
        'booking_group_id', 
        'booking_group_service_num', 
        'services_count',
        'extra_service_id', 
        'currency_id',
        'price',
        'discounted',
        'total',
        'is_taxed',
    ];

    protected $appends = ['paid', 'remain', 'currency_symbol'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('booking_group_services.id', 'ASC'));
        static::creating(function ($services) {
            $prefix = strtoupper('service-'.$services->branch?->translate('en')?->name) . '-';
            $services->booking_group_service_num = IdGenerator::generate([
                'table' => 'booking_group_services',
                'field' => 'booking_group_service_num',
                'length' => strlen($prefix) + 10,
                'prefix' => $prefix,
                'reset_on_prefix_change' =>true,
                'suffix_length' => 10
            ]);
        });
    }

    public function getPaidAttribute()
    {
        return $this->payments->sum('paid');
    }

    public function getRemainAttribute()
    {
        return $this->total - $this->payments->sum('paid');
    }

    public function getCurrencySymbolAttribute()
    {
        return $this->currency->symbol;
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function booking_group()
    {
        return $this->belongsTo(BookingGroup::class, 'booking_group_id', 'id');
    }

    public function extra_service()
    {
        return $this->belongsTo(ExtraService::class, 'extra_service_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(BookingGroupServicePayment::class);
    }

    public function client()
    {
        return $this->hasOneThrough(
            Client::class, 
            BookingGroup::class, 
            'id',
            'id', 
            'booking_group_id',
            'client_id'
        );
    }

}
