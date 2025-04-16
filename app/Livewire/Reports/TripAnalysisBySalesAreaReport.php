<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use App\Models\Booking;
use App\Models\BookingGroup;
use App\Models\SalesArea;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicExport;

class TripAnalysisBySalesAreaReport extends Component
{
    private $currencyRepository, $salesAreaRepository;

    public $sales_area_id = 'all';
    public $currency_id = 'all';
    public $salesAreas = [];
    public $currencies = [];
    public $tripSalesAreas = [];
    public $trips = [];
    public $currencyTotals = [];

    public function resetReportData()
    {
        $this->reset(['trips', 'currencyTotals', 'tripSalesAreas']);
    }

    public function __construct()
    {
        $this->currencyRepository = app(CurrencyRepositoryInterface::class);
        $this->salesAreaRepository = App::make('SalesAreaCrudRepository');
    }

    public function mount()
    {
        $this->currencies = $this->currencyRepository->getAll();
        $this->salesAreas = $this->salesAreaRepository->getAll();
    }

    public function getReportData()
    {
        $this->resetReportData();

        $salesAreas = SalesArea::withTranslation()->whereIn('id', BookingGroup::distinct()->pluck('sales_area_id'));

        if ($this->sales_area_id != 'all') {
            $salesAreas = $salesAreas->where('id', $this->sales_area_id);
        }

        $salesAreas = $salesAreas->get();

        $discounts = DB::table('booking_group_members')
            ->join('booking_groups', 'booking_group_members.booking_group_id', '=', 'booking_groups.id')
            ->join('bookings', 'booking_groups.booking_id', '=', 'bookings.id')
            ->where('bookings.booking_type', 'group') 
            ->select(
                'booking_groups.id as booking_group_id',
                'booking_group_members.members_count',
                'booking_groups.hour_member_price',
                DB::raw('((SUM(booking_group_members.members_count)*booking_groups.hour_member_price) - booking_groups.price) as discount_value')
            )
            ->groupBy('booking_groups.id');

        $trips = Booking::query()
            ->join('types', 'bookings.type_id', '=', 'types.id')
            ->join('type_translations', function ($join) {
                $join->on('types.id', '=', 'type_translations.type_id')
                     ->where('type_translations.locale', '=', app()->getLocale());
            })
            ->join('booking_groups', 'bookings.id', '=', 'booking_groups.booking_id')
            ->join('currencies', 'booking_groups.currency_id', '=', 'currencies.id')
            ->join('currency_translations', function ($join) {
                $join->on('currencies.id', '=', 'currency_translations.currency_id')
                     ->where('currency_translations.locale', '=', app()->getLocale());
            })
            ->leftJoinSub($discounts, 'discounts', function ($join) {
                $join->on('booking_groups.id', '=', 'discounts.booking_group_id');
            })
            ->select(
                'type_translations.name as trip_type',
                'currency_translations.name as currency_name',
                DB::raw('COUNT(bookings.id) as trip_count'),
                DB::raw('SUM(booking_groups.total) as total_sales'),
                DB::raw('SUM(booking_groups.discounted) as total_discounted'),
                DB::raw('SUM(COALESCE(discounts.discount_value, 0)) as discount_value')
            );

        if ($this->sales_area_id != 'all') {
            $trips->where('booking_groups.sales_area_id', $this->sales_area_id);
        }

        if ($this->currency_id != 'all') {
            $trips->where('booking_groups.currency_id', $this->currency_id);
        }

        foreach ($salesAreas as $area) {
            $trips->addSelect(DB::raw("
                SUM(CASE WHEN booking_groups.sales_area_id = $area->id THEN booking_groups.total ELSE 0 END) as area_{$area->id}_sales
            "));
        }

        $trips = $trips->groupBy('bookings.type_id', 'booking_groups.currency_id')->get();

        $currencyTotals = $trips->groupBy('currency_name')->map(function ($group) use ($salesAreas) {
            $data = [
                'total_sales' => $group->sum('total_sales'),
                'total_discounted' => $group->sum('total_discounted'),
                'average_discounted' => $group->sum(function ($trip) {
                    return $trip->total_sales > 0 ? ($trip->total_discounted / $trip->total_sales) : 0;
                }),
                'discount_value' => $group->sum('discount_value'),
                'average_discount_value' => $group->sum(function ($trip) {
                    return $trip->total_sales > 0 ? ($trip->discount_value / $trip->total_sales) : 0;
                }),
            ];

            foreach ($salesAreas as $area) {
                $areaSalesKey = "area_{$area->id}_sales";
                $areaPercentageKey = "area_{$area->id}_percentage";

                $totalAreaSales = $group->sum($areaSalesKey); 
                $totalSales = $data['total_sales'];

                $data[$areaPercentageKey] = $totalSales > 0 ? ($totalAreaSales / $totalSales) * 100 : 0;
            }
            
            return $data;
        });

        $trips->transform(function ($trip) use ($currencyTotals, $salesAreas) {
            $trip->sales_percentage = $currencyTotals[$trip->currency_name]['total_sales'] > 0
                ? ($trip->total_sales / $currencyTotals[$trip->currency_name]['total_sales']) * 100
                : 0;

            $trip->average_sales = $trip->trip_count > 0
                ? $trip->total_sales / $trip->trip_count
                : 0;

            $trip->average_discounted = $trip->total_sales > 0 ? $trip->total_discounted / $trip->total_sales : 0;

            $trip->discount_value = $trip->discount_value ?? 0;

            $trip->average_discount_value = $trip->total_sales > 0 ? $trip->discount_value / $trip->total_sales : 0;

            foreach ($salesAreas as $area) {
                $areaSales = "area_{$area->id}_sales";
                $trip->$areaSales = $trip->$areaSales ?? 0;
                $trip->{"area_{$area->id}_percentage"} = $currencyTotals[$trip->currency_name]['total_sales'] > 0
                    ? ($trip->$areaSales / $currencyTotals[$trip->currency_name]['total_sales']) * 100
                    : 0;
            }

            return $trip;
        });

        $this->tripSalesAreas = $salesAreas;
        $this->trips = $trips;
        $this->currencyTotals = $currencyTotals;
    }

    public function exportPdf()
    {
        $this->getReportData();
        session()->put('reportData', [
            'tripSalesAreas'   => $this->tripSalesAreas,
            'trips'          => $this->trips,
            'currencyTotals' => $this->currencyTotals,
        ]);
        session()->put('view', 'admin.pages.reports.print.trip-analysis-sales-area-report');
        session()->put('title', __('Trip Analysis By Sales Area Report'));
        session()->put('format', 'A4-L');
        $pdfUrl = route(auth()->getDefaultDriver().'.print-report');
        $this->dispatch('openPdf', ['url' => $pdfUrl]);
    }

    public function exportExcel()
    {
        $this->getReportData();

        $headings = array_merge([
                __('Booking Type'),
                __('Currency'),
                __('Number of Trips'),
                __('Total Sales'),
                __('Sales Percentage'),
                __('Average Sale'),
                __('Discount Value'),
                __('Discount Rate'),
                __('Hospitality Value'),
                __('Hospitality Percentage'),
            ],
            $this->tripSalesAreas->pluck('name')->toArray(),
        );

        $data = $this->trips->map(function ($trip) {
            return $row = [
                $trip->trip_type,
                $trip->currency_name,
                $trip->trip_count,
                $trip->total_sales,
                $trip->sales_percentage,
                $trip->average_sales,
                $trip->total_discounted,
                $trip->average_discounted,
                $trip->discount_value,
                $trip->average_discount_value
            ];
        });

        $totalsData = $this->currencyTotals->map(function ($total, $currency) {
            $row = [
                __('Total with'). ' ' . $currency,
                '',
                '',
                $total['total_sales'],
                '',
                '',
                $total['total_discounted'],
                $total['average_discounted'],
                $total['discount_value'],
                $total['average_discount_value']
            ];

            foreach ($this->tripSalesAreas as $tripArea) {
                $row[] = $total["area_{$tripArea->id}_percentage"];
            }

            return $row;
        });

        return Excel::download(new DynamicExport($data, $headings, __('Trip Analysis By Sales Area Report'), $totalsData), 'trip_analysis_by_sales_area_report.xlsx');
    }

    public function render(): View
    {
        $this->getReportData();
        return view('admin.livewire.reports.trip-analysis-by-sales-area-report');
    }
}
