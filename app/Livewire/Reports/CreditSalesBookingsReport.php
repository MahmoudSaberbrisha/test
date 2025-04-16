<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use App\Models\BookingGroup;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicExport;

class CreditSalesBookingsReport extends Component
{
    private $clientSuppliersRepository;
    public $fromDate = null;
    public $toDate = null;
    public $client_supplier_id = 'all';
    public $clientSuppliers = [];
    public $reportData = [];
    public $reportDataCurrency = [];

    public function resetReportData()
    {
        $this->reset(['reportData']);
    }

    public function __construct()
    {
        $this->clientSuppliersRepository = App::make('ClientSupplierCrudRepository');
    }

    public function mount()
    {
        $this->clientSuppliers = $this->clientSuppliersRepository->getAll();
    }

    public function getReportData()
    {
        $this->resetReportData();

        if ($this->fromDate && $this->toDate && $this->toDate < $this->fromDate) {
            toastr()->error(__('The "To Date" must be a day after the "From Date".'));
        }

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
            })
            ->where('credit_sales', 1)
            ->when($this->client_supplier_id != 'all', function ($query) {
                $query->where('client_supplier_id', $this->client_supplier_id);
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
                SUM(total) as final_total,
                COALESCE((SELECT SUM(paid) FROM booking_group_payments WHERE booking_group_payments.booking_group_id = booking_groups.id), 0) as total_paid,
                (SUM(total) - COALESCE((SELECT SUM(paid) FROM booking_group_payments WHERE booking_group_payments.booking_group_id = booking_groups.id), 0)) as total_remain
            ')
            ->whereHas('booking', function ($q) {
                $q->whereBetween('booking_date', [$this->fromDate, $this->toDate]);
            })
            ->where('credit_sales', 1)
            ->when($this->client_supplier_id != 'all', function ($query) {
                $query->where('client_supplier_id', $this->client_supplier_id);
            })
            ->groupBy('currency_id');

        $this->reportData = $reportData->get();
        $this->reportDataCurrency = $reportDataCurrency->get();
    }

    public function exportPdf()
    {
        session()->put('reportData', [
            'reportData'                   => $this->reportData,
            'reportDataCurrency'         => $this->reportDataCurrency,
        ]);
        session()->put('view', 'admin.pages.reports.print.credit-sales-bookings-report');
        session()->put('title', __('Credit Sales Bookings Report'));
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
            __('Client Supplier'),
            __('Currency'),
            __('Price Person / Hour'),
            __('Total'),
            __('Paid'),
            __('Remain')
        ];

        $data = $this->reportData->map(function ($data) {
            return [
                $data->booking->booking_date->format('Y-m-d'),
                $data->booking->branch->name,
                __(BOOKING_TYPES[$data->booking->booking_type]),
                $data->booking->type->name,
                $data->client_supplier->name ?? '-',
                $data->currency->name,
                $data->hour_member_price,
                $data->total,
                $data->paid,
                $data->remain
            ];
        });

        $totalsData = $this->reportDataCurrency->map(function ($dataCurrency) {
            return [
                __('Total'). ' ' . $dataCurrency->currency->name,
                '', '', '', '', 
                '',
                $dataCurrency->total_hour_member_price,
                $dataCurrency->final_total,
                $dataCurrency->total_paid,
                $dataCurrency->total_remain
            ];
        });

        return Excel::download(new DynamicExport($data, $headings, __('Credit Sales Bookings Report'), $totalsData), 'credit_sales_bookings_report.xlsx');
    }

    public function render(): View
    {
        return view('admin.livewire.reports.credit-sales-bookings-report');
    }
}
