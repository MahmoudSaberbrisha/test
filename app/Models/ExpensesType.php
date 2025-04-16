<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class ExpensesType extends Model implements TranslatableContract
{
    use Translatable, softDeletes;

    protected $table = 'expenses_types';

    public $translationModel = 'App\Models\ExpensesTypeTranslation';

    public $translatedAttributes = ['name'];

    public $fillable = ['active'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('expenses_types.id', 'DESC'));
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
