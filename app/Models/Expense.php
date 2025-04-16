<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use Modules\AdminRoleAuthModule\Models\Currency;
use Modules\AdminRoleAuthModule\Models\Branch;
use Storage;

class Expense extends Model
{
    /** @use HasFactory<\Database\Factories\FinanceFactory> */
    use HasFactory, softDeletes;

    protected $table = 'expenses';

    public $fillable = [
        'expenses_type_id', 
        'branch_id',
        'currency_id', 
        'value', 
        'image', 
        'note', 
        'expense_date'
    ];

    protected $attributes = [
        'expense_date' => null,
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('expenses.id', 'DESC'));

        static::creating(function ($model) {
            if (is_null($model->expense_date)) {
                $model->expense_date = now()->toDateString();
            }
        });
        static::updating(function ($model) {
            if (is_null($model->expense_date)) {
                $model->expense_date = now()->toDateString();
            }
        });
    }

    public function getImageAttribute($value)
    {
        if ($value != null && Storage::disk('public')->exists($value))
            return Storage::disk('public')->url($value);

        return @asset('') . 'assets/admin/images/no-image.jpg';
    }

    public function expenses_type()
    {
        return $this->belongsTo(ExpensesType::class, 'expenses_type_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

}
