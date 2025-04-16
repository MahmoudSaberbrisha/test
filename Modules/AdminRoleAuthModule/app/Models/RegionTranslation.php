<?php

namespace Modules\AdminRoleAuthModule\Models;

use Illuminate\Database\Eloquent\Model;

class RegionTranslation extends Model
{
    public $fillable = ['region_id', 'name', 'locale'];
}
