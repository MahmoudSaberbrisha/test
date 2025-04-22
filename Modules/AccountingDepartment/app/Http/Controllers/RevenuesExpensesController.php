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

                // Calculate previous balance before last entry
                $lastEntry = $accountEntries->sortByDesc('created_at')->first();
                if ($lastEntry) {
                    $previousEntries = $accountEntries->where('created_at', '<', $lastEntry->created_at);
                    $prev_debit = $previousEntries->sum('debit');
                    $prev_credit = $previousEntries->sum('credit');
                    $account->previous_balance = $prev_debit - $prev_credit;
                } else {
                    $account->previous_balance = 0;
                }

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

                // Calculate previous balance before last entry
                $lastEntry = $accountEntries->sortByDesc('created_at')->first();
                if ($lastEntry) {
                    $previousEntries = $accountEntries->where('created_at', '<', $lastEntry->created_at);
                    $prev_debit = $previousEntries->sum('debit');
                    $prev_credit = $previousEntries->sum('credit');
                    $account->previous_balance2 = $prev_debit - $prev_credit;
                } else {
                    $account->previous_balance2 = 0;
                }

                $accounts->push($account);
            }
        }

        return view('accounting-department::revenues_expenses', compact('accounts'));
    }
}