<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use Modules\AdminRoleAuthModule\Models\Currency;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\EmployeeManagement\Employee;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class BookingGroup extends Model
{
    protected $table = 'booking_groups';

    public $fillable = [
        'booking_id',
        'booking_group_num', 
        'sales_area_id',
        'supplier_type',
        'client_supplier_id', 
        'client_supplier_value', 
        'client_id', 
        'currency_id', 
        'hour_member_price', 
        'price', 
        'discounted',
        'total_after_discount',
        'tax',
        'total',
        'description',
        'notes',
        'active',
        'is_taxed',
        'credit_sales',
        'out_marina',
    ];

    protected $appends = ['total_members', 'paid', 'remain', 'total_services_price', 'services_count', 'branch_name', 'currency_symbol'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('booking_groups.id', 'DESC'));
        static::creating(function ($booking_group) {
            $prefix = strtoupper($booking_group->branch_name) . '-';
            $booking_group->booking_group_num = IdGenerator::generate([
                'table' => 'booking_groups',
                'field' => 'booking_group_num',
                'length' => strlen($prefix) + 10, 
                'prefix' => $prefix, 
                'reset_on_prefix_change' =>true,
                'suffix_length' => 10
            ]);
        });
    }

    public function getTotalMembersAttribute()
    {
        return $this->booking_group_members->sum('members_count');
    }

    public function getPaidAttribute()
    {
        return $this->booking_group_payments->sum('paid');
    }

    public function getRemainAttribute()
    {
        return $this->total - $this->booking_group_payments->sum('paid');
    }

    public function getTotalServicesPriceAttribute()
    {
        return $this->booking_group_services->sum('price');
    }

    public function getServicesCountAttribute()
    {
        return $this->booking_group_services->count();
    }

    public function getBranchNameAttribute()
    {
        return $this->booking->branch?->translate('en')?->name;
    }

    public function getCurrencySymbolAttribute()
    {
        return $this->currency->symbol;
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function sales_area()
    {
        return $this->belongsTo(SalesArea::class, 'sales_area_id', 'id');
    }

    public function client_supplier(): MorphTo
    {
        return $this->morphTo(null, 'supplier_type', 'client_supplier_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
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

    public function feed_backs()
    {
        return $this->hasMany(FeedBack::class);
    }
}
