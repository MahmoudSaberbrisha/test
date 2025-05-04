<?php

namespace App\Http\Controllers\Admin\Stocks\Other;

use App\Http\Controllers\Stocks\StocksBaseController;
use Illuminate\Http\Request;
use App\Models\Stocks\Other\StoreOtherSupplier;
use App\Models\Employee;
use Modules\AdminRoleAuthModule\Models\Admin;

class StoreOtherSupplierController extends StocksBaseController
{
    protected $routeName = 'admin.storeothersupplier';

    /**
     * Display a listing of the other suppliers.
     */
    public function index()
    {
        $suppliers = StoreOtherSupplier::all();
        return view('admin.stocks.storeothersupplier.index', compact('suppliers'));
    }



    public function create()
    {
        $maxCode = StoreOtherSupplier::where('code', 'like', '1%')
            ->max('code');

        if ($maxCode) {
            $number = (int) substr($maxCode, 3);
            $nextNumber = $number + 1;
        } else {
            $nextNumber = 1;
        }

        $nextCode = '1' . str_pad($nextNumber, 3, '1', STR_PAD_LEFT);

        $employees = Admin::all();

        return view('admin.stocks.storeothersupplier.create', compact('nextCode', 'employees'));
    }

    /**
     * Get the next available code based on the given code.
     */
    public function getNextCode(Request $request)
    {
        $code = $request->query('code');

        if (!$code) {
            return response()->json(['error' => 'Code parameter is required'], 400);
        }

        // If code does not start with '0', return error or handle accordingly
        if (substr($code, 0, 1) !== '0') {
            return response()->json(['error' => 'Code must start with 0'], 400);
        }

        // Extract numeric part from code
        $numberPart = (int) substr($code, 1);

        // Loop to find next available code
        do {
            $currentCode = '1' . str_pad($numberPart, 3, '1', STR_PAD_LEFT);
            $exists = StoreOtherSupplier::where('code', $currentCode)->exists();
            if (!$exists) {
                break;
            }
            $numberPart++;
        } while (true);

        return response()->json(['nextCode' => $currentCode]);
    }

    /**
     * Store a newly created other supplier in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:store_other_suppliers,code',
            'name' => 'required|string|max:255',
            'supplier_address' => 'nullable|string|max:255',
            'supplier_phone' => 'nullable|string|max:50',
            'supplier_fax' => 'nullable|string|max:50',
            'accountant_name' => 'nullable|string|max:255',
            'accountant_telephone' => 'nullable|string|max:50',
            'supplier_dayen' => 'nullable|numeric',
        ]);

        $supplier = StoreOtherSupplier::create($validated);
        $supplier->save();


        return redirect()->route($this->routeName . '.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified other supplier.
     */
    public function show($id)
    {
        $supplier = StoreOtherSupplier::findOrFail($id);
        return view('admin.stocks.storeothersupplier.show', compact('supplier'));
    }

    /**
     * Update the specified other supplier in storage.
     */
    public function update(Request $request, $id)
    {
        $supplier = StoreOtherSupplier::findOrFail($id);

        $validated = $request->validate([
            'code' => 'sometimes|required|string|unique:store_other_suppliers,code,' . $request->route('id'),
            'name' => 'sometimes|required|string|max:255',
            'supplier_address' => 'sometimes|nullable|string|max:255',
            'supplier_phone' => 'sometimes|nullable|string|max:50',
            'supplier_fax' => 'sometimes|nullable|string|max:50',
            'accountant_name' => 'sometimes|nullable|string|max:255',
            'accountant_telephone' => 'sometimes|nullable|string|max:50',
            'supplier_dayen' => 'sometimes|nullable|numeric',
        ]);

        $supplier->update($validated);
        $supplier->save();


        return redirect()->route($this->routeName . '.index')->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified other supplier from storage.
     */
    public function destroy($id)
    {
        $supplier = StoreOtherSupplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route($this->routeName . '.index')->with('success', 'Supplier deleted successfully.');
    }

    // Add any relevant calculations or business logic methods here

    /**
     * Show the form for editing the specified other supplier.
     */
    public function edit($id)
    {
        $supplier = StoreOtherSupplier::findOrFail($id);
        $employees = \Modules\AdminRoleAuthModule\Models\Admin::all();
        return view('admin.stocks.storeothersupplier.edit', compact('supplier', 'employees'));
    }
}