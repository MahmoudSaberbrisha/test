<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarExpensesTranslation extends Model
{
    public $fillable = ['car_expenses_id', 'name', 'locale'];
    
}
