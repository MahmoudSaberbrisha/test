<?php

namespace Modules\AccountingDepartment\Imports;

use Modules\AccountingDepartment\Models\Entry;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures as SkipsFailuresTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;

class EntriesImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailuresTrait;

    /**
     * Map each row from the Excel to an Entry model.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        \Illuminate\Support\Facades\Log::info('EntriesImport model method called with row: ' . json_encode($row));

        // Map Arabic or other headings to expected keys
        $mapping = [
            'التاريخ' => 'date',
            'رقم القيد' => 'entry_number',
            'اسم الحساب' => 'account_name',
            'رقم الحساب' => 'account_number',
            'مركز التكلفة' => 'cost_center',
            'المرجع' => 'reference',
            'البيان' => 'description',
            'اسم المستخدم' => 'account_name2',
            'مدين' => 'debit',
            'دائن' => 'credit',
        ];

        $mappedRow = [];
        foreach ($row as $key => $value) {
            $mappedKey = $mapping[$key] ?? $key;
            $mappedRow[$mappedKey] = $value;
        }

        // Validate required fields
        $validator = Validator::make($mappedRow, [
            'date' => 'required|date',
            'entry_number' => 'required',
            'account_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'cost_center' => 'nullable|string',
            'reference' => 'nullable|string',
            'description' => 'nullable|string',
            'account_name2' => 'nullable|string',
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            Log::warning('EntriesImport validation failed for row: ' . json_encode($mappedRow) . ' Errors: ' . json_encode($validator->errors()->all()));
            return null;
        }

        $entry = new Entry([
            'date' => $mappedRow['date'],
            'entry_number' => $mappedRow['entry_number'],
            'account_name' => $mappedRow['account_name'] ?? null,
            'account_name2' => $mappedRow['account_name2'] ?? null,
            'account_number' => $mappedRow['account_number'] ?? null,
            'account_number2' => $mappedRow['account_number2'] ?? null,
            'cost_center' => $mappedRow['cost_center'] ?? null,
            'cost_center2' => $mappedRow['cost_center2'] ?? null,
            'reference' => $mappedRow['reference'] ?? null,
            'reference2' => $mappedRow['reference2'] ?? null,
            'debit' => $mappedRow['debit'] ?? 0,
            'credit' => $mappedRow['credit'] ?? 0,
            'total' => $mappedRow['total'] ?? 0,
            'description' => $mappedRow['description'] ?? null,
        ]);

        $entry->save();

        return $entry;
    }
}
