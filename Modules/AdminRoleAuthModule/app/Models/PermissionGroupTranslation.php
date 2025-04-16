<?php

namespace Modules\AdminRoleAuthModule\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionGroupTranslation extends Model
{
    public $fillable = ['permission_group_id', 'group_name', 'locale'];
}
