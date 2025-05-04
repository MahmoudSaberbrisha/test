<?php

namespace App\Http\Controllers\Admin\Stocks\Rasid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stocks\Rasid\StoreRasidAyni;

class StoreRasidAyniController extends Controller
{
    /**
     * Display a listing of the rasid ayni records.
     */
    public function index()
    {
        $rasidayni = StoreRasidAyni::all();
        return view('admin.stocks.storerasidayni.index', compact('rasidayni'));
    }

    public function create()
    {
        return view('admin.stocks.storerasidayni.create');
    }

    /**
     * Store a newly created rasid ayni record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'main_branch_id_fk' => 'required|integer',
            'sub_branch_id_fk' => 'required|integer',
            'date' => 'required|date',
            'date_ar' => 'nullable|string',
            'publisher_name' => 'nullable|string|max:255',
            'publisher' => 'nullable|integer',
            'sanf_code' => 'nullable|string|max:255',
            'sanf_id' => 'nullable|integer',
            'sanf_name' => 'nullable|string|max:255',
            'sanf_amount' => 'nullable|numeric',
        ]);

        $record = StoreRasidAyni::create($validated);
        if ($record) {
            $record->save();
        } else {
            return redirect()->back()->with('error', 'Failed to create rasid ayni.');
        }

        return redirect()->route('admin.storerasidayni.index')->with('success', 'Rasid ayni created successfully.');
    }

    /**
     * Display the specified rasid ayni record.
     */
    public function show($id)
    {
        $record = StoreRasidAyni::findOrFail($id);
        return view('admin.stocks.storerasidayni.show', compact('record'));
    }

    /**
     * Update the specified rasid ayni record in storage.
     */
    public function update(Request $request, $id)
    {
        $record = StoreRasidAyni::findOrFail($id);

        $validated = $request->validate([
            'main_branch_id_fk' => 'sometimes|required|integer',
            'sub_branch_id_fk' => 'sometimes|required|integer',
            'date' => 'sometimes|required|date',
            'date_ar' => 'nullable|string',
            'publisher_name' => 'nullable|string|max:255',
            'publisher' => 'nullable|integer',
            'sanf_code' => 'nullable|string|max:255',
            'sanf_id' => 'nullable|integer',
            'sanf_name' => 'nullable|string|max:255',
            'sanf_amount' => 'nullable|numeric',
        ]);

        $record->update($validated);
        if ($record) {
            $record->save();
        } else {
            return redirect()->back()->with('error', 'Failed to update rasid ayni.');
        }

        return redirect()->route('admin.storerasidayni.index')->with('success', 'Rasid ayni updated successfully.');
    }

    /**
     * Remove the specified rasid ayni record from storage.
     */
    public function destroy($id)
    {
        $record = StoreRasidAyni::findOrFail($id);
        $record->delete();

        return redirect()->route('admin.storerasidayni.index')->with('success', 'Rasid ayni deleted successfully.');
    }

    // Add any relevant calculations or business logic methods here
}