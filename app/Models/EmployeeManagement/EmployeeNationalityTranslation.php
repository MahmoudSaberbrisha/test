<?php

namespace App\Models\EmployeeManagement;

use Illuminate\Database\Eloquent\Model;

class EmployeeNationalityTranslation extends Model
{
    public $fillable = ['employee_nationality_id', 'name', 'locale'];
    
}
