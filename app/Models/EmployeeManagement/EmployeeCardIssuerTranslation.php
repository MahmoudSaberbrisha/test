<?php

namespace App\Models\EmployeeManagement;

use Illuminate\Database\Eloquent\Model;

class EmployeeCardIssuerTranslation extends Model
{
    public $fillable = ['employee_card_issuer_id', 'name', 'locale'];
    
}
