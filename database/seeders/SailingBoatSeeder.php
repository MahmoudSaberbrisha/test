<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SailingBoat;

class SailingBoatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sailing_boats')->truncate();
        DB::table('sailing_boat_translations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        SailingBoat::updateOrCreate([
            'id' => 1
        ],
        [
            'active' => 1,
            'branch_id' => 1,
            'en' => [
                'name' => 'Classic',
            ],
            'ar' => [
                'name' => 'كلاسيك ',
            ]
        ]);

        SailingBoat::updateOrCreate([
            'id' => 2
        ],
        [
            'active' => 1,
            'branch_id' => 2,
            'en' => [
                'name' => 'Sailing Boat 2',
            ],
            'ar' => [
                'name' => 'مركب 2',
            ]
        ]);
    }
}
