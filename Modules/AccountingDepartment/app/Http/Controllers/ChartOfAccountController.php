<?php

namespace Modules\AccountingDepartment\Http\Controllers;

use Modules\AccountingDepartment\Models\ChartOfAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Modules\AccountingDepartment\Models\Entry;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AccountingDepartment\Exports\AccountsExport;

class ChartOfAccountController extends Controller
{
    public function index()
    {
        $accounts = ChartOfAccount::getTree();
        return view('accountingdepartment::accounts.tree', compact('accounts'));
    }

    public function exportExcel()
    {
        return Excel::download(new AccountsExport, 'accounts.xlsx');
    }

    public function getNextChildAccountNumber($parentId)
    {
        $parent = ChartOfAccount::find($parentId);
        if (!$parent) {
            return response()->json(['error' => 'Parent account not found'], 404);
        }

        $parentAccountNumber = $parent->account_number;

        // Get all child account numbers of this parent
        $childAccountNumbers = ChartOfAccount::where('parent_id', $parentId)
            ->pluck('account_number')
            ->toArray();

        // Find the next available child account number by appending digits with '0' separator
        $nextNumber = null;
        for ($i = 1; $i <= 99; $i++) {
            $candidate = $parentAccountNumber . '0' . $i;
            if (!in_array($candidate, $childAccountNumbers)) {
                $nextNumber = $candidate;
                break;
            }
        }

        if ($nextNumber === null) {
            return response()->json(['error' => 'No available child account number'], 400);
        }

        return response()->json(['next_account_number' => $nextNumber]);
    }

    public function balances()
    {
        $accounts = ChartOfAccount::with('entries')->get()->map(function ($account) {
            $total_debit = $account->entries->sum('debit');
            $total_credit = $account->entries->sum('credit');
            $account->balance =  $total_debit - $total_credit;
            return $account;
        });
        return view('accountingdepartment::accounts.balances', compact('accounts'));
    }

    public function statement($id, Request $request)
    {


        $request->validate([
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date|after_or_equal:from_date'
        ]);

        $account = ChartOfAccount::findOrFail($id);
        $accounts = ChartOfAccount::getTree();

        $query = $account->entries()
            ->with('chartOfAccount')
            ->orderBy('date');

        if ($request->has('from_date') && $request->from_date) {
            $query->where('date', '>=', $request->from_date);
        }


        if ($request->has('to_date') && $request->to_date) {
            $query->where('date', '<=', $request->to_date);
        }



        $transactions = $query->get();

        return view('accountingdepartment::accounts.statement', compact('account', 'transactions', 'accounts'));
    }

    public function print($id)
    {
        $account = ChartOfAccount::with('entries')->find($id);
        $transactions = $account->entries()
            ->orderBy('date')
            ->get();

        // Calculate balance like in balances() method
        $total_debit = $account->entries->sum('debit');
        $total_credit = $account->entries->sum('credit');
        $account->balance = $total_debit - $total_credit;

        $accounts = ChartOfAccount::getTree();
        return view('accountingdepartment::accounts.print', compact('account', 'transactions', 'accounts'));
    }

    public function create()
    {
        $parentAccounts = ChartOfAccount::whereNull('parent_id')->get();
        $accounts = ChartOfAccount::all();
        return view('accountingdepartment::accounts.create', compact('parentAccounts', 'accounts'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'account_name' => 'required|string|max:255',
                'account_type' => 'required|string|max:255',
                'account_status' => 'nullable|string|max:255',
                'account_number' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) use ($request) {
                        $exists = ChartOfAccount::where('account_number', $value)
                            ->where('parent_id', $request->parent_id)
                            ->exists();
                        if ($exists) {
                            $fail('رقم الحساب ' . $value . ' مسجل مسبقاً لنفس الحساب الرئيسي');
                        }
                    }
                ],
                'parent_id' => 'nullable|exists:chart_of_accounts,id'
            ], [
                'account_name.required' => 'حقل اسم الحساب مطلوب',
                'account_type.required' => 'حقل نوع الحساب مطلوب',
                'account_number.required' => 'حقل رقم الحساب مطلوب',
                'parent_id.exists' => 'الحساب الرئيسي المحدد غير صحيح'
            ]);

            ChartOfAccount::create($validated);
            return redirect()->route('admin.accounts.index')
                ->with('success', 'Account created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'حدث خطأ: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $account = ChartOfAccount::findOrFail($id);
        return view('accountingdepartment::accounts.edit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $account = ChartOfAccount::findOrFail($id);

        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'account_type' => 'required|string|max:255',
            'account_status' => 'nullable|string|max:255',
            'account_number' => 'required|string',
            'parent_id' => 'nullable|exists:chart_of_accounts,id'
        ], [
            'account_name.required' => 'حقل اسم الحساب مطلوب',
            'account_type.required' => 'حقل نوع الحساب مطلوب',
            'account_number.required' => 'حقل رقم الحساب مطلوب',
            'parent_id.exists' => 'الحساب الرئيسي المحدد غير صحيح'
        ]);

        $account->update($validated);
        return redirect()->route('admin.accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy($id)
    {
        $account = ChartOfAccount::findOrFail($id);
        $account->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Account deleted successfully.');
    }
}
