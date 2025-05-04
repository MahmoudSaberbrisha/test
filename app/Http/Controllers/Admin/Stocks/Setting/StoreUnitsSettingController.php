<?php

namespace App\Http\Controllers\Admin\Stocks\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stocks\Setting\StoreUnitsSetting;

class StoreUnitsSettingController extends Controller
{
    /**
     * Display a listing of the units settings.
     */
    public function index()
    {
        $unitssettings = StoreUnitsSetting::all();
        return view('admin.stocks.storeunitssetting.index', compact('unitssettings'));
    }
    public function create()
    {
        return view('admin.stocks.storeunitssetting.create');
    }

    /**
     * Store a newly created units setting in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $unit = StoreUnitsSetting::create($validated);
        $unit->save();

        return redirect()->route('storeunitssetting.index')->with('success', 'Units setting created successfully.');
    }

    /**
     * Display the specified units setting.
     */
    public function show($id)
    {
        $unit = StoreUnitsSetting::findOrFail($id);
        return view('admin.stocks.storeunitssetting.show', compact('unit'));
    }

    /**
     * Update the specified units setting in storage.
     */
    public function update(Request $request, $id)
    {
        $unit = StoreUnitsSetting::findOrFail($id);

        $validated = $request->validate([
            'unit_name' => 'sometimes|required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $unit->update($validated);
        // Add other fields as per model
        $unit->save();

        return redirect()->route('storeunitssetting.index')->with('success', 'Units setting updated successfully.');
    }

    /**
     * Remove the specified units setting from storage.
     */
    public function destroy($id)
    {
        $unit = StoreUnitsSetting::findOrFail($id);
        $unit->delete();

        return redirect()->route('storeunitssetting.index')->with('success', 'Units setting deleted successfully.');
    }

    // Add any relevant calculations or business logic methods here
}
