<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use App\Models\CarContract;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicExport;

class CarContractDueReport extends Component
{
    private $carSupplierRepository, $currencyRepository, $branchRepository;
    public $suppliers = [];
    public $selectedSupplierId = 'all';
    public $contracts;
    public $total = 0;
    public $totalPaid = 0;
    public $totalRemain = 0;
    public $currency_id = 'all';
    public $branch_id = 'all';
    public $branches = [];
    public $currencies = [];
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
        $this->filterContracts();
    }

    public function filterContracts()
    {
        $query = CarContract::with([
            'car_supplier', 
            'branch',
            'currency' => function ($query) {
                $query->withTranslation(); 
            }
        ])
        ->when($this->selectedSupplierId != 'all', function ($query) {
            $query->where('car_supplier_id', $this->selectedSupplierId);
        })
        ->when($this->branch_id != 'all', function ($query) {
            $query->where('branch_id', $this->branch_id);
        })
        ->when($this->currency_id != 'all', function ($query) {
            $query->where('currency_id', $this->currency_id);
        });

        $this->contracts = $query->get();
        
        $this->currencyTotals = $this->contracts->groupBy(function($contract) {
            return $contract->currency->name;
        })->map(function ($group) {
            return [
                'total' => $group->sum('total'),
                'paid' => $group->sum('paid'),
                'remain' => $group->sum('remain'),
            ];
        });
    }

    public function exportPdf()
    {
        $this->filterContracts();

        session()->put('reportData', [
            'contracts' => $this->contracts,
            'currencyTotals' => $this->currencyTotals,
        ]);

        session()->put('view', 'admin.pages.reports.print.car-contract-due-report');
        session()->put('title', __('Car Contract Due Amount Report'));
        session()->put('format', 'A4-L');

        $pdfUrl = route(auth()->getDefaultDriver().'.print-report');
        $this->dispatch('openPdf', ['url' => $pdfUrl]);
    }

    public function exportExcel()
    {
        $this->filterContracts();

        $headings = [
            __('Car Supplier'),
            __('Car Type'),
            __('Currency'),
            __('Contract Start Date'),
            __('Contract End Date'),
            __('Total'),
            __('Paid'),
            __('Remain'),
        ];

        $data = $this->contracts->map(function ($contract) {
            return [
                $contract['car_supplier']['name'],
                $contract['car_type'],
                $contract['currency']['name'],
                $contract['contract_start_date'],
                $contract['contract_end_date'],
                number_format($contract['total'], 2),
                number_format($contract['paid'], 2),
                number_format($contract['remain'], 2),
            ];
        });

        $totalsData = $this->currencyTotals->map(function ($totals, $currency) {
            return [
                __('Total with') . ' ' . $currency,
                '', '', '', '',
                number_format($totals['total'], 2),
                number_format($totals['paid'], 2),
                number_format($totals['remain'], 2),
            ];
        })->toArray();

        return Excel::download(new DynamicExport($data, $headings, __('Car Contract Due Report'), $totalsData), 'car_contract_due_report.xlsx');
    }

    public function render()
    {
        return view('admin.livewire.reports.car-contract-due-report');
    }
}