<?php

namespace App\Http\Controllers\Admin\Stocks\Purchase;

use App\Http\Controllers\Stocks\StocksBaseController;
use Illuminate\Http\Request;
use App\Models\Stocks\Purchase\StorePurchasesOthers;

class StorePurchasesOthersController extends StocksBaseController
{
    protected $routeName = 'admin.storepurchasesothers';

    /**
     * Display a listing of the purchases others records.
     */
    public function index()
    {
        $purchases = StorePurchasesOthers::all();
        return view('admin.stocks.storepurchasesothers.index', compact('purchases'));
    }

    /**
     * Get balance by box id (ajax).
     */
    public function getBalanceByBoxId($box_id)
    {
        $box = \App\Models\Stocks\Khazina\StoreKhazina::find($box_id);
        if ($box) {
            return response()->json(['balance' => $box->balance]);
        } else {
            return response()->json(['error' => 'Box not found'], 404);
        }
    }

    public function create()
    {
        // Fetch publishers for dropdown
        $publishers = \App\Models\User::all();
        $branches = \App\Models\Stocks\Setting\StoreBranchSetting::all();

        // Fetch suppliers and boxes for dropdowns
        $suppliers = \App\Models\Stocks\Other\StoreOtherSupplier::all();
        $boxes = \App\Models\Stocks\Khazina\StoreKhazina::all();

        // Fetch products for product name dropdown
        $products = \App\Models\Stocks\Items\StoreItem::all();

        // Generate next unique fatora_code
        $maxFatoraCode = \App\Models\Stocks\Purchase\StorePurchasesOthers::max('fatora_code');
        $nextFatoraCode = $maxFatoraCode ? $maxFatoraCode + 1 : 1;

        return view('admin.stocks.storepurchasesothers.create', compact('publishers', 'suppliers', 'boxes', 'branches', 'products', 'nextFatoraCode'));
    }

    /**
     * Store a newly created purchases others record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fatora_code' => 'required|integer',
            'main_branch_id_fk' => 'required|integer',
            'sub_branch_id_fk' => 'required|integer',
            'product_code' => 'required|string',
            'product_name' => 'required|string|max:255',
            'amount_buy' => 'required|numeric',
            'all_cost_buy' => 'required|numeric',
            'one_price_sell' => 'required|numeric',
            'one_price_buy' => 'required|numeric',
            'rasid_motah' => 'required|numeric',
            'date_s' => 'required|date',
            'date_ar' => 'nullable|date',
            'publisher' => 'required|integer',
            'had_back' => 'required|integer',
            'had_back_date' => 'nullable|date',
            'had_back_amount' => 'required|numeric',
            'old' => 'nullable|boolean',
            'box_id_fk' => 'required|integer',
        ]);

        $purchase = StorePurchasesOthers::create($validated);
        $purchase->save();

        // Deduct the total purchase cost from the balance of the selected box
        $box = \App\Models\Stocks\Khazina\StoreKhazina::find($validated['box_id_fk']);
        if ($box) {
            $box->balance -= $validated['all_cost_buy'];
            if ($box->balance < 0) {
                $box->balance = 0; // Prevent negative balance
            }
            $box->save();
        }

        // Add the amount_buy to the all_amount field of the StoreItem
        $item = \App\Models\Stocks\Items\StoreItem::where('sanf_code', $validated['product_code'])->first();
        if ($item) {
            $item->all_amount += $validated['amount_buy'];
            $item->save();
        }

        return redirect()->route($this->routeName . '.index')->with('success', 'Purchases others created successfully.');
    }

    /**
     * Display the specified purchases others record.
     */
    public function show($id)
    {
        $purchase = StorePurchasesOthers::findOrFail($id);
        return view('admin.stocks.storepurchasesothers.show', compact('purchase'));
    }

    /**
     * Update the specified purchases others record in storage.
     */
    public function update(Request $request, $id)
    {
        $purchase = StorePurchasesOthers::findOrFail($id);

        $validated = $request->validate([
            'fatora_code' => 'sometimes|required|integer',
            'main_branch_id_fk' => 'sometimes|required|integer',
            'sub_branch_id_fk' => 'sometimes|required|integer',
            'product_code' => 'sometimes|required|string',
            'product_name' => 'sometimes|required|string|max:255',
            'amount_buy' => 'sometimes|required|numeric',
            'all_cost_buy' => 'sometimes|required|numeric',
            'one_price_sell' => 'sometimes|required|numeric',
            'one_price_buy' => 'sometimes|required|numeric',
            'rasid_motah' => 'sometimes|required|numeric',
            'date_s' => 'sometimes|required|date',
            'date_ar' => 'sometimes|nullable|date',
            'publisher' => 'sometimes|required|integer',
            'had_back' => 'sometimes|required|integer',
            'had_back_date' => 'sometimes|nullable|date',
            'had_back_amount' => 'sometimes|required|numeric',
            'old' => 'sometimes|nullable|boolean',
        ]);

        $purchase->update($validated);
        $purchase->save();

        return redirect()->route($this->routeName . '.index')->with('success', 'Purchases others updated successfully.');
    }

    /**
     * Remove the specified purchases others record from storage.
     */
    public function destroy($id)
    {
        $purchase = StorePurchasesOthers::findOrFail($id);
        $purchase->delete();

        return redirect()->route($this->routeName . '.index')->with('success', 'Purchases others deleted successfully.');
    }

    // Add any relevant calculations or business logic methods here

    /**
     * Show the form for editing the specified purchases others record.
     */
    public function edit($id)
    {
        $purchase = StorePurchasesOthers::findOrFail($id);
        $publishers = \App\Models\User::all();
        $branches = \App\Models\Stocks\Setting\StoreBranchSetting::all();
        $suppliers = \App\Models\Stocks\Other\StoreOtherSupplier::all();
        $boxes = \App\Models\Stocks\Khazina\StoreKhazina::all();
        $products = \App\Models\Stocks\Items\StoreItem::all();

        return view('admin.stocks.storepurchasesothers.edit', compact('purchase', 'publishers', 'branches', 'suppliers', 'boxes', 'products'));
    }
}
