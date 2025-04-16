<?php

namespace Modules\AccountingDepartment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $accounts = \Modules\AccountingDepartment\Models\ChartOfAccount::with('entries')->get()->map(function($account) {
            $total_debit = $account->entries->sum('debit');
            $total_credit = $account->entries->sum('credit');
            $account->balance =  $total_debit - $total_credit;
            return $account;
        });
        return view('accountingdepartment::financial_balance', compact('accounts'));
    }

    /**
     * Display the cost centers report page.
     */
    public function costCentersReport()
    {
        // Assuming cost centers are accounts with a 'cost_center' attribute set to true
        $costCenters = \Modules\AccountingDepartment\Models\ChartOfAccount::where('is_cost_center', true)
            ->with('entries')
            ->get()
            ->map(function($costCenter) {
                $total_debit = $costCenter->entries->sum('debit');
                $total_credit = $costCenter->entries->sum('credit');
                $costCenter->balance = $total_debit - $total_credit;
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
        $accounts = \Modules\AccountingDepartment\Models\ChartOfAccount::with('entries')->get()->map(function($account) {
            $total_debit = $account->entries->sum('debit');
            $total_credit = $account->entries->sum('credit');
            $account->total_debit = $total_debit;
            $account->total_credit = $total_credit;
            return $account;
        });

        // dd($accounts);

        return view('accountingdepartment::trial_balance', compact('accounts'));
    }
}
