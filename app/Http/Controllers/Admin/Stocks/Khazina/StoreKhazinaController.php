<?php

namespace App\Http\Controllers\Admin\Stocks\Khazina;

use App\Http\Controllers\Stocks\StocksBaseController;
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
        $branches = \App\Models\Stocks\Setting\StoreBranchSetting::all();
        return view('admin.stocks.storekhazina.create', compact('branches'));
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
        ]);

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
        ]);

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
}