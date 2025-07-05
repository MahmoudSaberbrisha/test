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
            $account->balance = $total_debit-$total_credit;
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

        // For each cost center, get related entries by matching cost_center field with cost center account_number
        $costCenters->transform(function ($costCenter) {
            $entries = \Modules\AccountingDepartment\Models\Entry::where('cost_center', $costCenter->account_number)->get();

            // Group entries by account_number to get account names and balances
            $accounts = $entries->groupBy('account_number')->map(function ($group) {
                $accountName = $group->first()->account_name ?? 'غير محدد';
                $totalDebit = $group->sum('debit');
                $totalCredit = $group->sum('credit');
                $balance = $totalDebit-$totalCredit ;
                return (object)[
                    'account_number' => $group->first()->account_number,
                    'account_name' => $accountName,
                    'balance' => $balance,
                ];
            });

            // Calculate total balance for the cost center
            $totalBalance = $accounts->sum('balance');

            $costCenter->accounts = $accounts;
            $costCenter->balance = $totalBalance;

            return $costCenter;
        });

        return view('accountingdepartment::cost_centers_report', compact('costCenters'));
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
                    $account->previous_balance = $previous_debit -$previous_credit ;
                } else {
                    $account->previous_balance = $total_debit- $total_credit;
                }

                return $account;
            });

        // dd($accounts);

        return view('accountingdepartment::trial_balance', compact('accounts'));
    }
}
