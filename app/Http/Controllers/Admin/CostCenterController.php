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

        // Calculate total balance per cost center from entries (sum of credit only as requested)
        $costCenterBalances = \Modules\AccountingDepartment\Models\Entry::selectRaw('cost_center, SUM(debit) as total_debit, SUM(credit) as total_credit')
            ->whereNotNull('cost_center')
            ->where('cost_center', '!=', '')
            ->groupBy('cost_center')
            ->get()
            ->mapWithKeys(function ($item) {
            $balance = ($item->total_debit ?? 0) - ($item->total_credit ?? 0);
            return [$item->cost_center => $balance];
            });

        // Fetch accounts with balances and cost center names
        $accounts = \App\Models\Account::orderBy('id', 'desc')->get()->map(function ($account) {
            $entries = \Modules\AccountingDepartment\Models\Entry::where('account_number', $account->code)
                ->whereNotNull('cost_center')
                ->where('cost_center', '!=', '')
                ->get();

            if ($entries->isEmpty()) {
                return null;
            }

            $total_debit = $entries->sum('debit') ?? 0;
            $total_credit = $entries->sum('credit') ?? 0;
            $account->balance = $total_credit - $total_debit;

            // Get the cost center name from the first entry's cost_center string
            $account->cost_center_name = $entries->first()->cost_center ?? 'غير محدد';

            return $account;
        })->filter();

        return view('admin.cost_centers.index', compact('costCenters', 'costCenterBalances', 'accounts'));
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

        return redirect()->route('admin.admin.cost-centers.index')->with('success', 'Cost Center updated successfully.');
    }

    public function destroy(CostCenter $costCenter)
    {
        $costCenter->delete();
        return redirect()->route('admin.cost-centers.index')->with('success', 'Cost Center deleted successfully.');
    }
}
