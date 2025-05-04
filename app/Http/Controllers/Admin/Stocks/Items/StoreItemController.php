<?php

namespace App\Http\Controllers\Admin\Stocks\Items;

use App\Http\Controllers\Stocks\StocksBaseController;
use Illuminate\Http\Request;
use App\Models\Stocks\Items\StoreItem;
use App\Models\Stocks\Setting\StoreBranchSetting;

class StoreItemController extends StocksBaseController
{
    protected $routeName = 'admin.stocks.storeitems';

    /**
     * Display a listing of the store items.
     */
    public function index()
    {
        $items = StoreItem::all();
        return view('admin.stocks.storeitems.index', compact('items'));
    }

    /**
     * Show the form for editing the specified store item.
     */
    public function edit($id)
    {
        $item = StoreItem::findOrFail($id);
        $branches = StoreBranchSetting::all();
        return view('admin.stocks.storeitems.edit', compact('item', 'branches'));
    }

    /**
     * Store a newly created store item in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'sanf_code' => 'required|string|max:50|unique:store_item,sanf_code',
            'sanf_type' => 'nullable|string|max:50',
            'main_branch_id_fk' => 'required|integer|exists:store_branch_settings,id',
            'sub_branch_id_fk' => 'required|integer|exists:store_branch_settings,id',
            'unit' => 'required|string|max:50',
            'limit_order' => 'nullable|string|max:50',
            'min_limit' => 'nullable|string|max:50',
            'all_buy_cost' => 'nullable|numeric',
            'all_amount' => 'nullable|string|max:50',
            'one_buy_cost' => 'nullable|numeric',
            'customer_price_sale' => 'nullable|numeric',
            'first_balance_period' => 'nullable|string|max:50',
            'past_amount' => 'nullable|numeric',
            'cost_past_amount' => 'nullable|string|max:50',
            'sanf_type_gym' => 'nullable|integer',
            'category' => 'required|integer|in:1,2,3',
        ]);

        $item = StoreItem::create($validated);
        $item->save();

        return redirect()->route($this->routeName . '.index')->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified store item.
     */
    public function show($id)
    {
        $item = StoreItem::findOrFail($id);
        return view('admin.stocks.storeitems.show', compact('item'));
    }

    /**
     * Update the specified store item in storage.
     */
    public function update(Request $request, $id)
    {
        $item = StoreItem::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:50',
            'sanf_code' => 'sometimes|required|string|max:50|unique:store_item,sanf_code,' . $id,
            'sanf_type' => 'nullable|string|max:50',
            'main_branch_id_fk' => 'sometimes|required|integer',
            'sub_branch_id_fk' => 'sometimes|required|integer',
            'id_from' => 'nullable|integer',
            'unit' => 'sometimes|required|string|max:50',
            'limit_order' => 'nullable|string|max:50',
            'min_limit' => 'nullable|string|max:50',
            'all_buy_cost' => 'nullable|numeric',
            'all_amount' => 'nullable|string|max:50',
            'one_buy_cost' => 'nullable|numeric',
            'customer_price_sale' => 'nullable|numeric',
            'first_balance_period' => 'nullable|string|max:50',
            'past_amount' => 'nullable|numeric',
            'cost_past_amount' => 'nullable|string|max:50',
            'sanf_type_gym' => 'nullable|integer',
            'sale_price' => 'nullable|numeric',
            'category' => 'sometimes|required|integer|in:1,2,3',
        ]);

        $item->update($validated);
        $item->save();


        return redirect()->route($this->routeName . '.index')->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified store item from storage.
     */
    public function destroy($id)
    {
        $item = StoreItem::findOrFail($id);
        $item->delete();

        return redirect()->route($this->routeName . '.index')->with('success', 'Item deleted successfully.');
    }

    /**
     * Calculate if the item stock is below the minimum limit.
     */
    public function isBelowMinLimit($id)
    {
        $item = StoreItem::findOrFail($id);

        // Assuming all_amount and min_limit are numeric strings
        $allAmount = floatval($item->all_amount);
        $minLimit = floatval($item->min_limit);

        $belowLimit = $allAmount < $minLimit;

        return redirect()->route($this->routeName . '.index')->with('below_min_limit', $belowLimit);
    }


    public function create()
    {
        $branches = StoreBranchSetting::all();

        // Get the last sanf_code starting with 'PTY'
        $lastItem = StoreItem::where('sanf_code', 'like', 'PTY%')
            ->orderBy('sanf_code', 'desc')
            ->first();

        if ($lastItem) {
            $lastCode = $lastItem->sanf_code;
            $number = intval(substr($lastCode, 3));
            $newNumber = $number + 1;
        } else {
            $newNumber = 1;
        }

        $newSanfCode = 'PTY' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        return view($this->routeName . '.create', compact('branches', 'newSanfCode'));
    }
    /**
     * Calculate the profit margin for the item.
     */
    public function profitMargin($id)
    {
        $item = StoreItem::findOrFail($id);

        if ($item->sale_price && $item->one_buy_cost && $item->one_buy_cost > 0) {
            $margin = (($item->sale_price - $item->one_buy_cost) / $item->one_buy_cost) * 100;
        } else {
            $margin = null;
        }

        return redirect()->route($this->routeName . '.index')->with('profit_margin_percent', $margin);
    }
}
