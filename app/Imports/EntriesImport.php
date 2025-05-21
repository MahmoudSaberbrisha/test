<?php

namespace App\Imports;

use Modules\AccountingDepartment\Models\Entry;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EntriesImport implements ToModel, WithHeadingRow
{
    /**
     * Map each row from the Excel file to an Entry model.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Entry([
            'cost_center' => $row['cost_center'] ?? null,
            'reference' => $row['reference'] ?? null,
            'type_of_restriction' => $row['type_of_restriction'] ?? null,
            'date' => $row['date'] ?? null,
            'entry_number' => $row['entry_number'] ?? null,
            'description' => $row['description'] ?? null,
        ]);
    }
}
