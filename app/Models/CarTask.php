<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Modules\AdminRoleAuthModule\Models\Currency;

class CarTask extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */

    protected $table = 'car_tasks';

    protected $fillable = [
        'serial_num',
        'car_contract_id',
        'currency_id',
        'date',
        'total_expenses',
        'car_income',
        'paid',
        'notes',
    ];

    protected $appends = ['total_expenses', 'remain'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('car_tasks.id', 'DESC'));

        static::creating(function ($car_task) {
            $car_supplier_name = $car_task->car_contract->car_supplier->name;
            $prefix = strtoupper($car_supplier_name) . '-';

            $car_task->serial_num = IdGenerator::generate([
                'table' => 'car_tasks',
                'field' => 'serial_num',
                'length' => strlen($prefix) + 10,
                'prefix' => $prefix,
                'reset_on_prefix_change' => true,
                'suffix_length' => 10
            ]);
        });
    }

    public function getTotalExpensesAttribute()
    {
        return $this->carTaskExpenses->sum('total');
    }

    public function getRemainAttribute()
    {
        return $this->car_income - $this->paid;
    }

    public function car_contract()
    {
        return $this->belongsTo(CarContract::class, 'car_contract_id', 'id');
    }

    public function carTaskExpenses()
    {
        return $this->hasMany(CarTaskExpense::class);
    }

    public function carTaskDetails()
    {
        return $this->hasMany(CarTaskDetails::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }
}