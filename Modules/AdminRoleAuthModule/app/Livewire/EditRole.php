<?php

namespace Modules\AdminRoleAuthModule\Livewire;

use Livewire\Component;
use Modules\AdminRoleAuthModule\RepositoryInterface\RolesRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Livewire\Attributes\On;

class EditRole extends Component
{
    public $guards;
    public $guard;
    public $role;
    public $permissions = [];
    public $groups = [];
    public $permissionsWithoutGroups = [];

    public function mount($role_id = '')
    {
        $roleRepository = App::make(RolesRepositoryInterface::class);
        $this->guards = config()->get('permission.guards');
        $this->role = $roleRepository->findById($role_id);
        $this->guard = $this->role['guard_name'];
        // $this->permissions = $roleRepository->getPermissionsByGuard($this->role['guard_name'])->toArray();
        $this->groups = $roleRepository->getGroupPermissions($this->role['guard_name']);
        $this->permissionsWithoutGroups = $roleRepository->getPermissionsWithoutGroups();
    }

    #[On('changeGuard')]
    public function changeGuard()
    {
        $roleRepository = App::make(RolesRepositoryInterface::class);
        // $this->permissions = $roleRepository->getPermissionsByGuard($this->guard)->toArray();
        $this->groups = $roleRepository->getGroupPermissions($this->guard);
    }

	public function render(): View
	{
        $this->dispatch('checkBoxes');
		return view('adminroleauthmodule::livewire.edit-role');
	}

}
