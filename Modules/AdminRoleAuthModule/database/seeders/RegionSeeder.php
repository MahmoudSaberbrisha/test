<?php

namespace Modules\AdminRoleAuthModule\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\AdminRoleAuthModule\Models\Region;
use YlsIdeas\FeatureFlags\Facades\Features;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Features::accessible('regions-branches-feature')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('regions')->truncate();
            DB::table('region_translations')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            Region::updateOrCreate([
                'id' => 1
            ],
            [
                'active' => 1,
                'en' => [
                    'name' => 'Region 1',
                ],
                'ar' => [
                    'name' => 'منطقة 1',
                ]
            ]);

            Region::updateOrCreate([
                'id' => 2
            ],
            [
                'active' => 1,
                'en' => [
                    'name' => 'Region 2',
                ],
                'ar' => [
                    'name' => 'منطقة 2',
                ]
            ]);
        }
    }
}
