<?php

namespace App\Models\EmployeeManagement;

use Illuminate\Database\Eloquent\Model;

class EmployeeReligionTranslation extends Model
{
    public $fillable = ['employee_religion_id', 'name', 'locale'];
    
}
