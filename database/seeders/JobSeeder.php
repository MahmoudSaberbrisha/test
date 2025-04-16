<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SettingJob;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('setting_jobs')->truncate();
        DB::table('setting_job_translations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        SettingJob::updateOrCreate([
            'id' => 1
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Representative',
            ],
            'ar' => [
                'name' => 'مندوب',
            ]
        ]);

        SettingJob::updateOrCreate([
            'id' => 2
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Accountant',
            ],
            'ar' => [
                'name' => 'محاسب',
            ]
        ]);

        SettingJob::updateOrCreate([
            'id' => 3
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Employee',
            ],
            'ar' => [
                'name' => 'موظف',
            ]
        ]);
    }
}
