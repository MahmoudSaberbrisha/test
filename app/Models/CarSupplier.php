<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class CarSupplier extends Model
{   
    protected $table = 'car_suppliers';

    public $fillable = ['active', 'name'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('car_suppliers.id', 'DESC'));
    }
}
