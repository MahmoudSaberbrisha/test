<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ClientSupplier extends Model
{
    use softDeletes;

    protected $table = 'client_suppliers';

    public $fillable = ['active', 'value', 'name'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('client_suppliers.id', 'DESC'));
    }

    public function booking_groups(): MorphMany
    {
        return $this->morphMany(BookingGroup::class, 'client_supplier', 'supplier_type', 'client_supplier_id');
    }

}
