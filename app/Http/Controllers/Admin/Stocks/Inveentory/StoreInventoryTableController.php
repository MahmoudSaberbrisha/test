<?php

namespace App\Http\Controllers\Admin\Stocks\Inveentory;

use App\Http\Controllers\Stocks\StocksBaseController;
use Illuminate\Http\Request;
use App\Models\Stocks\Inveentory\StoreInventoryTable;
use Modules\AdminRoleAuthModule\Models\Admin;

class StoreInventoryTableController extends StocksBaseController
{
    protected $routeName = 'admin.stocks.storeinventorytable';

    /**
     * Display a listing of the inventory records.
     */
    public function index()
    {
        $inventories = StoreInventoryTable::all();
        $items = \App\Models\Stocks\Items\StoreItem::all();
        $employees = Admin::all();
        $users = \App\Models\User::all();
        return view('admin.stocks.storeinventorytable.index', compact('inventories', 'items', 'employees', 'users'));
    }

    /**
     * Show the form for editing the specified inventory record.
     */
    public function edit($id)
    {
        $inventory = StoreInventoryTable::findOrFail($id);
        $items = \App\Models\Stocks\Items\StoreItem::select('id', 'name', 'all_amount', 'category')->get();
        $employees = Admin::all();
        $users = \App\Models\User::all();
        $branches = \App\Models\Stocks\Setting\StoreBranchSetting::all();

        // Add category_name attribute using accessor
        $items->each(function ($item) {
            $item->category_name = $item->category_name;
        });

        return view('admin.stocks.storeinventorytable.edit', compact('inventory', 'items', 'employees', 'users', 'branches'));
    }


    /**
     * Store a newly created inventory record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id_fk' => 'required|integer|exists:store_item,id',
            'storage_id_fk' => 'required|string|max:50',
            'amount' => 'required|integer',
            'num_invent' => 'required|string|max:50',
            'available_amount' => 'required|string|max:50',
            'invent_date' => 'required|string|max:50',
            'employee_id_fk' => 'nullable|integer|exists:employees,id',
            'date' => 'required|string|max:50',
            'date_s' => 'required|string|max:50',
            'date_ar' => 'required|string|max:50',
            'publisher' => 'required|string|max:50',
            'sub_branch_id_fk' => 'required|string|max:50',
            'emp_code' => 'nullable|integer',
            'user_id' => 'nullable|integer|exists:users,id',
            'deficit_amount' => 'required|integer',
            'increase_amount' => 'required|integer',
            'notes' => 'nullable|string|max:50',
        ]);

        $inventory = StoreInventoryTable::create($validated);
        $inventory->save();

        return redirect()->route($this->routeName . '.index')->with('success', 'Inventory created successfully.');
    }

    /**
     * Display the specified inventory record.
     */
    public function show($id)
    {
        $inventory = StoreInventoryTable::findOrFail($id);
        return view('storeinventorytable.show', compact('inventory'));
    }
    public function create()
    {
        $items = \App\Models\Stocks\Items\StoreItem::select('id', 'name', 'all_amount', 'category')->get();

        // Add category_name attribute using accessor
        $items->each(function ($item) {
            $item->category_name = $item->category_name;
        });
        $employees = Admin::all();
        $users = \App\Models\User::all();
        $branches = \App\Models\Stocks\Setting\StoreBranchSetting::all();

        // Get the last inventory number
        $lastInventory = StoreInventoryTable::orderBy('id', 'desc')->first();
        $lastNum = 0;
        if ($lastInventory && preg_match('/IVY(\d+)/', $lastInventory->num_invent, $matches)) {
            $lastNum = intval($matches[1]);
        }
        $nextNum = $lastNum + 1;
        $nextNumInvent = 'IVY' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        $currentDate = date('Y-m-d');
        $currentDateS = date('Y-m-d');
        $currentDateAr = date('Y-m-d');
        return view('admin.stocks.storeinventorytable.create', compact('items', 'employees', 'users', 'branches', 'nextNumInvent', 'currentDate', 'currentDateS', 'currentDateAr'));
    }

    /**
     * Update the specified inventory record in storage.
     */
    public function update(Request $request, $id)
    {
        $inventory = StoreInventoryTable::findOrFail($id);

        $validated = $request->validate([
            'item_id_fk' => 'sometimes|required|integer|exists:store_item,id',
            'storage_id_fk' => 'sometimes|required|string|max:50',
            'amount' => 'sometimes|required|integer',
            'num_invent' => 'sometimes|required|integer',
            'available_amount' => 'sometimes|required|string|max:50',
            'invent_date' => 'sometimes|required|string|max:50',
            'employee_id_fk' => 'nullable|integer|exists:employees,id',
            'date' => 'sometimes|required|string|max:50',
            'date_s' => 'sometimes|required|string|max:50',
            'date_ar' => 'sometimes|required|string|max:50',
            'publisher' => 'sometimes|required|string|max:50',
            'sub_branch_id_fk' => 'sometimes|required|string|max:50',
            'emp_code' => 'nullable|integer',
            'user_id' => 'nullable|integer|exists:users,id',
            'deficit_amount' => 'sometimes|required|integer',
            'increase_amount' => 'sometimes|required|integer',
            'notes' => 'nullable|string|max:50',
        ]);

        $inventory->update($validated);
        $inventory->save();

        return redirect()->route($this->routeName . '.index')->with('success', 'Inventory updated successfully.');
    }

    /**
     * Remove the specified inventory record from storage.
     */
    public function destroy($id)
    {
        $inventory = StoreInventoryTable::findOrFail($id);
        $inventory->delete();

        return redirect()->route($this->routeName . '.index')->with('success', 'Inventory deleted successfully.');
    }

    /**
     * Calculate the net inventory amount (increase - deficit).
     */
    public function netInventoryAmount($id)
    {
        $inventory = StoreInventoryTable::findOrFail($id);

        $netAmount = $inventory->increase_amount - $inventory->deficit_amount;

        // Redirect to index with net amount as flash data or handle differently as needed
        return redirect()->route($this->routeName . '.index')->with('net_inventory_amount', $netAmount);
    }
}
