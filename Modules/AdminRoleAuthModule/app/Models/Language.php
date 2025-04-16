<?php

namespace Modules\AdminRoleAuthModule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;
use Storage;

class Language extends Model implements TranslatableContract
{
    use HasFactory, Translatable, softDeletes;

    protected $table = 'languages';

    public $translationModel = 'Modules\AdminRoleAuthModule\Models\LanguageTranslation';

	public $translatedAttributes = ['name'];

	public $fillable = ['code', 'image', 'active', 'default', 'rtl'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('languages.id', 'DESC'));
    }

    public function getImageAttribute($value)
    {
        if ($value != null && Storage::disk('public')->exists($value))
            return Storage::disk('public')->url($value);

        return @asset('') . 'assets/admin/images/no-image.jpg';
    }

}
