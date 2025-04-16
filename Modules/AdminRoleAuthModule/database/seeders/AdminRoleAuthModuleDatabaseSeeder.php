<?php

namespace Modules\AdminRoleAuthModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AddedPermissionsSeeder;
use Database\Seeders\AddedPermissionGroupSeeder;

class AdminRoleAuthModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            PermissionGroupSeeder::class,
            AddedPermissionGroupSeeder::class,
            AdminPermissionsSeeder::class,
            AddedPermissionsSeeder::class,
            RolesSeeder::class,
            RegionSeeder::class,
            BranchSeeder::class,
            TypeSeeder::class,
            AdminsSeeder::class,
            LanguagesSeeder::class,
            GeneralSettingsSeeder::class,
            CurrencySeeder::class,
        ]);
    }
}
