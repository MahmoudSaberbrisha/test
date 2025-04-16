<?php

namespace Modules\AdminRoleAuthModule\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\AdminRoleAuthModule\Models\Type;
use YlsIdeas\FeatureFlags\Facades\Features;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Features::accessible('types-feature')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('types')->truncate();
            DB::table('type_translations')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            Type::updateOrCreate([
                'id' => 1
            ],
            [
                'active' => 1,
                'en' => [
                    'name' => 'Fishing',
                ],
                'ar' => [
                    'name' => 'صيد',
                ]
            ]);

            Type::updateOrCreate([
                'id' => 2
            ],
            [
                'active' => 1,
                'en' => [
                    'name' => 'Full day morning',
                ],
                'ar' => [
                    'name' => 'يوم كامل صباحي',
                ]
            ]);

            Type::updateOrCreate([
                'id' => 3
            ],
            [
                'active' => 1,
                'en' => [
                    'name' => 'Sunrise',
                ],
                'ar' => [
                    'name' => 'شروق شمس',
                ]
            ]);

            Type::updateOrCreate([
                'id' => 4
            ],
            [
                'active' => 1,
                'en' => [
                    'name' => 'Full day evening',
                ],
                'ar' => [
                    'name' => 'يوم كامل مسائي',
                ]
            ]);
        }
    }
}
