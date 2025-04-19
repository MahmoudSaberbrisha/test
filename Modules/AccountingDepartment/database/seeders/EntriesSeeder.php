<?php

namespace Modules\AccountingDepartment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AccountingDepartment\Models\Entry; // Assuming the Entry model exists
use Modules\AccountingDepartment\Models\ChartOfAccount; // Assuming the ChartOfAccount model exists

class EntriesSeeder extends Seeder
{
    public function run()

    {

        $chartOfAccountIds = ChartOfAccount::pluck('id')->toArray();
        for ($i = 1; $i <= 50; $i++) {
            Entry::create([
                'date' => now()->toDateString(),
                'entry_number' => 'EN' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'account_name' => 'Account ' . $i,
                'account_name2' => 'Account ' . ($i + 1),
                'account_number' => 'ACC' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'account_number2' => 'ACC' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'cost_center' => 'Cost Center ' . $i,
                'cost_center2' => 'Cost Center ' . ($i + 1),
                'reference' => 'Ref ' . $i,
                'reference2' => 'Ref ' . ($i + 1),
                'debit' => rand(100, 1000),
                'credit' => rand(100, 1000),
                'total' => rand(100, 1000),
                // 'chart_of_account_id' => $chartOfAccountIds[array_rand($chartOfAccountIds)], // Randomly assign a chart of account ID

            ]);
        }
    }
}
