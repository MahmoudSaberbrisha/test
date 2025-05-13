<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CostCenter;
use App\Models\CostCenterBranch;

class CostCenterController extends Controller
{
    public function index()
    {
        $costCenters = CostCenter::with('branches')->get();
        return view('admin.cost_centers.index', compact('costCenters'));
    }

    public function create()
    {
        return view('admin.cost_centers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'branches' => 'array',
            'branches.*.name' => 'required|string|max:255',
            'branches.*.description' => 'nullable|string',
        ]);

        $costCenter = CostCenter::create($request->only('name', 'description'));

        if ($request->has('branches')) {
            foreach ($request->branches as $branchData) {
                $costCenter->branches()->create($branchData);
            }
        }

        return redirect()->route('admin.admin.cost-centers.index')->with('success', 'Cost Center created successfully.');
    }

    public function edit(CostCenter $costCenter)
    {
        $costCenter->load('branches');
        return view('admin.cost_centers.edit', compact('costCenter'));
    }

    public function update(Request $request, CostCenter $costCenter)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'branches' => 'array',
            'branches.*.id' => 'nullable|exists:cost_center_branches,id',
            'branches.*.name' => 'required|string|max:255',
            'branches.*.description' => 'nullable|string',
        ]);

        $costCenter->update($request->only('name', 'description'));

        $existingBranchIds = $costCenter->branches()->pluck('id')->toArray();
        $submittedBranchIds = collect($request->branches)->pluck('id')->filter()->toArray();

        // Delete removed branches
        $branchesToDelete = array_diff($existingBranchIds, $submittedBranchIds);
        CostCenterBranch::destroy($branchesToDelete);

        // Update or create branches
        foreach ($request->branches as $branchData) {
            if (isset($branchData['id'])) {
                $branch = CostCenterBranch::find($branchData['id']);
                $branch->update($branchData);
            } else {
                $costCenter->branches()->create($branchData);
            }
        }

        return redirect()->route('admin.cost-centers.index')->with('success', 'Cost Center updated successfully.');
    }

    public function destroy(CostCenter $costCenter)
    {
        $costCenter->delete();
        return redirect()->route('admin.cost-centers.index')->with('success', 'Cost Center deleted successfully.');
    }
}
