<?php

namespace App\Models\EmployeeManagement;

use Illuminate\Database\Eloquent\Model;

class EmployeeMaritalStatusTranslation extends Model
{
    public $fillable = ['employee_marital_status_id', 'name', 'locale'];
    
}
