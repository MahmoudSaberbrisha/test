<?php

namespace App\Models\Stocks\Setting;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stocks\Khazina\StoreKhazina;

class StoreBranchSetting extends Model
{
    protected $table = 'store_branch_settings';

    protected $fillable = [
        'title',
        'br_code',
        'from_id',
        'lat_map',
        'long_map',
    ];

    public $timestamps = false;

    public function mainKhazinas()
    {
        return $this->hasMany(StoreKhazina::class, 'main_branch_id_fk');
    }

    public function subKhazinas()
    {
        return $this->hasMany(StoreKhazina::class, 'sub_branch_id_fk');
    }
}
