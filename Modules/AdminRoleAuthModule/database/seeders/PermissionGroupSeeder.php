<?php

namespace Modules\AdminRoleAuthModule\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\AdminRoleAuthModule\Models\PermissionGroup;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permission_groups')->truncate();
        DB::table('permission_group_translations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $groups = [
            [
                'ar' => [ 'group_name' => 'المستخدمين والصلاحيات'],
                'en' => [ 'group_name' => 'Users and Permissions'],
            ],
            [
                'ar' => [ 'group_name' => 'إعدادات عامة'],
                'en' => [ 'group_name' => 'General Settings'],
            ],
            [
                'ar' => [ 'group_name' => 'إدارة الملفات'],
                'en' => [ 'group_name' => 'File Manager'],
            ],
        ];

        foreach ($groups as $key => $group) {
            PermissionGroup::create($group);
        }
    }
}
