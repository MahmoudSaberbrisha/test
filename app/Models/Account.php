<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class Account extends Model implements TranslatableContract
{
    use Translatable, softDeletes;

    protected $table = 'accounts';

    public $translationModel = 'App\Models\AccountTranslation';

    public $translatedAttributes = ['name', 'description'];

    public $fillable = ['active', 'icon', 'code', 'account_type_id', 'parent_id', 'is_payment'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('accounts.id', 'DESC'));
    }

}