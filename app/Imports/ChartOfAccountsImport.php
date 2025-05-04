<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\AccountingDepartment\Models\ChartOfAccount;

class ChartOfAccountsImport implements ToCollection, WithHeadingRow
{
    /**
     * Handle the collection of rows from the Excel file.
     *
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            ChartOfAccount::updateOrCreate(
                ['id' => $row['id']],
                [
                    'account_name' => $row['account_name'],
                    'account_type' => $row['account_type'] ?? null,
                    'account_status' => $row['account_status'] ?? null,
                    'account_number' => $row['account_number'],
                    'parent_id' => $row['parent_id'] ?? null,
                    'is_cost_center' => $row['is_cost_center'] ?? null,
                ]
            );
        }
    }
}
