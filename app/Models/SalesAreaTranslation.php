<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesAreaTranslation extends Model
{
    public $fillable = ['sales_area_id', 'name', 'locale'];
}
