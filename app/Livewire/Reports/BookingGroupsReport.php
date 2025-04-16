<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use App\Models\BookingGroup;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicExport;

class BookingGroupsReport extends Component
{
    private $currencyRepository, $branchRepository;
    public $fromDate = null;
    public $toDate = null;
    public $currency_id = 'all';
    public $branch_id = 'all';
    public $booking_type = 'all';
    public $active = 'all';
    public $currencies = [];
    public $branches = [];
    public $reportData = [];
    public $reportDataCurrency = [];

    public function resetReportData()
    {
        $this->reset(['reportData']);
    }

    public function __construct()
    {
        $this->currencyRepository = app(CurrencyRepositoryInterface::class);
        $this->branchRepository = App::make('BranchCrudRepository');
    }

    public function getReportData()
    {
        $this->resetReportData();

        if ($this->fromDate && $this->toDate && $this->toDate < $this->fromDate) {
            toastr()->error(__('The "To Date" must be a day after the "From Date".'));
        }

        $this->currencies = $this->currencyRepository->getAll();
        $this->branches = $this->branchRepository->getAll();

        $reportData = BookingGroup::with([
                "booking",
                "client",
                "booking_group_members",
                "booking_group_payments",
                "booking_group_services",
                "client_supplier",
                "currency" => function ($query) {
                    $query->withTranslation(); 
                }
            ])
            ->whereHas('booking', function ($q) {
                $q->whereBetween('booking_date', [$this->fromDate, $this->toDate]);
                $q->when($this->branch_id != 'all', function ($query) {
                    $query->where('branch_id', $this->branch_id);
                });
                $q->when($this->booking_type != 'all', function ($query) {
                    $query->where('booking_type', $this->booking_type);
                });
            })
            ->orderBy('booking_id');

        $reportDataCurrency = BookingGroup::with([
                "booking",
                "currency" => function ($query) {
                    $query->withTranslation(); 
                }
            ])
            ->selectRaw('
                currency_id, 
                SUM(tax) as total_tax, 
                SUM(price) as total_price, 
                SUM(discounted) as total_discount,
                SUM(hour_member_price) as total_hour_member_price,
                SUM(total) as final_total
            ')
            ->whereHas('booking', function ($q) {
                $q->whereBetween('booking_date', [$this->fromDate, $this->toDate]);
                $q->when($this->branch_id != 'all', function ($query) {
                    $query->where('branch_id', $this->branch_id);
                });
                $q->when($this->booking_type != 'all', function ($query) {
                    $query->where('booking_type', $this->booking_type);
                });
            })
            ->groupBy('currency_id');

        if ($this->currency_id != 'all') {
            $reportData = $reportData->where('currency_id', $this->currency_id);
            $reportDataCurrency = $reportDataCurrency->where('currency_id', $this->currency_id);
        }

        if ($this->active != 'all') {
            $reportData = $reportData->where('active', $this->active);
            $reportDataCurrency = $reportDataCurrency->where('active', $this->active);
        }

        $this->reportData = $reportData->get();
        $this->reportDataCurrency = $reportDataCurrency->get();
    }

    public function exportPdf()
    {
        session()->put('reportData', [
            'reportData'  => $this->reportData,
            'reportDataCurrency'  => $this->reportDataCurrency,
        ]);
        session()->put('view', 'admin.pages.reports.print.booking-groups-report');
        session()->put('title', __('Booking Groups Report'));
        session()->put('format', 'A4-L');
        $pdfUrl = route(auth()->getDefaultDriver().'.print-report');
        $this->dispatch('openPdf', ['url' => $pdfUrl]);
    }

    public function exportExcel()
    {
        $this->getReportData();

        $headings = [
            __('Date'),
            __('Branch'),
            __('Reservation Type'),
            __('Booking Type'),
            __('Sailing Boat'),
            __('Total Hours'),
            __('Client Supplier'),
            __('Currency'),
            __('Price Person / Hour'),
            __('Price'),
            __('Discounted'),
            __('Tax 14%'),
            __('Total'),
            __('Confirmed'),
        ];

        $data = $this->reportData->map(function ($data) {
            return [
                $data->booking->booking_date->format('Y-m-d'),
                $data->booking->branch->name,
                __(BOOKING_TYPES[$data->booking->booking_type]),
                $data->booking->type->name,
                $data->booking->sailing_boat->name,
                $data->booking->total_hours,
                $data->client_supplier->name ?? '-',
                $data->currency->name,
                $data->hour_member_price,
                $data->price,
                $data->discounted,
                $data->tax,
                $data->total,
                $data->active == 1 ? '✓' : '✗',
            ];
        });

        $totalsData = $this->reportDataCurrency->map(function ($dataCurrency) {
            return [
                __('Total') .' '. $dataCurrency->currency->name,
                '', '', '', '', '', '', '',
                $dataCurrency->total_hour_member_price,
                $dataCurrency->total_price,
                $dataCurrency->total_discount,
                $dataCurrency->total_tax,
                $dataCurrency->final_total,
                '',
            ];
        })->toArray();

        return Excel::download(new DynamicExport($data, $headings, __('Booking Groups Report'), $totalsData), 'booking_groups_report.xlsx');
    }

    public function render(): View
    {
        $this->getReportData();
        return view('admin.livewire.reports.booking-groups-report');
    }
}
