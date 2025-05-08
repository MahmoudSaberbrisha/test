<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\AdminRoleAuthModule\Models\PermissionGroup;

class AddedPermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'ar' => [ 'group_name' => 'إدارة الخدمات البحرية'],
                'en' => [ 'group_name' => 'Services Management'],
            ],
            [
                'ar' => [ 'group_name' => 'إدارة العملاء'],
                'en' => [ 'group_name' => 'Clients Management'],
            ],
            [
                'ar' => [ 'group_name' => 'إدارة الحجوزات'],
                'en' => [ 'group_name' => 'Bookings Management'],
            ],
            [
                'ar' => [ 'group_name' => 'إدارة الخدمات الإضافية'],
                'en' => [ 'group_name' => 'Extra Services Management'],
            ],
            [
                'ar' => [ 'group_name' => 'إدارة المالية'],
                'en' => [ 'group_name' => 'Financial Management'],
            ],
            [
                'ar' => [ 'group_name' => 'إدارة الموظفين'],
                'en' => [ 'group_name' => 'Eemployee Management'],
            ],
            [
                'ar' => [ 'group_name' => 'إدارة السيارات'],
                'en' => [ 'group_name' => 'Car Management'],
            ],
            [
                'ar' => [ 'group_name' => 'التقارير والإحصائيات'],
                'en' => [ 'group_name' => 'Reports & Statistics'],
            ],
            [
                'ar' => ['group_name' => 'إدارة المحاسبه '],
                'en' => ['group_name' => 'Accounting Management'],
            ],
            [
                'ar' => ['group_name' => 'إدارة المخازن'],
                'en' => ['group_name' => 'Store Management'],
            ],
        ];

        foreach ($groups as $key => $group) {
            PermissionGroup::create($group);
        }
    }
}
