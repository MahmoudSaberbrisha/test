<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class GoodSupplier extends Model
{
    /** @use HasFactory<\Database\Factories\GoodSupplierFactory> */
    use softDeletes;

    protected $table = 'good_suppliers';

    public $fillable = ['active', 'name', 'phone'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('good_suppliers.id', 'DESC'));
    }
}
