<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodTranslation extends Model
{
    public $fillable = ['good_id', 'name', 'locale'];
}
