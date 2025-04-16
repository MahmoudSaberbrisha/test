<?php

namespace Modules\AdminRoleAuthModule\RepositoryInterface;

interface RolesRepositoryInterface {

    public function getRoles();

    public function getRolesByGuard(string $guard_name = 'admin');
    
    public function getPermissionsByGuard(string $guard = 'admin');
    
    public function getGroupPermissions(string $guard = 'admin');

    public function create(array $request);

    public function findById(int $id);

    public function findByName(string $name);

    public function update(int $id, array $request);

    public function delete(int $id);

}
