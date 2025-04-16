<?php

namespace Modules\AdminRoleAuthModule\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\AdminRoleAuthModule\Models\Admin;
use Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use YlsIdeas\FeatureFlags\Facades\Features;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('admins')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $superadmin = Admin::updateOrCreate([
            'id' => 1
        ], [
            'name'           => 'Super Admin',
            'user_name'      => 'superadmin',
            'phone'          => '01001111111',
            'national_id'    => null,
            'email'          => null,
            'password'       => Hash::make("123456789"),
            'remember_token' => null,
            'image'          => 'admins/default.png'
        ]);

        $superadmin->assignRole('Super Admin');
        
        if (Features::accessible('branches-feature')) {
            $branchmanager = Admin::updateOrCreate([
                'id' => 2
            ], [
                'name'           => 'Branch Manager',
                'user_name'      => 'branchmanager',
                'phone'          => '01001111112',
                'password'       => Hash::make("123456789"),
                'image'          => 'admins/default.png',
                'branch_id'      => 1,
            ]);

            $branchmanager->assignRole('Branch Manager');
        }

        if (Features::accessible('regions-branches-feature')) {
            $regionmanager = Admin::updateOrCreate([
                'id' => 2
            ], [
                'name'           => 'Region Manager',
                'user_name'      => 'regionmanager',
                'phone'          => 01001111112,
                'national_id'    => 22222222222223,
                'email'          => null,
                'password'       => Hash::make("123456789"),
                'remember_token' => null,
                'region_id'      => 1,
                'branch_id'      => null,
                'image'          => 'admins/default.png',
            ]);

            $branchmanager = Admin::updateOrCreate([
                'id' => 3
            ], [
                'name'           => 'Manager',
                'user_name'      => 'manager',
                'phone'          => '01001111112',
                'password'       => Hash::make("123456789"),
                'image'          => 'admins/default.png',
                'region_id'      => 1,
                'branch_id'      => 1,
            ]);

            $regionmanager->assignRole('Region Manager');
            $branchmanager->assignRole('Branch Manager');
        }
    }
}
