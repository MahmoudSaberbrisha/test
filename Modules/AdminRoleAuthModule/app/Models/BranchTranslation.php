<?php

namespace Modules\AdminRoleAuthModule\Models;

use Illuminate\Database\Eloquent\Model;

class BranchTranslation extends Model
{
    public $fillable = ['branch_id', 'name', 'locale'];
}
