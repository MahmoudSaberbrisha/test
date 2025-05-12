<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CostCenterBranch;

class CostCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function branches()
    {
        return $this->hasMany(CostCenterBranch::class);
    }
}
