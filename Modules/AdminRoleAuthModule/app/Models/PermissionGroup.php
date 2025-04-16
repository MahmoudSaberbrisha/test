<?php

namespace Modules\AdminRoleAuthModule\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Spatie\Permission\Models\Permission as SpatiePermission;

class PermissionGroup extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'permission_groups';

    public $translationModel = 'Modules\AdminRoleAuthModule\Models\PermissionGroupTranslation';

    public $translatedAttributes = ['group_name'];

    public $fillable = ['group_order', 'group_icon'];

    public function permissions()
    {
        return $this->hasMany(CustomPermission::class, 'permission_group_id', 'id');
    }

}
