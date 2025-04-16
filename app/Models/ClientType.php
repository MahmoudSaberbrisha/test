<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class ClientType extends Model implements TranslatableContract
{
    use Translatable, softDeletes;

    protected $table = 'client_types';

    public $translationModel = 'App\Models\ClientTypeTranslation';

    public $translatedAttributes = ['name'];

    public $fillable = ['active', 'discount_type', 'discount_value'];

    protected $casts = [
        'discount_type' => 'string',
    ];

    public static $discountTypes = [
        'fixed' => 'Fixed',
        'percentage' => 'Percentage',
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('client_types.id', 'DESC'));
    }

}
