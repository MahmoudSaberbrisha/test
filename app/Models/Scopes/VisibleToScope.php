<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Schema;

class VisibleToScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model)
    {
        $guard = auth()->getDefaultDriver();
        $user = auth($guard)->user();

        $model = $builder->getModel();
        $modelClass = get_class($model);
        $modelName = class_basename($modelClass);
        $tableName = $model->getTable();

        if (!$user) {
            return $builder;
        }

        if($user->region_id == null && $user->branch_id == null) {
            return true;
        }

        if (Schema::hasColumn($tableName, 'branch_id')) {
            return $builder->where('branch_id', $user->branch_id);
        }
        if (method_exists($model, 'branch')) {
            return $builder->whereHas('branch', function ($query) use ($user) {
                $query->where('branches.id', $user->branch_id);
            });
        }
        if ($modelName == 'Branch')
            return $builder->where('id', $user->branch_id);
        
        return true;
    }
}
