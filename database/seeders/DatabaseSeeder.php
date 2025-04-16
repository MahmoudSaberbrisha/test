<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Modules\AdminRoleAuthModule\Database\Seeders\AdminRoleAuthModuleDatabaseSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            JobSeeder::class,
            AdminRoleAuthModuleDatabaseSeeder::class,
            /*ClientSupplierSeeder::class,
            GoodSeeder::class,
            PaymentMethodSeeder::class,
            ClientTypeSeeder::class,
            SailingBoatSeeder::class,
            ExtraServiceSeeder::class,
            AccountTypeSeeder::class,*/
        ]);
    }
}
