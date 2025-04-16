<?php

namespace Modules\AdminRoleAuthModule\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use App\Traits\VisibleToScopeTrait;

class Branch extends Model implements TranslatableContract
{
    use Translatable, softDeletes, VisibleToScopeTrait;
    
    protected $table = 'branches';

    public $translationModel = 'Modules\AdminRoleAuthModule\Models\BranchTranslation';

    public $translatedAttributes = ['name'];

    public $fillable = ['active', 'region_id'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('branches.id', 'DESC'));
    }

    public function region()
    {
        if (feature('regions-branches-feature'))
            return $this->belongsTo(Region::class, 'region_id', 'id');
        return;
    }

}
