<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class ExtraService extends Model implements TranslatableContract
{
    use Translatable, softDeletes;

    protected $table = 'extra_services';

    public $translationModel = 'App\Models\ExtraServiceTranslation';

    public $translatedAttributes = ['name'];

    public $fillable = ['active', 'parent_id'];

    protected $appends = ['parent_name'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('extra_services.id', 'DESC'));
    }

    public function getParentNameAttribute()
    {
        if ($this->relationLoaded('parent') && $this->parent && $this->parent->name) {
            return $this->parent->name;
        }

        return '-';
    }

    public function parent()
    {
        return $this->belongsTo(ExtraService::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ExtraService::class, 'parent_id');
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

}
