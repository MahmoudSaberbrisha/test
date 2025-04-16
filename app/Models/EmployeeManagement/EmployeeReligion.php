<?php

namespace App\Models\EmployeeManagement;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class EmployeeReligion extends Model implements TranslatableContract
{
    use Translatable, softDeletes;

    protected $table = 'employee_religions';

    public $translationModel = 'App\Models\EmployeeManagement\EmployeeReligionTranslation';

    public $translatedAttributes = ['name'];

    public $fillable = ['active'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('employee_religions.id', 'DESC'));
    }

}
