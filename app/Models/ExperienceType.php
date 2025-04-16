<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class ExperienceType extends Model implements TranslatableContract
{
    use Translatable, softDeletes;

    protected $table = 'experience_types';

    public $translationModel = 'App\Models\ExperienceTypeTranslation';

    public $translatedAttributes = ['name'];

    public $fillable = ['active', 'color'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('experience_types.id', 'DESC'));
    }
}
