<?php
namespace Modules\AccountingDepartment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;

    public function parent()
    {
        return $this->belongsTo(ChartOfAccount::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id');
    }

    public function entries()
    {
        return $this->hasMany('Modules\AccountingDepartment\Models\Entry', 'account_number', 'account_number');
    }

    public static function getTree()
    {
        $accounts = ChartOfAccount::all();
        return $accounts->whereNull('parent_id')->map(function ($account) use ($accounts) {
            $account->children = $accounts->where('parent_id', $account->id)->values();
            return $account;
        });
    }

    protected $fillable = [
        'account_name',
        'account_number',
        'parent_id',
    ];
}