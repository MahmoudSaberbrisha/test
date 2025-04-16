<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class CarTaskExpense extends Model
{
    protected $table = 'car_task_expenses';

    protected $fillable = [
        'car_task_id',
        'car_expenses_id',
        'total',
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('car_task_expenses.id', 'ASC'));
    }

    public function carTask()
    {
        return $this->belongsTo(CarTask::class, 'car_task_id', 'id');
    }

    public function expenseType()
    {
        return $this->belongsTo(CarExpenses::class, 'car_expenses_id', 'id');
    }
}