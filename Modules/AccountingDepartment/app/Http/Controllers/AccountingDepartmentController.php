<?php

namespace Modules\AccountingDepartment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountingDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('accountingdepartment::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accountingdepartment::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('accountingdepartment::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('accountingdepartment::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the financial balance page.
     */
    public function financialBalance()
    {
        // Fetch accounts with balances similar to ChartOfAccountController@balances()
        $accounts = \Modules\AccountingDepartment\Models\ChartOfAccount::with('entries')->get()->map(function ($account) {
            $total_debit = $account->entries->sum('debit');
            $total_credit = $account->entries->sum('credit');
            $account->balance = $total_credit - $total_debit;
            return $account;
        });
        return view('accountingdepartment::financial_balance', compact('accounts'));
    }

    /**
     * Display the cost centers report page.
     */
    public function costCentersReport()
    {
        $costCenters = \App\Models\CostCenter::with('branches')->get();

        // Build a map of cost center numbers to names with trimmed keys
        $costCenterNumberNameMap = $costCenters->mapWithKeys(function ($costCenter) {
            return [trim($costCenter->account_number) => $costCenter->name];
        })->toArray();

        // Calculate total balance per cost center from entries (sum of credit)
        $costCenterBalances = \Modules\AccountingDepartment\Models\Entry::selectRaw('cost_center, SUM(credit) as total_credit')
            ->whereNotNull('cost_center')
            ->where('cost_center', '!=', '')
            ->groupBy('cost_center')
            ->get()
            ->mapWithKeys(function ($item) {
                return [trim($item->cost_center) => $item->total_credit];
            });

        // Fetch accounts with balances and cost center names
        $accounts = \App\Models\Account::orderBy('id', 'desc')->get()->map(function ($account) use ($costCenterNumberNameMap) {
            $entries = \Modules\AccountingDepartment\Models\Entry::where('account_number', $account->code)
                ->whereNotNull('cost_center')
                ->where('cost_center', '!=', '')
                ->get();

            if ($entries->isEmpty()) {
                return null;
            }

            $total_debit = $entries->sum('debit') ?? 0;
            $total_credit = $entries->sum('credit') ?? 0;
            $account->balance = $total_credit - $total_debit;

            // Map the cost center number to the actual name with trimming
            $costCenterNumber = trim($entries->first()->cost_center ?? '');

            // Debug: log the cost center number and mapping
            Log::info("Cost center number: " . $costCenterNumber);
            Log::info("Mapped name: " . ($costCenterNumberNameMap[$costCenterNumber] ?? 'Not found'));

            $account->cost_center_name = $costCenterNumberNameMap[$costCenterNumber] ?? $costCenterNumber ?? 'غير محدد';

            return $account;
        })->filter();

        return view('accountingdepartment::cost_centers_report', compact('costCenters', 'costCenterBalances', 'accounts'));
    }

    /**
     * Display the revenues and expenses page.
     */
    public function revenuesExpenses()
    {
        return view('accountingdepartment::revenues_expenses');
    }

    /**
     * Display the trial balance page.
     */
    public function trialBalance()
    {
        $accounts = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_status', 'فرعي')
            ->with('entries')
            ->get()
            ->map(function ($account) {
                $total_debit = $account->entries->sum('debit');
                $total_credit = $account->entries->sum('credit');
                $account->total_debit = $total_debit;
                $account->total_credit = $total_credit;

                // Calculate previous balance before last entry
                $lastEntry = $account->entries->sortByDesc('date')->first();
                if ($lastEntry) {
                    $previous_debit = $total_debit - $lastEntry->debit;
                    $previous_credit = $total_credit - $lastEntry->credit;
                    $account->previous_balance = $previous_credit - $previous_debit;
                } else {
                    $account->previous_balance = $total_credit - $total_debit;
                }

                return $account;
            });

        // dd($accounts);

        return view('accountingdepartment::trial_balance', compact('accounts'));
    }
}
