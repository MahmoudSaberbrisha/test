<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use Modules\AdminRoleAuthModule\Models\Branch;
use App\Models\Booking;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicExport;

class TripAnalysisReport extends Component
{
    private $currencyRepository, $branchRepository;

    public $branch_id = 'all';
    public $currency_id = 'all';
    public $branches = [];
    public $currencies = [];
    public $tripBranches = [];
    public $trips = [];
    public $currencyTotals = [];

    public function resetReportData()
    {
        $this->reset(['trips', 'currencyTotals', 'tripBranches']);
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

        $branches = Branch::withTranslation()->whereIn('id', Booking::distinct()->pluck('branch_id'));

        if ($this->branch_id != 'all') {
            $branches = $branches->where('id', $this->branch_id);
        }

        $branches = $branches->get();

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

        if ($this->branch_id != 'all') {
            $trips->where('bookings.branch_id', $this->branch_id);
        }

        if ($this->currency_id != 'all') {
            $trips->where('booking_groups.currency_id', $this->currency_id);
        }

        foreach ($branches as $branch) {
            $trips->addSelect(DB::raw("
                SUM(CASE WHEN bookings.branch_id = $branch->id THEN booking_groups.total ELSE 0 END) as branch_{$branch->id}_sales
            "));
        }

        $trips = $trips->groupBy('bookings.type_id', 'booking_groups.currency_id')->get();

        $currencyTotals = $trips->groupBy('currency_name')->map(function ($group) use ($branches) {
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

            foreach ($branches as $branch) {
                $branchSalesKey = "branch_{$branch->id}_sales";
                $branchPercentageKey = "branch_{$branch->id}_percentage";

                $totalBranchSales = $group->sum($branchSalesKey); 
                $totalSales = $data['total_sales'];

                $data[$branchPercentageKey] = $totalSales > 0 ? ($totalBranchSales / $totalSales) * 100 : 0;
            }
            
            return $data;
        });

        $trips->transform(function ($trip) use ($currencyTotals, $branches) {
            $trip->sales_percentage = $currencyTotals[$trip->currency_name]['total_sales'] > 0
                ? ($trip->total_sales / $currencyTotals[$trip->currency_name]['total_sales']) * 100
                : 0;

            $trip->average_sales = $trip->trip_count > 0
                ? $trip->total_sales / $trip->trip_count
                : 0;

            $trip->average_discounted = $trip->total_sales > 0 ? $trip->total_discounted / $trip->total_sales : 0;

            $trip->discount_value = $trip->discount_value ?? 0;

            $trip->average_discount_value = $trip->total_sales > 0 ? $trip->discount_value / $trip->total_sales : 0;

            foreach ($branches as $branch) {
                $branchSales = "branch_{$branch->id}_sales";
                $trip->$branchSales = $trip->$branchSales ?? 0;
                $trip->{"branch_{$branch->id}_percentage"} = $currencyTotals[$trip->currency_name]['total_sales'] > 0
                    ? ($trip->$branchSales / $currencyTotals[$trip->currency_name]['total_sales']) * 100
                    : 0;
            }

            return $trip;
        });

        $this->tripBranches = $branches;
        $this->trips = $trips;
        $this->currencyTotals = $currencyTotals;
    }

    public function exportPdf()
    {
        $this->getReportData();
        session()->put('reportData', [
            'tripBranches'   => $this->tripBranches,
            'trips'          => $this->trips,
            'currencyTotals' => $this->currencyTotals,
        ]);
        session()->put('view', 'admin.pages.reports.print.trip-analysis-report');
        session()->put('title', __('Trip Analysis Report'));
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
            $this->tripBranches->pluck('name')->toArray(),
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

            foreach ($this->tripBranches as $tripBranch) {
                $row[] = $total["branch_{$tripBranch->id}_percentage"];
            }

            return $row;
        });

        return Excel::download(new DynamicExport($data, $headings, __('Trip Analysis Report'), $totalsData), 'trip_analysis_report.xlsx');
    }

    public function render(): View
    {
        $this->getReportData();
        return view('admin.livewire.reports.trip-analysis-report');
    }
}
