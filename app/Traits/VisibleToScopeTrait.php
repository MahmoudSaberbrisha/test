<?php 

namespace App\Traits;

use App\Models\Scopes\VisibleToScope;

trait VisibleToScopeTrait
{
    protected static function bootVisibleToScopeTrait()
    {
        static::addGlobalScope(new VisibleToScope);
    }
}