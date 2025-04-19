<?php

namespace Modules\AccountingDepartment\Database\Seeders;


use Modules\AccountingDepartment\Database\Seeders\EntriesSeeder;

class AccountingDepartmentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            EntriesSeeder::class,
        ]);
    }
}
