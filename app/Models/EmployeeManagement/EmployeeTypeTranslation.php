<?php

namespace App\Models\EmployeeManagement;

use Illuminate\Database\Eloquent\Model;

class EmployeeTypeTranslation extends Model
{
    public $fillable = ['employee_types_id', 'name', 'locale'];
    
}
