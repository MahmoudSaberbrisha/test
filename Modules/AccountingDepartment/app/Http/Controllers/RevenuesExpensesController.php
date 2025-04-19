<?php

namespace Modules\AccountingDepartment\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\AccountingDepartment\Models\ChartOfAccount;

class RevenuesExpensesController extends Controller
{
    public function index()
    {
        $accounts = collect();

        $parentAccount = ChartOfAccount::where('account_name', 'إيرادات ')->first();
        if ($parentAccount) {
            $children = $parentAccount->children;
            $grandchildren = $children->flatMap(function ($child) {
                return $child->children;
            });
            $revenueAccounts = $children->merge($grandchildren);

            foreach ($revenueAccounts as $account) {
                $accountEntries = $account->entries;
                $total_debit = $accountEntries->sum('debit');
                $total_credit = $accountEntries->sum('credit');
                $account->balance = $total_debit - $total_credit;
                $accounts->push($account);
            }
        }

        $parentAccount2 = ChartOfAccount::where('account_name', 'المصروفات ')->first();
        if ($parentAccount2) {
            $children = $parentAccount2->children;
            $grandchildren = $children->flatMap(function ($child) {
                return $child->children;
            });
            $expenseAccounts = $children->merge($grandchildren);

            foreach ($expenseAccounts as $account) {
                $accountEntries = $account->entries;
                $total_debit = $accountEntries->sum('debit');
                $total_credit = $accountEntries->sum('credit');
                $account->balance2 = $total_debit - $total_credit;
                $accounts->push($account);
            }
        }

        return view('accounting-department::revenues_expenses', compact('accounts'));
    }
}
