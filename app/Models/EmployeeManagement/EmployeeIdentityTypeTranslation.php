<?php

namespace App\Models\EmployeeManagement;

use Illuminate\Database\Eloquent\Model;

class EmployeeIdentityTypeTranslation extends Model
{
    public $fillable = ['employee_identity_type_id', 'name', 'locale'];
    
}
