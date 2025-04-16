<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienceTypeTranslation extends Model
{
    public $fillable = ['experience_type_id', 'name', 'locale'];
}
