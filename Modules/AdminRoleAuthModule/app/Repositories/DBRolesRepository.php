<?php

namespace Modules\AdminRoleAuthModule\Repositories;
use Modules\AdminRoleAuthModule\RepositoryInterface\RolesRepositoryInterface;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Modules\AdminRoleAuthModule\Models\CustomPermission;
use Modules\AdminRoleAuthModule\Models\PermissionGroup;
use Config;

class DBRolesRepository implements RolesRepositoryInterface
{
    protected $mainRoles;

    public function __construct()
    {
        $this->mainRoles = BASIC_ROLES_IDs;
    }

    public function getRoles()
    {
        return Role::get();
    }

    public function getRolesByGuard(string $guard_name = 'admin')
    {
        return Role::where('guard_name', $guard_name)->get();
    }

    public function getPermissionsByGuard(string $guard = 'admin')
    {
        return Permission::where('guard_name', $guard)->get();
    }

    public function getGroupPermissions(string $guard = 'admin')
    {
        return PermissionGroup::withTranslation()
            ->with(['permissions' => function ($q) use ($guard) {
                $q->where('guard_name', $guard);
            }])
            ->get();
    }

    public function getPermissionsWithoutGroups(string $guard = 'admin')
    {
        return CustomPermission::where('guard_name', $guard)->whereDoesntHave('permission_group')->get();
    }

    public function create(array $request)
    {
        $role = Role::create(['name' => $request['name'], 'guard_name' => $request['guard_name']]);
        if (isset($request['permissions'])) {
            $role->syncPermissions($request['permissions']);
        } else {
            $role->syncPermissions([]);
        }
        return $role;
    }

    public function findById($id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function findByName($name)
    {
        return Role::with('permissions')->where('name', $name)->first();
    }

    public function update(int $id, array $request)
    {
        if ($id == SUPER_ADMIN_ROLE_ID)
            return toastr()->error(__('This role cannot be updated because it is essential to the system.'));
        $role = $this->findById($id);
        $role['name'] = $request['name'];
        $role['guard_name'] = $request['guard_name'];
        $role->save();
        if (isset($request['permissions'])) {
            $permissions = Permission::whereIn('id', $request['permissions'])->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }
        return toastr()->success(__('Record successfully updated.')); 
    }

    public function delete(int $id)
    {
        $currentRole = auth()->user()->getRoleNames()->first();
        $role = $this->findById($id);
        if ($role->name == $currentRole) 
            return toastr()->error(__('You cannot delete your own role.'));
        if (in_array($id, $this->mainRoles))
            return toastr()->error(__('This role cannot be deleted because it is essential to the system.'));
        $role->delete();
        return toastr()->success(__('Record successfully deleted.'));
    }
}
