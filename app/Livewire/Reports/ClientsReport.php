<?php

namespace App\Livewire\Reports;

use App\Models\Expense;
use App\Models\ExpensesType;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use App\Models\Client;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicExport;

class ClientsReport extends Component
{
    private $clientsRepository, $branchRepository;

    public $clients = [];
    public $from_date = null;
    public $to_date = null;
    public $branch_id = 'all';
    public $branches = [];

    public function __construct()
    {
        $this->branchRepository = App::make('BranchCrudRepository');
    }

    public function mount()
    {
        $this->branches = $this->branchRepository->getAll();
    }

    public function getReportData()
    {

        if ($this->from_date && $this->to_date && $this->to_date < $this->from_date) {
            toastr()->error(__('The "To Date" must be a day after the "From Date".'));
        }

        $query = Client::query();

        if ($this->from_date) {
            $query->where('created_at', '>=', Carbon::parse($this->from_date)->startOfDay());
        }

        if ($this->to_date) {
            $query->where('created_at', '<=', Carbon::parse($this->to_date)->endOfDay());
        }

        if ($this->branch_id != 'all') {
            $query = $query->whereHas('bookings', function ($q) {
                    $q->where('branch_id', $this->branch_id);
                });
        }

        $this->clients = $query->get();
    }

    public function exportPdf()
    {
        session()->put('reportData', [
            'clients'  => $this->clients,
        ]);
        session()->put('view', 'admin.pages.reports.print.clients-report');
        session()->put('title', __('Clients Report'));
        $pdfUrl = route(auth()->getDefaultDriver().'.print-report');
        $this->dispatch('openPdf', ['url' => $pdfUrl]);
    }

    public function exportExcel()
    {
        $headings = [__('Name'), __('Phone'), __('Mobile'), __('Country'), __('Area'), __('City')];

        $data = $this->clients->map(function ($client) {
            return [
                __('Name') => $client->name,
                __('Phone') => $client->phone,
                __('Mobile') => $client->mobile,
                __('Country') => $client->country,
                __('Area') => $client->area,
                __('City') => $client->city
            ];
        });

        return Excel::download(new DynamicExport($data, $headings, __('Clients Report')), 'clients_report.xlsx');
    }

    public function render()
    {
        $this->getReportData();
        return view('admin.livewire.reports.clients-report');
    }
}
