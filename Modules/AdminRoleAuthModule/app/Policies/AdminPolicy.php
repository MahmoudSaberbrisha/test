<?php

namespace Modules\AdminRoleAuthModule\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\AdminRoleAuthModule\Models\Admin;
use Modules\AdminRoleAuthModule\RepositoryInterface\RolesRepositoryInterface;

class AdminPolicy
{
    use HandlesAuthorization;

    public $roleRepository;

    /**
     * Create a new policy instance.
     */
    public function __construct(RolesRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        //
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, Admin $targetAdmin): bool
    {
    	//
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin, string $role): bool
    {
    	$authRoleId = $admin->role_id;
    	$roleId = $this->roleRepository->findByName($role)->id;

        if ( $authRoleId == SUPER_ADMIN_ROLE_ID ) {
            return true;
        }

        if ( $authRoleId == EMPLOYEE_ADMIN_ROLE_ID && ! in_array($roleId, UPPER_ROLES) ) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin): bool
    {
        //
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin): bool
    {
        //
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore(Admin $admin, Branch $branch): bool
    {
        //
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Branch $branch): bool
    {
        //
    }
}
