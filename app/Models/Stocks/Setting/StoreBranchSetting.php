<?php

namespace App\Models\Stocks\Setting;

use Illuminate\Database\Eloquent\Model;

class StoreBranchSetting extends Model
{
    protected $table = 'store_branch_settings';

    protected $fillable = [
        'title',
        'br_code',
        'from_id',
        'lat_map',
        'long_map'
    ];

    public $timestamps = false;

    public function parentBranch()
    {
        return $this->belongsTo(StoreBranchSetting::class, 'from_id');
    }
}
