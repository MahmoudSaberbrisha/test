<?php

namespace Modules\AdminRoleAuthModule\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\AdminRoleAuthModule\Models\Branch;
use YlsIdeas\FeatureFlags\Facades\Features;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Features::accessible('branches-feature')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('branches')->truncate();
            DB::table('branch_translations')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $branch1 = Branch::updateOrCreate([
                'id' => 1
            ],
            [
                'active' => 1,
                'en' => [
                    'name' => 'Porto',
                ],
                'ar' => [
                    'name' => 'بورتو',
                ]
            ]);

            $branch2 = Branch::updateOrCreate([
                'id' => 2
            ],
            [
                'active' => 1,
                'en' => [
                    'name' => 'Marassi',
                ],
                'ar' => [
                    'name' => 'مراسي',
                ]
            ]);

            $branch3 = Branch::updateOrCreate([
                'id' => 3
            ],
            [
                'active' => 1,
                'en' => [
                    'name' => 'Marsa Matruh',
                ],
                'ar' => [
                    'name' => 'مطروح',
                ]
            ]);

            if (Features::accessible('regions-branches-feature')) {
                $branch1->update(['region_id' => 1]);
                $branch2->update(['region_id' => 1]);
            }
        }
    }
}
