<?php

namespace Modules\AccountingDepartment\Http\Controllers;
use Modules\AccountingDepartment\Models\ChartOfAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChartOfAccountController extends Controller
{
        public function index()
    {

        $accounts = ChartOfAccount::getTree();
        dd($accounts);
        return view('accountingdepartment::accounts.index', compact('accounts'));
    }

//     public function show()
//     {
//    $accounts = ChartOfAccount::with('children')->get();
//         return view('accountingdepartment::accounts.chart', compact('accounts'));}



     public function create()
    {
        $parentAccounts = ChartOfAccount::whereNull('parent_id')->get();
        $accounts = ChartOfAccount::all();
        return view('accountingdepartment::accounts.create',compact('parentAccounts','accounts'));
    }



    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'account_name' => 'required|string|max:255',
                'account_number' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) use ($request) {
                        $exists = ChartOfAccount::where('account_number', $value)
                            ->where('parent_id', $request->parent_id)
                            ->exists();
                        if ($exists) {
                            $fail('رقم الحساب '.$value.' مسجل مسبقاً لنفس الحساب الرئيسي');
                        }
                    }
                ],
                'parent_id' => 'nullable|exists:chart_of_accounts,id'
            ], [
                'account_name.required' => 'حقل اسم الحساب مطلوب',
                'account_number.required' => 'حقل رقم الحساب مطلوب',
                'parent_id.exists' => 'الحساب الرئيسي المحدد غير صحيح'
            ]);

            ChartOfAccount::create($validated);
           return redirect()->route(Auth::getDefaultDriver() . '.accounts.index')
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
        $account->update($request->all());
        return redirect()->route(Auth::getDefaultDriver().'.accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy($id)
    {
        $account = ChartOfAccount::findOrFail($id);
        $account->delete();
        return redirect()->route(auth()->getDefaultDriver().'.accounts.index')->with('success', 'Account deleted successfully.');
    }

    public function balances()
    {
        $accounts = ChartOfAccount::with('entries')->get()->map(function($account) {
            $account->balance = $account->entries->sum('amount');
            return $account;
        });
        return view('accountingdepartment::accounts.balances', compact('accounts'));
    }

    public function statement($id)
    {
        // $account = ChartOfAccount::findOrFail($id);
        $transactions = $account->entries()
            ->orderBy('date')
            ->get();
        return view('accountingdepartment::accounts.statement', compact( 'transactions'));
    }

    public function print($id)
    {
        $account = ChartOfAccount::findOrFail($id);
        $transactions = $account->entries()
            ->orderBy('date')
            ->get();
        return view('accountingdepartment::accounts.print', compact('account', 'transactions'));
    }
}
