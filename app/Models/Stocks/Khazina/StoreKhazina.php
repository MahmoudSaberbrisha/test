<?php

namespace App\Models\Stocks\Khazina;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stocks\Setting\StoreBranchSetting;

class StoreKhazina extends Model
{
    protected $table = 'store_khazina';

    protected $fillable = [
        'main_branch_id_fk',
        'sub_branch_id_fk',
        'name',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public $timestamps = false;

    public function mainBranch()
    {
        return $this->belongsTo(StoreBranchSetting::class, 'main_branch_id_fk');
    }

    public function subBranch()
    {
        return $this->belongsTo(StoreBranchSetting::class, 'sub_branch_id_fk');
    }
}
