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

        // Get distinct entry_numbers with pagination
        $distinctEntryNumbers = Entry::where('approved', true)
            ->select('entry_number')
            ->groupBy('entry_number')
            ->orderBy('entry_number', 'desc')
            ->paginate($perPage)
            ->appends(request()->except('page'));

        // Fetch the first entry for each distinct entry_number
        $entries = Entry::whereIn('entry_number', $distinctEntryNumbers->pluck('entry_number'))
            ->with(['chartOfAccount', 'typeOfRestriction'])
            ->orderBy('entry_number', 'desc')
            ->get();

        // Re-key entries by entry_number to ensure one entry per number
        $uniqueEntries = $entries->unique('entry_number')->values();

        // Manually create a LengthAwarePaginator for the entries collection
        $paginatedEntries = new \Illuminate\Pagination\LengthAwarePaginator(
            $uniqueEntries,
            $distinctEntryNumbers->total(),
            $perPage,
            $distinctEntryNumbers->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('accountingdepartment::entries.index', ['entries' => $paginatedEntries]);
    }

    public function reviewedEntries()
    {
        $perPage = request('per_page', 10);

        // Get distinct entry_numbers with pagination
        $distinctEntryNumbers = Entry::where('approved', false)
            ->select('entry_number')
            ->groupBy('entry_number')
            ->orderBy('entry_number', 'desc')
            ->paginate($perPage)
            ->appends(request()->except('page'));

        // Fetch the first entry for each distinct entry_number
        $entries = Entry::whereIn('entry_number', $distinctEntryNumbers->pluck('entry_number'))
            ->with(['chartOfAccount', 'typeOfRestriction'])
            ->orderBy('entry_number', 'desc')
            ->get();

        // Re-key entries by entry_number to ensure one entry per number
        $uniqueEntries = $entries->unique('entry_number')->values();

        // Manually create a LengthAwarePaginator for the entries collection
        $paginatedEntries = new \Illuminate\Pagination\LengthAwarePaginator(
            $uniqueEntries,
            $distinctEntryNumbers->total(),
            $perPage,
            $distinctEntryNumbers->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('accountingdepartment::entries.reviewed', ['entries' => $paginatedEntries]);
    }

    public function approveEntry($entryNumber)
    {
        $entries = Entry::where('entry_number', $entryNumber)->get();
        foreach ($entries as $entry) {
            $entry->approved = true;
            $entry->save();
        }

        return redirect()->route('admin.entries.reviewed')->with('success', 'All entries with entry number ' . $entryNumber . ' approved successfully.');
    }

    public function create()
    {
        // Fetch only sub-accounts (accounts with account_status = 'فرعي')
        $accounts = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_status', 'فرعي')->get();

        // Get the last entry number from the database
        $lastEntry = Entry::orderBy('id', 'desc')->first();
        $lastEntryNumber = $lastEntry ? $lastEntry->entry_number : null;

        // Default prefix and number
        $prefix = 'EN';
        $number = 0;

        if ($lastEntryNumber) {
            // Extract numeric part from last entry number
            $numberPart = intval(substr($lastEntryNumber, strlen($prefix)));
            $number = $numberPart;
        }

        // Increment number for next entry
        $nextNumber = $number + 1;

        // Format next entry number with leading zeros (e.g., EN001)
        $nextEntryNumber = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('accountingdepartment::entries.create', compact('accounts', 'nextEntryNumber'));
    }

    public function store(Request $request)
    {
        foreach ($request->input('entries') as $entryData) {
            // Map 'is_cost_center' input to both 'cost_center' and 'cost_center2' fields
            $costCenterValue = $entryData['is_cost_center'] ?? null;
            $entryData['cost_center'] = $costCenterValue;
            $entryData['cost_center2'] = $costCenterValue;

            $entry = Entry::create(array_merge($entryData, [
                'date' => $request->input('date'),
                'entry_number' => $request->input('entry_number'),
            ]));

            // Update the is_cost_center field in chart_of_accounts table for the selected account
            if (!empty($entryData['chart_of_account_id']) && $costCenterValue !== null) {
                \Modules\AccountingDepartment\Models\ChartOfAccount::where('id', $entryData['chart_of_account_id'])
                    ->update(['is_cost_center' => $costCenterValue]);
            }

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
        $entries = Entry::where('entry_number', $entry->entry_number)->get();
        return view('accountingdepartment::entries.edit', compact('entries'));
    }

    public function update(Request $request, $id)
    {
        $entry = Entry::findOrFail($id);
        $entry->update($request->all());
        return redirect()->route('admin.entries.index')->with('success', 'Entry updated successfully.');
    }

    public function updateMultiple(Request $request)
    {
        $entriesData = $request->input('entries', []);
        foreach ($entriesData as $entryData) {
            if (isset($entryData['id'])) {
                $entry = Entry::find($entryData['id']);
                if ($entry) {
                    $entry->update($entryData);
                }
            }
        }
        return redirect()->route('admin.entries.index')->with('success', 'Entries updated successfully.');
    }

    public function destroy($entryNumber)
    {
        $entries = Entry::where('entry_number', $entryNumber)->get();
        foreach ($entries as $entry) {
            $entry->delete();
        }
        return redirect()->route('admin.entries.index')->with('success', 'All entries with entry number ' . $entryNumber . ' deleted successfully.');
    }

    public function show($id)
    {
        abort(404);
    }

    public function accountMovement(Request $request)
    {
        $accounts = ChartOfAccount::all();

        $query = Entry::with('typeOfRestriction');

        if ($request->has(['account_number', 'from_date', 'to_date'])) {
            $query->where('account_number', $request->account_number)
                ->whereBetween('date', [$request->from_date, $request->to_date]);
        }

        $entries = $query->get();

        return view('accountingdepartment::account-movement', compact('entries', 'accounts'));
    }
}
