<?php

namespace Modules\AdminRoleAuthModule\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use App\Traits\VisibleToScopeTrait;

class Region extends Model implements TranslatableContract
{
    use Translatable, softDeletes, VisibleToScopeTrait;
    
    protected $table = 'regions';

    public $translationModel = 'Modules\AdminRoleAuthModule\Models\RegionTranslation';

    public $translatedAttributes = ['name'];

    public $fillable = ['active'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('regions.id', 'DESC'));
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

}
