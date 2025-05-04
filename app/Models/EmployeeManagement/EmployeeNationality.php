<?php

namespace App\Models\EmployeeManagement;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdminRoleAuthModule\Models\Scopes\RecordOrderScope;

class EmployeeNationality extends Model implements TranslatableContract
{
    use Translatable, SoftDeletes;


    protected $table = 'employee_nationalities';

    public $translationModel = 'App\Models\EmployeeManagement\EmployeeNationalityTranslation';

    public $translatedAttributes = ['name'];

    public $fillable = ['active'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new RecordOrderScope('employee_nationalities.id', 'DESC'));
    }
}
