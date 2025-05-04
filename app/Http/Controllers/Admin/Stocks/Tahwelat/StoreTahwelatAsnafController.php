<?php

namespace App\Http\Controllers\Admin\Stocks\Tahwelat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stocks\Tahwelat\StoreTahwelatAsnaf;

class StoreTahwelatAsnafController extends Controller
{
    /**
     * Display a listing of the tahwelat asnaf records.
     */
    public function index()
    {
        $tahwelatasnaf = StoreTahwelatAsnaf::all();
        return view('admin.stocks.storetahwelatasnaf.index', compact('tahwelatasnaf'));
    }
    public function create()
    {
        return view('admin.stocks.storetahwelatasnaf.create');
    }

    /**
     * Store a newly created tahwelat asnaf record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rkm_fk' => 'required|integer',
            'sanf_id' => 'required|integer',
            'sanf_n' => 'required|string|max:255',
            'sanf_code' => 'required|integer',
            'amount_motah' => 'required|integer',
            'amount_send' => 'required|integer',
            'from_storage' => 'required|integer',
            'to_storage' => 'required|integer',
        ]);

        $asnaf = StoreTahwelatAsnaf::create($validated);
        if ($asnaf) {
            $asnaf->save();
            return redirect()->route('storetahwelatasnaf.index')->with('success', 'Tahwelat asnaf created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create tahwelat asnaf.');
        }
    }

    /**
     * Display the specified tahwelat asnaf record.
     */
    public function show($id)
    {
        $asnaf = StoreTahwelatAsnaf::findOrFail($id);
        return view('admin.stocks.storetahwelatasnaf.show', compact('asnaf'));
    }

    /**
     * Update the specified tahwelat asnaf record in storage.
     */
    public function update(Request $request, $id)
    {
        $asnaf = StoreTahwelatAsnaf::findOrFail($id);

        $validated = $request->validate([
            'rkm_fk' => 'sometimes|required|integer',
            'sanf_id' => 'sometimes|required|integer',
            'sanf_n' => 'sometimes|required|string|max:255',
            'sanf_code' => 'sometimes|required|integer',
            'amount_motah' => 'sometimes|required|integer',
            'amount_send' => 'sometimes|required|integer',
            'from_storage' => 'sometimes|required|integer',
            'to_storage' => 'sometimes|required|integer',
        ]);

        $asnaf->update($validated);
        if ($asnaf) {
            $asnaf->save();
            return redirect()->route('storetahwelatasnaf.index')->with('success', 'Tahwelat asnaf updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update tahwelat asnaf.');
        }
    }

    /**
     * Remove the specified tahwelat asnaf record from storage.
     */
    public function destroy($id)
    {
        $asnaf = StoreTahwelatAsnaf::findOrFail($id);
        $asnaf->delete();

        return redirect()->route('storetahwelatasnaf.index')->with('success', 'Tahwelat asnaf deleted successfully.');
    }

    // Add any relevant calculations or business logic methods here
}
