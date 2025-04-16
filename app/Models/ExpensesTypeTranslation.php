<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensesTypeTranslation  extends Model
{
    public $fillable = ['expenses_type_id', 'name', 'locale'];
}
