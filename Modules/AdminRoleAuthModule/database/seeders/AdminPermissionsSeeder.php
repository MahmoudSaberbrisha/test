<?php

namespace Modules\AdminRoleAuthModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use YlsIdeas\FeatureFlags\Facades\Features;

class AdminPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $permissions = [
            // Dashboard
            'View Dashboard',

            // Admins
            'View Admins',
            'Create Admins',
            'Edit Admins',
            'Delete Admins',

            // Admin Roles
            'View Admin Roles',
            'Create Admin Roles',
            'Edit Admin Roles',
            'Delete Admin Roles',

            // Site Settings
            'View Site Settings',
            'Edit Site Settings',
        ];
        $group_id = [
            null, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2
        ];

        if (Features::accessible('languages-feature')) {
            $array = [
                // Languages
                'View Languages',
                'Create Languages',
                'Edit Languages',
                'Delete Languages',
            ];
            $group_id_array = [
                2, 2, 2, 2
            ];
            $permissions = array_merge($permissions, $array);
            $group_id = array_merge($group_id, $group_id_array);
        }

        if (Features::accessible('smtp-feature')) {
            $array = [
                // SMTP Settings
                'View SMTP Settings',
                'Edit SMTP Settings',
            ];
            $group_id_array = [
                2, 2  
            ];
            $permissions = array_merge($permissions, $array);
            $group_id = array_merge($group_id, $group_id_array);
        }

        if (Features::accessible('firebase-feature')) {
            $array = [
                // Firebase Settings
                'View Firebase Settings',
                'Edit Firebase Settings',
            ];
            $group_id_array = [
                2, 2  
            ];
            $permissions = array_merge($permissions, $array);
            $group_id = array_merge($group_id, $group_id_array);
        }

        if (Features::accessible('branches-feature')) {
            $array = [
                // Branches
                'View Branches',
                'Create Branches',
                'Edit Branches',
                'Delete Branches',
            ];
            $group_id_array = [
                2, 2, 2, 2
            ];
            $permissions = array_merge($permissions, $array);
            $group_id = array_merge($group_id, $group_id_array);
        }

        if (Features::accessible('regions-branches-feature')) {
            $array = [
                // Regions
                'View Regions',
                'Create Regions',
                'Edit Regions',
                'Delete Regions',
            ];
            $group_id_array = [
                2, 2, 2, 2
            ];
            $permissions = array_merge($permissions, $array);
            $group_id = array_merge($group_id, $group_id_array);
        }

        if (Features::accessible('types-feature')) {
            $array = [
                // Types
                'View Types',
                'Create Types',
                'Edit Types',
                'Delete Types',
            ];
            $group_id_array = [
                4, 4, 4, 4
            ];
            $permissions = array_merge($permissions, $array);
            $group_id = array_merge($group_id, $group_id_array);
        }

        if (Features::accessible('currencies-feature')) {
            $array = [
                // Currencies
                'View Currencies',
                'Create Currencies',
                'Edit Currencies',
                'Delete Currencies',
            ];
            $group_id_array = [
                2, 2, 2, 2
            ];
            $permissions = array_merge($permissions, $array);
            $group_id = array_merge($group_id, $group_id_array);
        }

        if (Features::accessible('file-manager-feature')) {
            $array = [
                // File Manager
                'View File Manager',
            ];
            $group_id_array = [
                3 
            ];
            $permissions = array_merge($permissions, $array);
            $group_id = array_merge($group_id, $group_id_array);
        }

        $guards = config()->get('permission.guards');

        foreach ($guards as $key => $guard) {
            foreach($permissions as $permission_key => $permission){
                $row = Permission::updateOrCreate([
                    'name' => $permission,
                    'guard_name'=> $guard
                ],[
                    'name' => $permission,
                    'permission_group_id' => $group_id[$permission_key]
                ]);
            }
        }
    }
}
