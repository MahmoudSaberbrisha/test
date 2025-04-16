<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\EmployeeManagement\EmployeeType;

class EmployeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        EmployeeType::updateOrCreate([
            'id' => 1
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'male',
            ],
            'ar' => [
                'name' => 'ذكر',
            ]
        ]);

        EmployeeType::updateOrCreate([
            'id' => 2
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'female',
            ],
            'ar' => [
                'name' => 'أنثى',
            ]
        ]);
    }
}
