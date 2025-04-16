<?php

namespace Modules\AdminRoleAuthModule\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionTranslation extends Model
{
    public $fillable = ['permission_id', 'permission_name', 'locale'];
}
