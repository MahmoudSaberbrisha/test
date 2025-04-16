<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use DB;
use App\Models\BookingGroup;
use App\Exports\MultiTableExport;
use Maatwebsite\Excel\Facades\Excel;

class ClientSuppliersReport extends Component
{
    public $fromDate = null;
    public $toDate = null;
    public $reportData = [];
    public $totalPerCurrencyView, $totalEarningsPerCurrencyView;

    public function resetReportData()
    {
        $this->reset(['reportData']);
    }

    public function getReportData()
    {
        $this->resetReportData();

        if ($this->fromDate && $this->toDate && $this->toDate < $this->fromDate) {
            toastr()->error(__('The "To Date" must be a day after the "From Date".'));
        }

        $daysCount = Carbon::parse($this->fromDate)->diffInDays($this->toDate) ?: 1;

        $totalPerCurrency = BookingGroup::with('currency')
            ->select(
                'currency_id',
                DB::raw('SUM(total) as total_currency_sales')
            )
            ->whereHas('booking', function ($q) {
                $q->whereBetween('booking_date', [$this->fromDate, $this->toDate]);
            })
            ->groupBy('currency_id');

        $this->totalPerCurrencyView = $totalPerCurrency->get();
        $totalPerCurrency = $totalPerCurrency->pluck('total_currency_sales', 'currency_id'); 

        $totalEarningsPerCurrency = BookingGroup::with('currency')
            ->select(
                'currency_id',
                DB::raw('SUM(client_supplier_value * total / 100) as total_currency_earnings')
            )
            ->whereHas('booking', function ($q) {
                $q->whereBetween('booking_date', [$this->fromDate, $this->toDate]);
            })
            ->groupBy('currency_id');
        $this->totalEarningsPerCurrencyView = $totalEarningsPerCurrency->get();
        $totalEarningsPerCurrency = $totalEarningsPerCurrency->pluck('total_currency_earnings', 'currency_id'); 

        $this->reportData = BookingGroup::with([
                'client_supplier',
                'currency',
                'booking'
            ])
            ->whereHas('booking', function ($q) {
                $q->whereBetween('booking_date', [$this->fromDate, $this->toDate]);
            })
            ->select(
                'supplier_type',
                'client_supplier_id',
                'currency_id',
                'client_supplier_value',
                DB::raw('SUM(total) as total_sales'),
                DB::raw('ROUND(SUM(client_supplier_value * total / 100), 2) as supplier_earnings'),
                DB::raw('ROUND(SUM(client_supplier_value * total / 100) / ' . $daysCount . ', 2) as daily_avg_sales'),
                DB::raw('ROUND((SUM(client_supplier_value * total / 100) / 51) / 5) * 5 as adjusted_sales')
            )
            ->groupBy('client_supplier_id', 'supplier_type', 'currency_id')
            ->orderBy('client_supplier_id')
            ->get()
            ->map(function ($report) use ($totalPerCurrency) {
                $totalCurrencySales = $totalPerCurrency[$report->currency_id]!=0 ? $totalPerCurrency[$report->currency_id] : 1; 
                $report->percentage_of_currency = round(($report->total_sales / $totalCurrencySales), 2);
                return $report;
            })
            ->map(function ($report) use ($totalEarningsPerCurrency) {
                $totalCurrencyEarnings = $totalEarningsPerCurrency[$report->currency_id] !=0 ? $totalEarningsPerCurrency[$report->currency_id] : 1;
                $report->percentage_earingd_of_currency = round(($report->supplier_earnings / $totalCurrencyEarnings), 2);
                return $report;
            });
    }

    public function exportPdf()
    {
        $this->getReportData();
        session()->put('reportData', [
            'reportData'                   => $this->reportData,
            'totalPerCurrencyView'         => $this->totalPerCurrencyView,
            'totalEarningsPerCurrencyView' => $this->totalEarningsPerCurrencyView,
        ]);
        session()->put('view', 'admin.pages.reports.print.client-suppliers-report');
        session()->put('title', __('Client Suppliers Report'));
        session()->put('format', 'A4-L');
        $pdfUrl = route(auth()->getDefaultDriver().'.print-report');
        $this->dispatch('openPdf', ['url' => $pdfUrl]);
    }

    public function exportExcel()
    {
        $this->getReportData();
        $reportData = $this->reportData->map(function ($item) {
            return [
                $item->client_supplier->name ?? '-',
                $item->currency->code,
                $item->total_sales,
                $item->client_supplier_value . ' %',
                $item->supplier_earnings,
                $item->percentage_of_currency,
                $item->percentage_earingd_of_currency,
                $item->daily_avg_sales,
                $item->adjusted_sales,
            ];
        })->toArray();

        if (empty($reportData)) {
            $reportData = [[__('No Data Found.'), '', '', '', '', '', '', '', '']];
        }

        $totalPerCurrencyView = collect($this->totalPerCurrencyView)->map(function ($currency, $key) {
            return [
                $currency->currency->name,
                $currency->total_currency_sales, 
                $this->totalEarningsPerCurrencyView[$key]->total_currency_earnings
            ];
        })->toArray();

        if (empty($totalPerCurrencyView)) {
            $totalPerCurrencyView = [[__('No Data Found.'), null, null]];
        }

        $tables = [
            [
                'title' => __('Client Suppliers'),
                'headings' => [
                    __('Name'),
                    __('Currency'),
                    __('Total Sales'),
                    __('Value'),
                    __('Supplier Earnings'),
                    __('Percentage Sales'),
                    __('Percentage Earings Sales'),
                    __('Daily Avg Sales'),
                    __('Adjusted Sales')
                ],
                'data' => $reportData,
            ],
            [
                'title' => __('Total'),
                'headings' => [
                    __('Currency'),
                    __('Total Sales'),
                    __('Total Supplier Earnings'),
                ],
                'data' => $totalPerCurrencyView,
            ],
        ];

        return Excel::download(new MultiTableExport($tables, __('Client Suppliers Report')), 'client_suppliers_report.xlsx');
    }

    public function render(): View
    {
        return view('admin.livewire.reports.client-suppliers-report');
    }
}
