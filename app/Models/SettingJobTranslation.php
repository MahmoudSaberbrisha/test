<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingJobTranslation extends Model
{
    public $fillable = ['setting_job_id', 'name', 'locale'];
}
