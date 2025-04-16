<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountTypeTranslation extends Model
{
    public $fillable = ['account_type_id', 'name', 'locale'];
}
