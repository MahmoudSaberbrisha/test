<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ClientSupplier;

class ClientSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('client_suppliers')->truncate();
        DB::table('client_supplier_translations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        ClientSupplier::updateOrCreate([
            'id' => 1
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Representative',
            ],
            'ar' => [
                'name' => 'مندوب',
            ]
        ]);

        ClientSupplier::updateOrCreate([
            'id' => 2
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Tourism Company',
            ],
            'ar' => [
                'name' => 'شركة سياحة',
            ]
        ]);

        ClientSupplier::updateOrCreate([
            'id' => 3
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Advertising',
            ],
            'ar' => [
                'name' => 'إعلانات',
            ]
        ]);

        ClientSupplier::updateOrCreate([
            'id' => 4
        ],
        [
            'active' => 1,
            'en' => [
                'name' => 'Contracting Representative',
            ],
            'ar' => [
                'name' => 'مندوب تعاقدات',
            ]
        ]);
    }
}
