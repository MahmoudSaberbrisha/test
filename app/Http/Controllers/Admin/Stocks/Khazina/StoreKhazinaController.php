<?php

namespace App\Http\Controllers\Admin\Stocks\Khazina;

use App\Http\Controllers\Stocks\StocksBaseController;
use App\Models\Stocks\Setting\StoreBranchSetting;
use Illuminate\Http\Request;
use App\Models\Stocks\Khazina\StoreKhazina;

class StoreKhazinaController extends StocksBaseController
{
    protected $routeName = 'admin.storekhazina';

    /**
     * Display a listing of the khazina records.
     */
    public function index()
    {
        $khazinas = StoreKhazina::all();
        return view('admin.stocks.storekhazina.index', compact('khazinas'));
    }

    public function create()
    {
        $branches = StoreBranchSetting::all();
        $khazina = new StoreKhazina();
        return view('admin.stocks.storekhazina.create', compact('branches', 'khazina'));
    }

    /**
     * Store a newly created khazina record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'main_branch_id_fk' => 'required|integer',
            'sub_branch_id_fk' => 'required|integer',
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric|min:0',
        ]);

        // Check if khazina already exists for the given main and sub branch
        $exists = StoreKhazina::where('main_branch_id_fk', $validated['main_branch_id_fk'])
            ->where('sub_branch_id_fk', $validated['sub_branch_id_fk'])
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['error' => 'Khazina already exists for the selected branch combination.'])->withInput();
        }

        $khazina = StoreKhazina::create($validated);
        $khazina->save();

        return redirect()->route($this->routeName . '.index')->with('success', 'Khazina created successfully.');
    }

    /**
     * Display the specified khazina record.
     */
    public function show($id)
    {
        $khazina = StoreKhazina::findOrFail($id);
        return view('admin.stocks.storekhazina.show', compact('khazina'));
    }

    /**
     * Update the specified khazina record in storage.
     */
    public function update(Request $request, $id)
    {
        $khazina = StoreKhazina::findOrFail($id);

        $validated = $request->validate([
            'main_branch_id_fk' => 'sometimes|required|integer',
            'sub_branch_id_fk' => 'sometimes|required|integer',
            'name' => 'sometimes|required|string|max:255',
            'balance' => 'sometimes|required|numeric|min:0',
        ]);

        // Check if another khazina exists for the given main and sub branch
        $exists = StoreKhazina::where('main_branch_id_fk', $validated['main_branch_id_fk'] ?? $khazina->main_branch_id_fk)
            ->where('sub_branch_id_fk', $validated['sub_branch_id_fk'] ?? $khazina->sub_branch_id_fk)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['error' => 'Khazina already exists for the selected branch combination.'])->withInput();
        }

        $khazina->update($validated);
        $khazina->save();


        return redirect()->route($this->routeName . '.index')->with('success', 'Khazina updated successfully.');
    }

    /**
     * Remove the specified khazina record from storage.
     */
    public function destroy($id)
    {
        $khazina = StoreKhazina::findOrFail($id);
        $khazina->delete();

        return redirect()->route($this->routeName . '.index')->with('success', 'Khazina deleted successfully.');
    }

    // Add any relevant calculations or business logic methods here

    /**
     * Show the form for editing the specified khazina record.
     */
    public function edit($id)
    {
        $khazina = StoreKhazina::findOrFail($id);
        $branches = \App\Models\Stocks\Setting\StoreBranchSetting::all();
        return view('admin.stocks.storekhazina.edit', compact('khazina', 'branches'));
    }

    /**
     * Get boxes by sub branch id (ajax).
     */
    public function getBoxesBySubBranch($subBranchId)
    {
        $boxes = StoreKhazina::where('sub_branch_id_fk', $subBranchId)->get(['id', 'name']);
        return response()->json($boxes);
    }
}
