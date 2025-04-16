<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use App\Models\CarTask;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicExport;

class CarExpensesReport extends Component
{
    private $CarExpensesRepository, $carContractRepository, $carTaskRepository, $currencyRepository, $branchRepository;
    public $contracts = [];
    public $expenseTypes = [];
    public $selectedContractId = 'all';
    public $carExpenses;
    public $totalExpenses = [];
    public $totalTaskExpenses = 0;
    public $currencyTotals = [];
    public $expenseTypeTotals = [];
    public $currency_id = 'all';
    public $branch_id = 'all';
    public $branches = [];
    public $currencies = [];

    public function __construct()
    {
        $this->carContractRepository = App::make('CarContractCrudRepository');
        $this->CarExpensesRepository = App::make('CarExpensesCrudRepository');
        $this->carTaskRepository = App::make('CarTaskCrudRepository');
        $this->currencyRepository = app(CurrencyRepositoryInterface::class);
        $this->branchRepository = App::make('BranchCrudRepository');
    }

    public function mount()
    {
        $this->contracts = $this->carContractRepository->getAll();
        $this->expenseTypes = $this->CarExpensesRepository->getAll();
        $this->currencies = $this->currencyRepository->getAll();
        $this->branches = $this->branchRepository->getAll();
        $this->filterCarExpenses();
    }

    public function filterCarExpenses()
    {
        $query = CarTask::with([
            'car_contract.car_supplier',
            'car_contract.currency',
            'carTaskExpenses.expenseType'
        ])
        ->whereHas('carTaskExpenses')
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

        $carTasks = $query->get();

        $expenseTypeDefaults = $this->CarExpensesRepository->getAll()
            ->pluck('name')
            ->mapWithKeys(fn($name) => [$name => 0])
            ->toArray();

        $this->currencyTotals = $carTasks->groupBy(function($task) {
            return $task->car_contract->currency->name;
        })->map(function ($group) use ($expenseTypeDefaults) {
            $expenses = $group->flatMap->carTaskExpenses;
            
            $expenseTypes = $expenses->groupBy(function($expense) {
                return $expense->expenseType->name;
            })->map->sum('total');

            return [
                'expense_types' => array_merge($expenseTypeDefaults, $expenseTypes->toArray()),
                'total' => $expenses->sum('total')
            ];
        });

        $this->carExpenses = $carTasks->map(function($task) use ($expenseTypeDefaults) {
            $expenseTypes = $task->carTaskExpenses->mapWithKeys(function($expense) {
                return [$expense->expenseType->name => $expense->total];
            });

            return [
                'car_contract' => $task->car_contract,
                'date' => $task->date,
                'total_expenses' => $task->total_expenses,
                'currency' => $task->car_contract->currency->name,
                'expense_types' => array_merge($expenseTypeDefaults, $expenseTypes->toArray())
            ];
        });

        $this->expenseTypes = $this->CarExpensesRepository->getAll();
        $this->totalTaskExpenses = $carTasks->sum('total_expenses');
    }

    public function exportPdf()
    {
        $this->filterCarExpenses();

        session()->put('reportData', [
            'carExpenses' => $this->carExpenses,
            'expenseTypes' => $this->expenseTypes,
            'currencyTotals' => $this->currencyTotals,
        ]);

        session()->put('view', 'admin.pages.reports.print.car-expenses-report');
        session()->put('title', __('Car Expenses Report'));
        session()->put('format', 'A4-L');

        $pdfUrl = route(auth()->getDefaultDriver().'.print-report');
        $this->dispatch('openPdf', ['url' => $pdfUrl]);
    }

    public function exportExcel()
    {
        $this->filterCarExpenses();

        $headings = array_merge(
            [
                __('Car Type'),
                __('Car Supplier'),
                __('Currency'),
                __('Date'),
            ],
            $this->expenseTypes->pluck('name')->toArray(),
            [
                __('Total')
            ]
        );

        $data = $this->carExpenses->map(function ($data) {
            $row = [
                $data['car_contract']['car_type'],
                $data['car_contract']['car_supplier']['name'],
                $data['currency'],
                $data['date'],
            ];
            foreach ($this->expenseTypes as $expenseType) {
                $row[] = number_format($data['expense_types'][$expenseType->name] ?? 0, 2);
            }
            $row[] = number_format($data['total_expenses'], 2);
            return $row;
        });

        $totalsData = $this->currencyTotals->map(function ($totals, $currency) {
            $row = [
                __('Total with') . ' ' . $currency,
                '', '', '',
            ];
            foreach ($this->expenseTypes as $expenseType) {
                $row[] = number_format($totals['expense_types'][$expenseType->name] ?? 0.00, 2);
            }
            $row[] = number_format($totals['total'], 2);
            return $row;
        })->toArray();

        return Excel::download(new DynamicExport($data, $headings, __('Car Expenses Report'), $totalsData), 'car_expenses_report.xlsx');
    }

    public function render()
    {
        return view('admin.livewire.reports.car-expenses-report');
    }
}