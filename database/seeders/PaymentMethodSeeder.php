<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('payment_methods')->truncate();
        DB::table('payment_method_translations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        PaymentMethod::updateOrCreate([
            'id' => 1
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Instapay',
            ],
            'ar' => [
                'name' => 'انستاباي',
            ]
        ]);

        PaymentMethod::updateOrCreate([
            'id' => 2
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Visa',
            ],
            'ar' => [
                'name' => 'فيزا',
            ]
        ]);

        PaymentMethod::updateOrCreate([
            'id' => 3
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Cash',
            ],
            'ar' => [
                'name' => 'كاش',
            ]
        ]);
    }
}
