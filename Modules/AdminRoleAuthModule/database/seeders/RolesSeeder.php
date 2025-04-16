<?php

namespace Modules\AdminRoleAuthModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use YlsIdeas\FeatureFlags\Facades\Features;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $super_admin_permissions =  DB::table('permissions')->where('guard_name', 'admin')->get();
        $branch_manager_permissions =  DB::table('permissions')->where('guard_name', 'admin')->get();
        $region_manager_permissions =  DB::table('permissions')->where('guard_name', 'admin')->get();

        DB::table('roles')->updateOrInsert(
            ['id' => 1],
            ['name' => 'Super Admin','guard_name' => 'admin']
        );
        
        if (Features::accessible('branches-feature')) {
            DB::table('roles')->updateOrInsert(
                ['id' => 2],
                ['name' => 'Branch Manager','guard_name' => 'admin']
            );

            foreach ($branch_manager_permissions as $key => $permission) {
                DB::table('role_has_permissions')->updateOrInsert(
                    [
                        'role_id' => 2,
                        'permission_id' => $permission->id
                    ]
                );
            }
        }

        if (Features::accessible('regions-branches-feature')) {
            DB::table('roles')->updateOrInsert(
                ['id' => 2],
                ['name' => 'Region Manager','guard_name' => 'admin']
            );
            DB::table('roles')->updateOrInsert(
                ['id' => 3],
                ['name' => 'Branch Manager','guard_name' => 'admin']
            );

            foreach ($region_manager_permissions as $key => $permission) {
                DB::table('role_has_permissions')->updateOrInsert(
                    [
                        'role_id' => 2,
                        'permission_id' => $permission->id
                    ]
                );
            }

            foreach ($branch_manager_permissions as $key => $permission) {
                DB::table('role_has_permissions')->updateOrInsert(
                    [
                        'role_id' => 3,
                        'permission_id' => $permission->id
                    ]
                );
            }
        }

        foreach ($super_admin_permissions as $key => $permission) {
            DB::table('role_has_permissions')->updateOrInsert(
                [
                    'role_id' => 1,
                    'permission_id' => $permission->id
                ]
            );
        }
    }
}
