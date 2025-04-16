<?php

namespace Modules\AdminRoleAuthModule\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('features')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $features = [
            'languages-feature'        => now(),
            'smtp-feature'             => now(),
            'file-manager-feature'     => now(),
            'background-image-feature' => null,
            'branches-feature'         => now(),
            'currencies-feature'       => now(),
            'regions-branches-feature' => null,
            'types-feature'            => now(),
            'firebase-feature'         => null,
            'track-financials-feature' => null,
        ];

        foreach ($features as $feature => $active_at) {
            DB::table('features')->updateOrInsert(
                ['feature' => $feature],
                ['feature' => $feature,'active_at' => $active_at]
            );
        }
    }
}
