<?php

namespace Modules\AccountingDepartment\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\AccountingDepartment\Models\ChartOfAccount;
use Modules\AccountingDepartment\Models\Entry;

class EntryController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        $entries = Entry::with(['chartOfAccount', 'typeOfRestriction'])
                    ->paginate($perPage)
                    ->appends(request()->except('page'));
        return view('accountingdepartment::entries.index', compact('entries'));
    }

    public function create()
    {
        $accounts = ChartOfAccount::all(); // Fetch all accounts
        return view('accountingdepartment::entries.create', compact('accounts')); // Pass accounts to the view
    }

    public function store(Request $request)
    {
        foreach ($request->input('entries') as $entryData) {
            $entryData['chart_of_account_id'] = $request->input('parent_id'); // Save parent_id to chart_of_account_id
            $entry = Entry::create(array_merge($entryData, [
                'date' => $request->input('date'),
                'entry_number' => $request->input('entry_number'),
                'account_name' => $entryData['account_name'],
                'account_name2' => $entryData['account_name2'] ?? '', // Use empty string if account_name2 is not set
                'account_number2' => $entryData['account_number2'] ?? '', // Use null if account_number2 is not set
                'cost_center2' => $entryData['cost_center2'] ?? '', // Use null if cost_center2 is not set
                'reference2' => $entryData['reference2'] ?? '', // Use null if reference2 is not set
                'totel' => $request->input('totel') // Include the totem field
            ]));
            // Save the type of restriction
            if ($request->has('type_of_restriction') && !empty($request->input('type_of_restriction'))) {
                $entry->typeOfRestriction()->create([
                    'restriction_type' => $request->input('type_of_restriction'),
                ]);
            }
        }
        return redirect()->route('admin.entries.index')->with('success', 'Entry created successfully.');
    }

    public function edit($id)
    {
        $entry = Entry::findOrFail($id);
        return view('entries.edit', compact('entry'));
    }

    public function update(Request $request, $id)
    {
        $entry = Entry::findOrFail($id);
        $entry->update($request->all());
        return redirect()->route('admin.entries.index')->with('success', 'Entry updated successfully.');
    }

    public function destroy($id)
    {
        $entry = Entry::findOrFail($id);
        $entry->delete();
        return redirect()->route('admin.entries.index')->with('success', 'Entry deleted successfully.');
    }

    public function accountMovement(Request $request)
    {
        $accounts = ChartOfAccount::all();
        $entries = Entry::all();

        // التحقق من إدخال رقم الحساب والفترة الزمنية
        if ($request->has(['account_number', 'from_date', 'to_date'])) {
            $entries = Entry::where('account_number', $request->account_number)
                ->whereBetween('date', [$request->from_date, $request->to_date])
                ->get();
        }

        return view('accountingdepartment::account-movement', compact('entries','accounts'));
    }
}