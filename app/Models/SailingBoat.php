<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use Modules\AdminRoleAuthModule\Models\Branch;

class SailingBoat extends Model implements TranslatableContract
{
    use Translatable, softDeletes;
    
    protected $table = 'sailing_boats';

    public $translationModel = 'App\Models\SailingBoatTranslation';

    public $translatedAttributes = ['name'];

    public $fillable = ['active', 'branch_id'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('sailing_boats.id', 'DESC'));
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
