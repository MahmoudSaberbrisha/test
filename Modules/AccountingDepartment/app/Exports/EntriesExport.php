<?php

namespace Modules\AccountingDepartment\Exports;

use Modules\AccountingDepartment\Models\Entry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EntriesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Return a collection of entries to be exported.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Entry::all();
    }

    /**
     * Map data for each row in the export.
     *
     * @param  \Modules\AccountingDepartment\Models\Entry  $entry
     * @return array
     */
    public function map($entry): array
    {
        return [
            $entry->date,
            $entry->entry_number,
            $entry->account_name,
            $entry->account_number,
            $entry->cost_center,
            $entry->reference,
            $entry->description,
            $entry->account_name2,
            $entry->debit,
            $entry->credit,
        ];
    }

    /**
     * Define the headings for the exported file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'التاريخ',
            'رقم القيد',
            'اسم الحساب',
            'رقم الحساب',
            'مركز التكلفة',
            'المرجع',
            'البيان',
            'اسم المستخدم',
            'مدين',
            'دائن',
        ];
    }
}
