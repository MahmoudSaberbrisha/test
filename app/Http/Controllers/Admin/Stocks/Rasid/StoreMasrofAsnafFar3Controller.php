<?php

namespace App\Http\Controllers\Admin\Stocks\Rasid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stocks\Rasid\StoreMasrofAsnafFar3;
use App\Models\Stocks\Setting\StoreBranchSetting;
use App\Models\Stocks\Items\StoreItem;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class StoreMasrofAsnafFar3Controller extends Controller
{
    /**
     * Display a listing of the masrof asnaf far3 records.
     */
    public function index()
    {
        $masrofasnaf = StoreMasrofAsnafFar3::all();
        return view('admin.stocks.storemasrofasnaffar3.index', compact('masrofasnaf'));
    }

    /**
     * Show the form for creating a new masrof asnaf far3 record.
     */



    public function create()
    {
        // Fetch main branches (where from_id is null or 0 or '0')
        $mainBranches = StoreBranchSetting::whereNotNull('from_id')
            ->orWhere('from_id', 0)
            ->orWhere('from_id', '0')
            ->get();

        // Fetch all sub branches
        $subBranches = StoreBranchSetting::whereNotNull('from_id')
            ->get();

        // Fetch all items
        $items = StoreItem::all();

        // Fetch all publishers (users)
        $publishers = User::all();

        // Generate next unique sarf_rkm
        $maxSarfRkm = DB::table('store_masrof_asnaf_far3')->max('sarf_rkm');
        $nextSarfRkm = $maxSarfRkm ? $maxSarfRkm + 1 : 1;

        return view('admin.stocks.storemasrofasnaffar3.create', compact('mainBranches', 'subBranches', 'items', 'publishers', 'nextSarfRkm'));
    }

    /**
     * API to get available quantity for a given item code
     */
    public function getAvailableQuantity($sanf_code)
    {
        $item = StoreItem::where('sanf_code', $sanf_code)->first();

        if ($item) {
            return response()->json(['available_amount' => $item->all_amount]);
        } else {
            return response()->json(['available_amount' => 0]);
        }
    }


    /**
     * Store a newly created masrof asnaf far3 record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'main_branch_fk' => 'required|integer',
            'sub_branch_fk' => 'required|integer',
            'sarf_rkm' => 'required|integer',
            'sarf_to' => 'required|integer',
            'sanf_code' => 'required|string',
            'available_amount' => 'required|integer',
            'sanf_amount' => 'required|integer',
            'one_price_sell' => 'required|integer',
            'date' => 'required|date',
            'date_ar' => 'nullable|string',
            'publisher' => 'required|integer',
            'publisher_name' => 'nullable|string',
        ]);

        $record = StoreMasrofAsnafFar3::create($validated);
        if ($record) {
            $record->save();
        } else {
            return redirect()->back()->with('error', 'Failed to create masrof asnaf far3.');
        }

        return redirect()->route('admin.storemasrofasnaffar3.index')->with('success', 'Masrof asnaf far3 created successfully.');
    }

    /**
     * Display the specified masrof asnaf far3 record.
     */
    public function show($id)
    {
        $record = StoreMasrofAsnafFar3::findOrFail($id);
        return view('admin.stocks.storemasrofasnaffar3.show', compact('record'));
    }

    /**
     * Update the specified masrof asnaf far3 record in storage.
     */
    public function update(Request $request, $id)
    {
        $record = StoreMasrofAsnafFar3::findOrFail($id);

        $validated = $request->validate([
            'main_branch_fk' => 'sometimes|required|integer',
            'sub_branch_fk' => 'sometimes|required|integer',
            'sarf_rkm' => 'sometimes|required|integer',
            'sarf_to' => 'sometimes|required|integer',
            'sanf_code' => 'sometimes|required|string',
            'available_amount' => 'sometimes|required|integer',
            'sanf_amount' => 'sometimes|required|integer',
            'one_price_sell' => 'sometimes|required|integer',
            'date' => 'sometimes|required|date',
            'date_ar' => 'sometimes|nullable|string',
            'publisher' => 'sometimes|required|integer',
            'publisher_name' => 'sometimes|nullable|string',
        ]);

        $record->update($validated);
        if ($record) {
            $record->save();
        } else {
            return redirect()->back()->with('error', 'Failed to update masrof asnaf far3.');
        }

        return redirect()->route('admin.storemasrofasnaffar3.index')->with('success', 'Masrof asnaf far3 updated successfully.');
    }

    /**
     * Remove the specified masrof asnaf far3 record from storage.
     */
    public function destroy($id)
    {
        $record = StoreMasrofAsnafFar3::findOrFail($id);
        $record->delete();

        return redirect()->route('admin.storemasrofasnaffar3.index')->with('success', 'Masrof asnaf far3 deleted successfully.');
    }

    // Add any relevant calculations or business logic methods here

    /**
     * Show the form for editing the specified masrof asnaf far3 record.
     */
    public function edit($id)
    {
        $record = StoreMasrofAsnafFar3::findOrFail($id);

        $mainBranches = \App\Models\Stocks\Setting\StoreBranchSetting::whereNotNull('from_id')
            ->orWhere('from_id', 0)
            ->orWhere('from_id', '0')
            ->get();

        $subBranches = \App\Models\Stocks\Setting\StoreBranchSetting::whereNotNull('from_id')->get();

        $items = \App\Models\Stocks\Items\StoreItem::all();

        $publishers = \App\Models\User::all();

        return view('admin.stocks.storemasrofasnaffar3.edit', compact('record', 'mainBranches', 'subBranches', 'items', 'publishers'));
    }
}
