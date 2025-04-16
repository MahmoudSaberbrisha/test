<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use App\Models\CarTask;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicExport;

class CarIncomeExpensesReport extends Component
{
    private $carContractRepository, $carTaskRepository, $currencyRepository, $branchRepository;
    public $contracts = [];
    public $selectedContractId = 'all';
    public $carTasks;
    public $totalIncome = 0;
    public $totalExpenses = 0;
    public $totalDifference = 0;
    public $currency_id = 'all';
    public $branch_id = 'all';
    public $branches = [];
    public $currencies = [];
    public $currencyTotals = [];

    public function __construct()
    {
        $this->carContractRepository = App::make('CarContractCrudRepository');
        $this->carTaskRepository = App::make('CarTaskCrudRepository');
        $this->currencyRepository = app(CurrencyRepositoryInterface::class);
        $this->branchRepository = App::make('BranchCrudRepository');
    }

    public function mount()
    {
        $this->contracts = $this->carContractRepository->getAll();
        $this->currencies = $this->currencyRepository->getAll();
        $this->branches = $this->branchRepository->getAll();
        $this->filterCarTasks();
    }

    public function filterCarTasks()
    {
        $query = CarTask::with([
            'car_contract.car_supplier',
            'car_contract.currency',
            'car_contract.branch'
        ])
        ->when($this->selectedContractId != 'all', function ($query) {
            $query->where('car_contract_id', $this->selectedContractId);
        })
        ->when($this->branch_id != 'all', function ($query) {
            $query->whereHas('car_contract', function($q) {
                $q->where('branch_id', $this->branch_id);
            });
        })
        ->when($this->currency_id != 'all', function ($query) {
            $query->whereHas('car_contract', function($q) {
                $q->where('currency_id', $this->currency_id);
            });
        });

        $this->carTasks = $query->get();

        $this->currencyTotals = $this->carTasks->groupBy(function($task) {
            return $task->car_contract->currency->name;
        })->map(function ($group) {
            $income = $group->sum('car_income');
            $expenses = $group->sum('total_expenses');
            
            return [
                'income' => $income,
                'expenses' => $expenses,
                'difference' => $income - $expenses
            ];
        });
    }

    public function exportPdf()
    {
        $this->filterCarTasks();

        session()->put('reportData', [
            'carTasks' => $this->carTasks,
            'totalIncome' => $this->totalIncome,
            'totalExpenses' => $this->totalExpenses,
            'totalDifference' => $this->totalDifference,
            'currencyTotals' => $this->currencyTotals,
        ]);

        session()->put('view', 'admin.pages.reports.print.car-income-expenses-report');
        session()->put('title', __('Car Income & Expenses Report'));
        session()->put('format', 'A4-L');

        $pdfUrl = route(auth()->getDefaultDriver().'.print-report');
        $this->dispatch('openPdf', ['url' => $pdfUrl]);
    }

    public function exportExcel()
    {
        $this->filterCarTasks();

        $headings = [
            __('Car Type'),
            __('Car Supplier'),
            __('Currency'),
            __('Date'),
            __('Total Income'),
            __('Total Expenses'),
            __('Difference'),
        ];

        $data = $this->carTasks->map(function ($task) {
            return [
                $task['car_contract']['car_type'],
                $task['car_contract']['car_supplier']['name'],
                $task['car_contract']['currency']['name'],
                $task['date'],
                number_format($task['car_income'], 2),
                number_format($task['total_expenses'], 2),
                number_format($task['car_income'] - $task['total_expenses'], 2),
            ];
        });

        $totalsData = $this->currencyTotals->map(function ($total, $currency) {
            return [
                __('Total with') . ' ' . $currency,
                '', '', '',
                number_format($total['income'], 2),
                number_format($total['expenses'], 2),
                number_format($total['difference'], 2),
            ];
        })->toArray();

        return Excel::download(new DynamicExport($data, $headings, __('Car Income Expenses Report'), $totalsData), 'car_income_expenses_report.xlsx');
    }

    public function render()
    {
        return view('admin.livewire.reports.car-income-expenses-report');
    }
}