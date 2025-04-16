<?php

namespace App\Livewire\Reports;

use App\Models\Expense;
use App\Models\ExpensesType;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicExport;

class ExpensesReport extends Component
{
    private $currencyRepository, $branchRepository;

    public $expenseTypes = [];
    public $selectedExpenseType = 'all';
    public $expenses = [];
    public $reportDataCurrency = [];
    public $currencies = [];
    public $from_date = null;
    public $to_date = null;
    public $currency_id = 'all';
    public $branch_id = 'all';
    public $branches = [];

    public function __construct()
    {
        $this->currencyRepository = app(CurrencyRepositoryInterface::class);
        $this->branchRepository = App::make('BranchCrudRepository');
    }

    public function mount()
    {
        $this->expenseTypes = ExpensesType::withTranslation()->get();
        $this->currencies = $this->currencyRepository->getAll();
        $this->branches = $this->branchRepository->getAll();
    }

    public function filterExpenses()
    {

        if ($this->from_date && $this->to_date && $this->to_date < $this->from_date) {
            toastr()->error(__('The "To Date" must be a day after the "From Date".'));
        }

        $query = Expense::with([
                'expenses_type',
                'currency'
            ])
            ->orderBy('expense_date', 'asc');

        $reportDataCurrency = Expense::selectRaw('
                currency_id, 
                SUM(value) as total
            ')
            ->groupBy('currency_id');

        if ($this->selectedExpenseType != 'all') {
            $query->where('expenses_type_id', $this->selectedExpenseType);
            $reportDataCurrency->where('expenses_type_id', $this->selectedExpenseType);
        }

        if ($this->from_date) {
            $query->where('expense_date', '>=', $this->from_date);
            $reportDataCurrency->where('expense_date', '>=', $this->from_date);
        }

        if ($this->to_date) {
            $query->where('expense_date', '<=', $this->to_date);
            $reportDataCurrency->where('expense_date', '<=', $this->to_date);
        }

        if ($this->currency_id != 'all') {
            $query = $query->where('currency_id', $this->currency_id);
            $reportDataCurrency = $reportDataCurrency->where('currency_id', $this->currency_id);
        }

        if ($this->branch_id != 'all') {
            $query = $query->where('branch_id', $this->branch_id);
            $reportDataCurrency = $reportDataCurrency->where('branch_id', $this->branch_id);
        }

        $this->expenses = $query->get();
        $this->reportDataCurrency = $reportDataCurrency->get();
    }

    public function exportPdf()
    {
        session()->put('reportData', [
            'expenses'           => $this->expenses,
            'reportDataCurrency' => $this->reportDataCurrency,
        ]);
        session()->put('view', 'admin.pages.reports.print.expenses-report');
        session()->put('title', __('Expenses Report'));
        $pdfUrl = route(auth()->getDefaultDriver().'.print-report');
        $this->dispatch('openPdf', ['url' => $pdfUrl]);
    }

    public function exportExcel()
    {
        $this->filterExpenses();

        $headings = [
            __('Date'),
            __('Branch'),
            __('Expenses Types'),
            __('Note'),
            __('Currency'),
            __('Value')
        ];

        $data = $this->expenses->map(function ($expense) {
            return [
                $expense->expense_date,
                $expense->branch->name ?? '-',
                $expense->expenses_type->name,
                $expense->note,
                $expense->currency->name,
                $expense->value
            ];
        });

        $totalsData = $this->reportDataCurrency->map(function ($dataCurrency) {
            return [
                __('Total'). ' ' . $dataCurrency->currency->name,
                '', '', '', '',
                $dataCurrency->total
            ];
        });

        return Excel::download(new DynamicExport($data, $headings, __('Expenses Report'), $totalsData), 'expenses_report.xlsx');
    }

    public function render()
    {
        return view('admin.livewire.reports.expenses-report');
    }
}
