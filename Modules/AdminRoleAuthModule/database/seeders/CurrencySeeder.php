<?php

namespace Modules\AdminRoleAuthModule\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\AdminRoleAuthModule\Models\Currency;
use YlsIdeas\FeatureFlags\Facades\Features;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Features::accessible('currencies-feature')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('currencies')->truncate();
            DB::table('currency_translations')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            Currency::updateOrCreate([
                'id' => 1
            ],
            [
                'active' => 1,
                'default' => 1,
                'code' => "EGP",
                'symbol' => "E£",
                'color' => '#0162e8',
                'ar' => [
                    'name' => 'الجنية المصري',
                ],
                'en' => [
                    'name' => 'Egyptian pound',
                ]
            ]);

            Currency::updateOrCreate([
                'id' => 2
            ],
            [
                'active' => 1,
                'code' => "USD",
                'symbol' => "$",
                'color' => '#ee335e',
                'ar' => [
                    'name' => 'الدولار الامريكي',
                ],
                'en' => [
                    'name' => 'US Dollar',
                ]
            ]);

            Currency::updateOrCreate([
                'id' => 3
            ],
            [
                'active' => 1,
                'code' => "SAR",
                'symbol' => "SAR",
                'color' => '#fbbc0b',
                'en' => [
                    'name' => 'Saudi Riyal',
                ],
                'ar' => [
                    'name' => 'الريال السعودي',
                ]
            ]);

            Currency::updateOrCreate([
                'id' => 4
            ],
            [
                'active' => 1,
                'code' => "EUR",
                'symbol' => "€",
                'color' => '#22c03c',
                'en' => [
                    'name' => 'Euro',
                ],
                'ar' => [
                    'name' => 'يورو',
                ]
            ]);
        }
    }
}
