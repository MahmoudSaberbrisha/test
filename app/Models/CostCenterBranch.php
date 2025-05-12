<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenterBranch extends Model
{
    use HasFactory;

    protected $table = 'cost_center_branches';

    protected $fillable = [
        'cost_center_id',
        'name',
        'description',
    ];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class);
    }
}
