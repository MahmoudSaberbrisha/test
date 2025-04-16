<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountTranslation extends Model
{
    public $fillable = ['account_id', 'name', 'locale', 'description'];
}
