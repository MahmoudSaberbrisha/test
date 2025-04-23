<?php

namespace Modules\AccountingDepartment\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'entry_number',
        'entry_number2',
        'account_name',
        'account_name2',
        'account_type', // added account_type
        'account_number',
        'account_number2',
        'cost_center',
        'cost_center2',
        'reference',
        'reference2',
        'debit',
        'credit',
        'description',
        'total',
    ];

    public function chartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_number', 'account_number');
    }

    public function typeOfRestriction()
    {
        return $this->hasOne(TypeOfRestriction::class);
    }
}
