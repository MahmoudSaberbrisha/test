<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Good;

class GoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('goods')->truncate();
        DB::table('good_translations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Good::updateOrCreate([
            'id' => 1
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Grilled',
            ],
            'ar' => [
                'name' => 'مشويات',
            ]
        ]);

        Good::updateOrCreate([
            'id' => 2
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Fish',
            ],
            'ar' => [
                'name' => 'أسماك',
            ]
        ]);

        Good::updateOrCreate([
            'id' => 3
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Soft drinks',
            ],
            'ar' => [
                'name' => 'مشروبات غازية',
            ]
        ]);

        Good::updateOrCreate([
            'id' => 4
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Chickens',
            ],
            'ar' => [
                'name' => 'فراخ',
            ]
        ]);
    }
}
