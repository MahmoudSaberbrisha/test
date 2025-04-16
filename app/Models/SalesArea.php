<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use Modules\AdminRoleAuthModule\Models\Branch;

class SalesArea extends Model implements TranslatableContract
{
    use Translatable, softDeletes;

    protected $table = 'sales_areas';

    public $translationModel = 'App\Models\SalesAreaTranslation';

    public $translatedAttributes = ['name'];

    public $fillable = ['active', 'branch_id'];

    public $appends = ['branch_name'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('sales_areas.id', 'DESC'));
    }

    public function getBranchNameAttribute()
    {
        return $this->branch ? $this->branch->name : '-';
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
