<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use App\Models\ExtraService;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicExport;

class ExtraServicesReport extends Component
{
    private $currencyRepository, $branchRepository;

    public $branch_id = 'all';
    public $currency_id = 'all';
    public $branches = [];
    public $currencies = [];
    public $extraServicesReport = [];
    public $currencyTotals = [];

    public function resetReportData()
    {
        $this->reset(['extraServicesReport', 'currencyTotals']);
    }

    public function __construct()
    {
        $this->currencyRepository = app(CurrencyRepositoryInterface::class);
        $this->branchRepository = App::make('BranchCrudRepository');
    }

    public function mount()
    {
        $this->currencies = $this->currencyRepository->getAll();
        $this->branches = $this->branchRepository->getAll();
    }

    public function getReportData()
    {
        $this->resetReportData();
        
        $extraServicesReport = ExtraService::query()
            ->selectRaw('
                COALESCE(parent_services.id, extra_services.id) as parent_id,
                COALESCE(parent_translations.name, extra_translations.name, "-") as parent_service_name,
                extra_services.id as service_id,
                extra_translations.name as service_name,
                SUM(booking_group_services.services_count) as service_count,
                SUM(booking_group_services.total) as total_sales,
                currency_translations.name as currency_name,
                (SUM(booking_group_services.total) / SUM(booking_group_services.services_count)) as total_income
            ')
            ->join('booking_group_services', 'extra_services.id', '=', 'booking_group_services.extra_service_id')
            ->join('currencies', 'booking_group_services.currency_id', '=', 'currencies.id')
            ->join('currency_translations', function ($join) {
                $join->on('currencies.id', '=', 'currency_translations.currency_id')
                     ->where('currency_translations.locale', '=', app()->getLocale());
            })
            ->leftJoin('extra_services as parent_services', 'extra_services.parent_id', '=', 'parent_services.id')
            ->leftJoin('extra_service_translations as parent_translations', function ($join) {
                $join->on('parent_services.id', '=', 'parent_translations.extra_service_id')
                     ->where('parent_translations.locale', '=', app()->getLocale());
            })
            ->leftJoin('extra_service_translations as extra_translations', function ($join) {
                $join->on('extra_services.id', '=', 'extra_translations.extra_service_id')
                     ->where('extra_translations.locale', '=', app()->getLocale());
            })
            ->groupBy('parent_id', 'currency_translations.name', 'parent_service_name');
        
        if ($this->branch_id != 'all') {
            $extraServicesReport = $extraServicesReport->where('booking_group_services.branch_id', $this->branch_id);
        }

        if ($this->currency_id != 'all') {
            $extraServicesReport = $extraServicesReport->where('booking_group_services.currency_id', $this->currency_id);
        }

        $extraServicesReport = $extraServicesReport->get();

        $this->currencyTotals = $extraServicesReport->groupBy('currency_name')->map(function ($group) {
            return [
                'total_service_count' => $group->sum('service_count'),
                'total_sales' => $group->sum('total_sales'),
                'average_revenue' => $group->sum('total_income'),
            ];
        });

        $this->extraServicesReport = $extraServicesReport;
    }

    public function exportPdf()
    {
        $this->getReportData();
        session()->put('reportData', [
            'extraServicesReport'  => $this->extraServicesReport,
            'currencyTotals'  => $this->currencyTotals,
        ]);
        session()->put('view', 'admin.pages.reports.print.extra-services-report');
        session()->put('title', __('Extra Services Report'));
        $pdfUrl = route(auth()->getDefaultDriver().'.print-report');
        $this->dispatch('openPdf', ['url' => $pdfUrl]);
    }

    public function exportExcel()
    {
        $this->getReportData();

        $headings = [
            __('Basic Category'),
            __('Number of Sales'),
            __('Total Sales'),
            __('Currency'),
            __('Average Revenue')
        ];

        $data = $this->extraServicesReport->map(function ($service) {
            return [
                $service->parent_service_name,
                $service->service_count,
                $service->total_sales,
                $service->currency_name,
                $service->total_income
            ];
        });

        $totalsData = $this->currencyTotals->map(function ($total, $currency) {
            return [
                __('Total with') . ' ' . $currency,
                $total['total_service_count'],
                $total['total_sales'],
                '',
                $total['average_revenue']
            ];
        });

        return Excel::download(new DynamicExport($data, $headings, __('Extra Services Report'), $totalsData), 'extra_services_report.xlsx');
    }

    public function render(): View
    {
        $this->getReportData();
        return view('admin.livewire.reports.extra-services-report');
    }
}
