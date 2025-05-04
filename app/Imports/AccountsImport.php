<?php

namespace App\Imports;

use App\Models\Account;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\AccountingDepartment\Models\ChartOfAccount;

class AccountsImport implements ToCollection, WithHeadingRow
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
            // Assuming the Excel columns are: account_name, account_number, parent_id (optional)
            ChartOfAccount::updateOrCreate(
                ['account_number' => $row['account_number']],
                [
                    'account_name' => $row['account_name'],
                    'parent_id' => $row['parent_id'] ?? null,
                ]
            );
        }
    }
}
