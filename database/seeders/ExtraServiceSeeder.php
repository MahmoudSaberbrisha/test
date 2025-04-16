<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ExtraService;

class ExtraServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('extra_services')->truncate();
        DB::table('extra_service_translations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        ExtraService::updateOrCreate([
            'id' => 1
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Meals',
            ],
            'ar' => [
                'name' => 'وجبات',
            ]
        ]);

        ExtraService::updateOrCreate([
            'id' => 2
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Photographer',
            ],
            'ar' => [
                'name' => 'التصوير',
            ]
        ]);

        ExtraService::updateOrCreate([
            'id' => 3
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Water Games',
            ],
            'ar' => [
                'name' => 'ألعاب مائية',
            ]
        ]);

        ExtraService::updateOrCreate([
            'id' => 4
        ],
        [
            'active' => 1,
            'parent_id' => 3,
            'en' => [
                'name' => 'Banana',
            ],
            'ar' => [
                'name' => 'الموزة',
            ]
        ]);

        ExtraService::updateOrCreate([
            'id' => 5
        ],
        [
            'active' => 1,
            'parent_id' => 3,
            'en' => [
                'name' => 'Tube',
            ],
            'ar' => [
                'name' => 'تيوب',
            ]
        ]);

        ExtraService::updateOrCreate([
            'id' => 6
        ],
        [
            'active' => 1,
            'parent_id' => 3,
            'en' => [
                'name' => 'Donut',
            ],
            'ar' => [
                'name' => 'دونت',
            ]
        ]);

        ExtraService::updateOrCreate([
            'id' => 7
        ],
        [
            'active' => 1,
            'parent_id' => 3,
            'en' => [
                'name' => 'Butterfly',
            ],
            'ar' => [
                'name' => 'الفراشة',
            ]
        ]);

        ExtraService::updateOrCreate([
            'id' => 8
        ],
        [
            'active' => 1,
            'parent_id' => 3,
            'en' => [
                'name' => 'InBoat',
            ],
            'ar' => [
                'name' => 'في المركب',
            ]
        ]);

        ExtraService::updateOrCreate([
            'id' => 9
        ],
        [
            'active' => 1,
            'parent_id' => 3,
            'en' => [
                'name' => 'Delivery',
            ],
            'ar' => [
                'name' => 'توصيل',
            ]
        ]);

        ExtraService::updateOrCreate([
            'id' => 10
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Parachute',
            ],
            'ar' => [
                'name' => 'براشوت',
            ]
        ]);

        ExtraService::updateOrCreate([
            'id' => 11
        ],
        [
            'active' => 1,
            'parent_id' => 10,
            'en' => [
                'name' => 'Single',
            ],
            'ar' => [
                'name' => 'فردي',
            ]
        ]);

        ExtraService::updateOrCreate([
            'id' => 12
        ],
        [
            'active' => 1,
            'parent_id' => 10,
            'en' => [
                'name' => 'Double',
            ],
            'ar' => [
                'name' => 'زوجي',
            ]
        ]);
    }
}
