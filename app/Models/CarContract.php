<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use Modules\AdminRoleAuthModule\Models\Currency;
use Modules\AdminRoleAuthModule\Models\Branch;
use Storage;

class CarContract extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */

    protected $table = 'car_contracts';

    protected $fillable = [
        'car_supplier_id',
        'car_type',
        'branch_id',
        'currency_id',
        'passengers_num',
        'license_expiration_date',
        'contract_start_date',
        'contract_end_date',
        'image',
        'notes',
        'total',
        'paid'
    ];

    protected $appends = ['remain'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('car_contracts.id', 'DESC'));
    }

    public function getRemainAttribute()
    {
        return $this->total - $this->paid;
    }

    public function getImageAttribute($value)
    {
        if ($value != null && Storage::disk('public')->exists($value))
            return Storage::disk('public')->url($value);

        return @asset('') . 'assets/admin/images/no-image.jpg';
    }

    public function car_supplier()
    {
        return $this->belongsTo(CarSupplier::class, 'car_supplier_id', 'id');
    }

    public function carTasks()
    {
        return $this->hasMany(CarTask::class, 'car_contract_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}
