<?php

namespace App\Http\Controllers\Admin\Stocks\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stocks\Setting\StoreBranchSetting;

class StoreBranchSettingController extends Controller
{
    /**
     * Display a listing of the branch settings.
     */
    public function index()
    {
        $branchsettings = StoreBranchSetting::all();
        return view('admin.stocks.storebranchsetting.index', compact('branchsettings'));
    }
    public function create()
    {
        $branches = StoreBranchSetting::all();
        return view('admin.stocks.storebranchsetting.create', compact('branches'));
    }

    /**
     * Store a newly created branch setting in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:15',
            'br_code' => 'nullable|in:A,B,C,',
            'from_id' => 'nullable|integer|exists:store_branch_settings,id',
            'lat_map' => 'nullable|string|max:15',
            'long_map' => 'nullable|string|max:15',
        ]);

        $branch = StoreBranchSetting::create($validated);
        if ($branch) {
            $branch->save();
        } else {
            return redirect()->back()->with('error', 'Failed to create branch setting.');
        }

        return redirect()->route('storebranchsetting.index')->with('success', 'Branch setting created successfully.');
    }

    /**
     * Show the form for editing the specified branch setting.
     */
    public function edit($id)
    {
        $branchsetting = StoreBranchSetting::findOrFail($id);
        $branches = StoreBranchSetting::all();
        return view('admin.stocks.storebranchsetting.edit', compact('branchsetting', 'branches'));
    }

    /**
     * Display the specified branch setting.
     */
    public function show($id)
    {
        $branch = StoreBranchSetting::findOrFail($id);
        return view('admin.stocks.storebranchsetting.show', compact('branch'));
    }

    /**
     * Update the specified branch setting in storage.
     */
    public function update(Request $request, $id)
    {
        $branch = StoreBranchSetting::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:15',
            'br_code' => 'nullable|in:A,B,C,',
            'from_id' => 'nullable|integer|exists:store_branch_settings,id',
            'lat_map' => 'nullable|string|max:15',
            'long_map' => 'nullable|string|max:15',
        ]);

        $branch->update($validated);
        if ($branch) {
            $branch->save();
        } else {
            return redirect()->back()->with('error', 'Failed to update branch setting.');
        }

        return redirect()->route('storebranchsetting.index')->with('success', 'Branch setting updated successfully.');
    }

    /**
     * Remove the specified branch setting from storage.
     */
    public function destroy($id)
    {
        $branch = StoreBranchSetting::findOrFail($id);
        $branch->delete();

        return redirect()->route('storebranchsetting.index')->with('success', 'Branch setting deleted successfully.');
    }

    // Add any relevant calculations or business logic methods here
}
