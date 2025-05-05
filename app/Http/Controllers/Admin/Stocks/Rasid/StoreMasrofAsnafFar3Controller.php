<?php

namespace App\Http\Controllers\Admin\Stocks\Rasid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Stocks\Rasid\StoreMasrofAsnafFar3;
use App\Models\Stocks\Setting\StoreBranchSetting;
use App\Models\Stocks\Items\StoreItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Modules\AdminRoleAuthModule\Models\Admin;

class StoreMasrofAsnafFar3Controller extends Controller
{
    /**
     * API to get sub branches by main branch id
     */
    public function getSubBranchesByMainBranch($mainBranchId)
    {
        $subBranches = \App\Models\Stocks\Setting\StoreBranchSetting::where('from_id', $mainBranchId)->get();
        return response()->json([
            'mainBranchId' => $mainBranchId,
            'count' => $subBranches->count(),
            'subBranches' => $subBranches,
        ]);
    }
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
        $mainBranches = StoreBranchSetting::whereNull('from_id')
            ->orWhere('from_id', 0)
            ->orWhere('from_id', '0')
            ->get();

        // Fetch all sub branches
        $subBranches = StoreBranchSetting::whereNotNull('from_id')
            ->where('from_id', '!=', 0)
            ->where('from_id', '!=', '0')
            ->get();

        // Fetch all items
        $items = StoreItem::all();

        // Fetch all publishers (users)
        $publishers = User::all();

        // Fetch all branches for sarf_to dropdown (could be all branches)
        $allBranches = StoreBranchSetting::all();

        // Generate next unique sarf_rkm
        $maxSarfRkm = DB::table('store_masrof_asnaf_far3')->max('sarf_rkm');
        $nextSarfRkm = $maxSarfRkm ? $maxSarfRkm + 1 : 1;

        return view('admin.stocks.storemasrofasnaffar3.create', compact('mainBranches', 'subBranches', 'items', 'publishers', 'nextSarfRkm', 'allBranches'));
    }

    /**
     * API to get available quantity for a given item code
     */

    public function getAvailableQuantity(Request $request, $sanf_code)
    {
        $sub_branch_fk = $request->query('sub_branch_fk');

        $item = StoreItem::where('sanf_code', $sanf_code)->first();

        if (!$item || !$sub_branch_fk) {
            return response()->json(['all_amount' => 0]);
        }

        $availableAmount = StoreItem::where('id', $item->id)
            ->where('sub_branch_id_fk', $sub_branch_fk)
            ->sum('all_amount');

        return response()->json(['all_amount' => $availableAmount]);
    }





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

            // Find the StoreItem by sanf_code
            $storeItem = StoreItem::where('sanf_code', $validated['sanf_code'])->first();

            // Check if StoreItem with same sanf_code and sub_branch_id_fk exists
            $existingStoreItem = StoreItem::where('sanf_code', $validated['sanf_code'])
                ->where('sub_branch_id_fk', $validated['sarf_to'])
                ->first();

            if ($existingStoreItem) {
                // Add available_amount to existing all_amount
                $existingStoreItem->all_amount += $validated['available_amount'];
                $existingStoreItem->save();
            } else {
                // Create a new StoreItem record with the required data
                $newStoreItem = new StoreItem();
                $newStoreItem->name = $storeItem->name;
                $newStoreItem->sanf_code = $validated['sanf_code'];
                $newStoreItem->all_amount = $validated['available_amount'];
                $newStoreItem->sub_branch_id_fk = $validated['sarf_to'];
                $newStoreItem->main_branch_id_fk = $validated['main_branch_fk'];
                $newStoreItem->save();
            }
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

        $subBranches = \App\Models\Stocks\Setting\StoreBranchSetting::whereNotNull('from_id')
            ->orWhere('from_id', 0)
            ->orWhere('from_id', '0')
            ->get();
        $items = \App\Models\Stocks\Items\StoreItem::all();

        $publishers = Admin::all();

        return view('admin.stocks.storemasrofasnaffar3.edit', compact('record', 'mainBranches', 'subBranches', 'items', 'publishers'));
    }
}