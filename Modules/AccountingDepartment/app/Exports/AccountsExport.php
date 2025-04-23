<?php

namespace Modules\AccountingDepartment\Exports;

use Modules\AccountingDepartment\Models\ChartOfAccount;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AccountsExport implements FromCollection, WithHeadings
{
    /**
     * Return a collection of accounts data for export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Get all accounts with relevant fields
        return ChartOfAccount::select('id', 'account_name', 'account_number', 'account_status', 'account_type', 'parent_id')
            ->orderBy('account_number')
            ->get();
    }

    /**
     * Define the headings for the Excel sheet.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Account Name',
            'Account Number',
            'Account Status',
            'Account Type',
            'Parent ID',
        ];
    }
}