<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Validation\Rule;
use App\Models\Client;

class ClientsImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    protected $failures = []; 

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                $client = Client::create($row);
            } catch (\Exception $e) {
                $this->failures[] = [
                    'row' => $row, 
                    'error' => $e->getMessage(), 
                ];
            }
        }
    }

    public function rules(): array
    {
        return [
            '*.id' => ['nullable', 'integer', 'exists:clients,id'],
            '*.name' => 
                [
                    'required', 
                    'string', 
                    function ($attribute, $value, $fail) {
                        if (\DB::table('clients')->where('name', $value)->exists()) {
                            $fail(__('The name is already taken.'));
                        }
                    }
                ],
            '*.phone' => [
                'required',
                'numeric',
                'digits_between:1,14',
                function ($attribute, $value, $fail) {
                    if (\DB::table('clients')
                        ->where('id', '!=', $rowId ?? null)
                        ->where(function ($query) use ($value) {
                            $query->where('phone', $value)
                                  ->orWhere('mobile', $value);
                        })
                        ->exists()) {
                        $fail(__('The phone number is already taken.'));
                    }
                }
            ],
            '*.mobile' => [
                'required',
                'numeric',
                'digits_between:1,14',
                function ($attribute, $value, $fail) {
                    if (\DB::table('clients')
                        ->where(function ($query) use ($value) {
                            $query->where('phone', $value)
                                  ->orWhere('mobile', $value);
                        })
                        ->exists()) {
                        $fail(__('The mobile number is already taken.'));
                    }
                }
            ],
            '*.national_id' => 
            [
                'nullable', 
                'numeric', 
                'digits_between:1,14',
                function ($attribute, $value, $fail) {
                    if (\DB::table('clients')->where('national_id', $value)->exists()) {
                        $fail(__('The national ID is already taken.'));
                    }
                }
            ],
            '*.passport_number' => 
            [
                'nullable', 
                'string', 
                function ($attribute, $value, $fail) {
                    if (\DB::table('clients')->where('passport_number', $value)->exists()) {
                        $fail(__('The passport number is already taken.'));
                    }
                }
            ],
            '*.country' => 'nullable|string',
            '*.state' => 'nullable|string',
            '*.area' => 'nullable|string',
            '*.city' => 'nullable|string',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->failures[] = [
                'row' => $failure->row(), 
                'error' => $failure->errors()[0], 
            ];
        }
    }

    public function getFailures()
    {
        return $this->failures;
    }
}