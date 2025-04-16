<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use App\Models\CarTask;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicExport;

class CarIncomeReport extends Component
{
    private $carSupplierRepository, $currencyRepository, $branchRepository;
    public $suppliers = [];
    public $selectedSupplierId = 'all';
    public $carTasks;
    public $currency_id = 'all';
    public $currencies = [];
    public $branch_id = 'all';
    public $branches = [];
    public $currencyTotals = [];

    public function __construct()
    {
        $this->carSupplierRepository = App::make('CarSupplierCrudRepository');
        $this->currencyRepository = app(CurrencyRepositoryInterface::class);
        $this->branchRepository = App::make('BranchCrudRepository');
    }

    public function mount()
    {
        $this->suppliers = $this->carSupplierRepository->getAll();
        $this->currencies = $this->currencyRepository->getAll();
        $this->branches = $this->branchRepository->getAll();
        $this->filterCarIncome();
    }

    public function filterCarIncome()
    {
        $query = CarTask::with([
            'car_contract.car_supplier',
            'car_contract.currency',
            'car_contract.branch'
        ])
        ->when($this->branch_id != 'all', function ($query) {
            $query->whereHas('car_contract', function($q) {
                $q->where('branch_id', $this->branch_id);
            });
        })
        ->when($this->selectedSupplierId != 'all', function ($query) {
            $query->whereHas('car_contract', function($q) {
                $q->where('car_supplier_id', $this->selectedSupplierId);
            });
        })
        ->when($this->currency_id != 'all', function ($query) {
            $query->where('currency_id', $this->currency_id);
        });

        $this->carTasks = $query->get();
        
        $this->currencyTotals = $this->carTasks->groupBy(function($task) {
            return $task->currency->name;
        })->map(function ($group) {
            return [
                'total_income' => $group->sum('car_income'),
                'total_paid' => $group->sum('paid'),
                'total_remain' => $group->sum('remain'),
            ];
        });

    }

    public function exportPdf()
    {
        $this->filterCarIncome();

        session()->put('reportData', [
            'carTasks' => $this->carTasks,
            'currencyTotals' => $this->currencyTotals,
        ]);

        session()->put('view', 'admin.pages.reports.print.car-income-report');
        session()->put('title', __('Car Income Report'));
        session()->put('format', 'A4-L');

        $pdfUrl = route(auth()->getDefaultDriver().'.print-report');
        $this->dispatch('openPdf', ['url' => $pdfUrl]);
    }

    public function exportExcel()
    {
        $this->filterCarIncome();

        $headings = [
            __('Car Type'),
            __('Car Supplier'),
            __('Currency'),
            __('Date'),
            __('Car Income'),
            __('Paid'),
            __('Remain'),
        ];

        $data = $this->carTasks->map(function ($task) {
            return [
                $task->car_contract->car_type,
                $task->car_contract->car_supplier->name,
                $task->currency->name,
                $task->date,
                number_format($task->car_income, 2),
                number_format($task->paid, 2),
                number_format($task->remain, 2),
            ];
        });

        $totalsData = $this->currencyTotals->map(function ($total, $currency) {
            return [
                __('Total with') . ' ' . $currency,
                '', '', '',
                number_format($total['total_income'], 2),
                number_format($total['total_paid'], 2),
                number_format($total['total_remain'], 2),
            ];
        })->toArray();

        return Excel::download(new DynamicExport($data, $headings, __('Car Income Report'), $totalsData), 'car_income_report.xlsx');
    }

    public function render()
    {
        return view('admin.livewire.reports.car-income-report');
    }
}