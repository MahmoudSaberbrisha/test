<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraServiceTranslation extends Model
{
    public $fillable = ['extra_service_id', 'name', 'locale'];
}
