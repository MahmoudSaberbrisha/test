<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ClientType;

class ClientTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('client_types')->truncate();
        DB::table('client_type_translations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        ClientType::updateOrCreate([
            'id' => 1
        ],
        [
            'active' => 1,
            "discount_value" => 0,
            'en' => [
                'name' => 'Regular customer (full ticket)',
            ],
            'ar' => [
                'name' => 'عميل عادي (تيكت كامل)',
            ]
        ]);

        ClientType::updateOrCreate([
            'id' => 2
        ],
        [
            'active' => 1,
            "discount_value" => 100,
            'en' => [
                'name' => 'Free',
            ],
            'ar' => [
                'name' => 'فري',
            ]
        ]);

        ClientType::updateOrCreate([
            'id' => 3
        ],
        [
            'active' => 1,
            "discount_value" => 50,
            'en' => [
                'name' => 'Half ticket client (under age)',
            ],
            'ar' => [
                'name' => 'عميل نص تكت (تحت سن )',
            ]
        ]);

        ClientType::updateOrCreate([
            'id' => 4
        ],
        [
            'active' => 1,
            "discount_value" => 100,
            'en' => [
                'name' => 'Poseidon Hospitality',
            ],
            'ar' => [
                'name' => 'ضيافة شركه بوسيدون',
            ]
        ]);

        ClientType::updateOrCreate([
            'id' => 5
        ],
        [
            'active' => 1,
            "discount_value" => 100,
            'en' => [
                'name' => 'Hospitality of Al Rakia Company',
            ],
            'ar' => [
                'name' => 'ضيافة شركه ع الراكية',
            ]
        ]);

        ClientType::updateOrCreate([
            'id' => 6
        ],
        [
            'active' => 1,
            "discount_value" => 60,
            'en' => [
                'name' => 'Staff Hitam Hospitality 60%',
            ],
            'ar' => [
                'name' => 'ضيافة ستاف هيتم 60%',
            ]
        ]);

        ClientType::updateOrCreate([
            'id' => 7
        ],
        [
            'active' => 1,
            "discount_value" => 40,
            'en' => [
                'name' => 'Staff Hitam Hospitality 40%',
            ],
            'ar' => [
                'name' => 'ضيافة ستاف هيتم 40%',
            ]
        ]);

        ClientType::updateOrCreate([
            'id' => 8
        ],
        [
            'active' => 1,
            "discount_value" => 20,
            'en' => [
                'name' => 'Staff Hitam Hospitality 20%',
            ],
            'ar' => [
                'name' => 'ضيافة ستاف هيتم 20%',
            ]
        ]);
    }
}
