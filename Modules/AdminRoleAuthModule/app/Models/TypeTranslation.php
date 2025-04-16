<?php

namespace Modules\AdminRoleAuthModule\Models;

use Illuminate\Database\Eloquent\Model;

class TypeTranslation extends Model
{
    public $fillable = ['type_id', 'name', 'locale'];
    
}
