<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientTypeTranslation extends Model
{
    public $fillable = ['client_type_id', 'name', 'locale'];
}
