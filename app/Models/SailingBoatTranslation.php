<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SailingBoatTranslation extends Model
{
    public $fillable = ['sailing_boat_id', 'name', 'locale'];
}
