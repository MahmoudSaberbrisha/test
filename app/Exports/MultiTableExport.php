<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Cache;

class MultiTableExport implements FromCollection, ShouldAutoSize, WithStyles, WithDrawings, WithEvents
{
    protected $tables;
    protected $companyName;
    protected $logoPath;
    protected $reportTitle;

    public function __construct(array $tables, $reportTitle)
    {
        $settings = Cache::get('settings');
        $this->tables = $tables;
        $this->reportTitle = $reportTitle;
        $this->companyName = $settings['site_name']->value??config('app.name');
        $this->logoPath = $settings['site_icon']->getProcessedValue()??'';
    }

	public function collection()
	{
	    $finalData = [];

	    $finalData[] = ['', $this->companyName];
	    $finalData[] = ['', $this->reportTitle];
	    $finalData[] = ['']; 

	    foreach ($this->tables as $table) {
	        if (!empty($table['title'])) {
	            $finalData[] = [$table['title']];
	        }

	        if (!empty($table['headings']) && !in_array($table['headings'], $finalData)) {
	            $finalData[] = $table['headings'];
	        }

	        if (!empty($table['data'])) {
	            $finalData = array_merge($finalData, $table['data']);
	        }

	        $finalData[] = ['']; 
	    }

	    if (count($finalData) <= 3) { 
	        $finalData[] = [__('No records found')];
	    }

	    return collect($finalData);
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
	    $sheet->mergeCells('B1:D1');
	    $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(16);
	    $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

	    $sheet->mergeCells('B2:D2');
	    $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('4CAF50');
	    $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
	}

	public function registerEvents(): array
	{
	    return [
	        AfterSheet::class => function (AfterSheet $event) {
	            $sheet = $event->sheet->getDelegate();
	            $currentRow = 4; 

	            foreach ($this->tables as $table) {
	                $title = $table['title'] ?? null;
	                $headings = $table['headings'] ?? [];
	                $data = $table['data'] ?? [];

	                $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($headings));

	                if ($title) {
	                    $sheet->mergeCells("A{$currentRow}:{$lastColumn}{$currentRow}");
	                    $sheet->setCellValue("A{$currentRow}", $title);
	                    $sheet->getStyle("A{$currentRow}")->applyFromArray([
	                        'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '0000FF']],
	                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
	                    ]);
	                    $currentRow++;
	                }

	                if (!empty($headings)) {
	                    $sheet->fromArray([$headings], null, "A{$currentRow}");
	                    $sheet->getStyle("A{$currentRow}:{$lastColumn}{$currentRow}")->applyFromArray([
	                        'font' => ['bold' => true, 'size' => 12],
	                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D3D3D3']],
	                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
	                    ]);
	                    $currentRow++;
	                }

	                foreach ($data as $rowData) {
	                    $sheet->fromArray($rowData, null, "A{$currentRow}");
	                    $currentRow++;
	                }

	                $currentRow += 1;
	            }
	        }
	    ];
	}
}