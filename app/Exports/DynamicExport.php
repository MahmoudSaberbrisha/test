<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Cache;

class DynamicExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithDrawings
{
    protected $data;
    protected $headings;
    protected $title;
    protected $companyName;
    protected $logoPath;
    protected $totalsData;

    public function __construct($data, $headings, $title, $totalsData = [])
    {
        $settings = Cache::get('settings');
        $this->data = $data;
        $this->headings = $headings;
        $this->title = $title;
        $this->companyName = $settings['site_name']->value??config('app.name');
        $this->logoPath = $settings['site_icon']->getProcessedValue()??''; 
        $this->totalsData = $totalsData; 
    }

    public function collection()
    {
        $headerRow = 5; 
        $dataRow = $headerRow + 1; 

        $columnCount = count($this->headings);

        $emptyRows = array_fill(0, $dataRow - 1, array_fill(0, $columnCount, ''));

        $dataArray = $this->data instanceof \Illuminate\Support\Collection ? $this->data->toArray() : $this->data;

        $formattedData = collect($dataArray)->map(function ($row) {
                return array_map(function ($value, $columnName) {
                    if (in_array($columnName, [__('Phone'), __('Mobile')])) {
                        return $value;
                    }
                    return is_numeric($value) ? number_format($value, 2) : $value;
                }, $row, array_keys($row));
            })->toArray();

        $this->totalsData = collect($this->totalsData)->map(function ($row) {
                return array_map(function ($value, $columnName) {
                    return is_numeric($value) ? number_format($value, 2) : $value;
                }, $row, array_keys($row));
            })->toArray();

        if (property_exists($this, 'totalsData') && !empty($this->totalsData)) {
            foreach ($this->totalsData as $totalRow) {
                $formattedData[] = $totalRow;
            }
        }

        $finalData = array_merge($emptyRows, $formattedData);

        return collect($finalData);
    }

    public function headings(): array
    {
        $emptyColumnsCount = intval(count($this->headings) / 2);
        $emptyColumns = array_fill(0, $emptyColumnsCount, '');
        return [
            [''],
            array_merge($emptyColumns, [$this->companyName]), 
            array_merge($emptyColumns, [$this->title]),
            [''], 
            $this->headings,
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName($this->companyName);
        $drawing->setDescription($this->companyName);
        $drawing->setPath($this->logoPath);
        $drawing->setHeight(70);
        $drawing->setCoordinates('A1'); 

        return $drawing;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2 => ['font' => ['bold' => true, 'size' => 16], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            3 => ['font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '4CAF50']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            5 => ['font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4CAF50']]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $columnCount = count($this->headings());
                $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnCount); 
                $emptyColumnsCount = intval($columnCount / 2);
                $startColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($emptyColumnsCount + 1); 

                $sheet->mergeCells("{$startColumn}1:{$lastColumn}1");
                $sheet->setCellValue("{$startColumn}1", $this->companyName);
                $sheet->getStyle("{$startColumn}1")->getFont()->setSize(16)->setBold(true);
                $sheet->getStyle("{$startColumn}1")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("{$startColumn}1")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $sheet->mergeCells("{$startColumn}2:{$lastColumn}2"); 
                $sheet->setCellValue("{$startColumn}2", $this->title);
                $sheet->getStyle("{$startColumn}2")->getFont()->setSize(14)->setBold(true)->getColor()->setRGB('4CAF50');
                $sheet->getStyle("{$startColumn}2")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("{$startColumn}2")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $headerRow = 5; 
                $sheet->fromArray([$this->headings], null, "A{$headerRow}");

                $dataRow = $headerRow + 1; 

                if (!empty($this->totalsData)) {
                    $firstTotalRow = $dataRow + count($this->data);
                    foreach ($this->totalsData as $index => $totalRow) {
                        $currentRow = $firstTotalRow + $index;
                        
                        $sheet->getStyle("A{$currentRow}:{$lastColumn}{$currentRow}")
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('FFE1E4E7');
                        
                        $sheet->getStyle("A{$currentRow}:H{$currentRow}")
                            ->getFont()
                            ->setBold(true);
                    }
                }

                foreach ($this->data as $index => $row) {
                    $sheet->fromArray($row, null, "A" . ($dataRow + $index));
                }

                $sheet->getStyle("A{$headerRow}:{$lastColumn}{$headerRow}")
                    ->applyFromArray([
                        'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                        'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4CAF50']],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
                    ]);

                foreach (range('A', $lastColumn) as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            },
        ];
    }

}
