<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Modules\AdminRoleAuthModule\Models\Currency;

class CarTaskDetails extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */

    protected $table = 'car_task_details';

    protected $fillable = [
        'car_task_id',
        'time',
        'from',
        'to',
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('car_task_details.id', 'DESC'));
    }

    public function carTask()
    {
        return $this->belongsTo(CarTask::class, 'car_task_id', 'id');
    }
}