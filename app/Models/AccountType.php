<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class AccountType extends Model implements TranslatableContract
{
    use Translatable, softDeletes;

    protected $table = 'account_types';

    public $translationModel = 'App\Models\AccountTypeTranslation';

    public $translatedAttributes = ['name'];

    public $fillable = ['active'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('account_types.id', 'DESC'));
    }

}
