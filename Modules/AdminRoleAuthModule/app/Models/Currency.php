<?php

namespace Modules\AdminRoleAuthModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class Currency extends Model implements TranslatableContract
{
    use Translatable, softDeletes;

    protected $table = 'currencies';

    public $translationModel = 'Modules\AdminRoleAuthModule\Models\CurrencyTranslation';

    public $translatedAttributes = ['name'];

    public $fillable = ['active', 'code', 'symbol', 'color', 'default'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('currencies.id', 'DESC'));
    }
    
}
