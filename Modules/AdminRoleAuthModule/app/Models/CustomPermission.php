<?php

namespace Modules\AdminRoleAuthModule\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class CustomPermission extends SpatiePermission implements TranslatableContract
{
    use Translatable;
    
    protected $table = 'permissions';

    public $translationModel = 'Modules\AdminRoleAuthModule\Models\PermissionTranslation';

    public $translatedAttributes = ['permission_name'];

    public $fillable = ['name', 'guard_name', 'permission_group_id', 'permission_order', 'permission_icon', 'permission_url'];

    public function permission_group()
    {
        return $this->belongsTo(PermissionGroup::class, 'permission_group_id', 'id');
    }
}