<?php

namespace App\Http\Controllers\Admin\Stocks\Purchase;

use App\Http\Controllers\Stocks\StocksBaseController;
use Illuminate\Http\Request;
use App\Models\Stocks\Purchase\StoreRequests;

class StoreRequestsController extends StocksBaseController
{
    protected $routeName = 'admin.requests';

    /**
     * Display a listing of the requests records.
     */
    public function index()
    {
        $requests = StoreRequests::all();
        return view('admin.stocks.Orders.index', compact('requests'));
    }

    /**
     * Get balance by box id (ajax).
     */
    public function getBalanceByBoxId($box_id)
    {
        $box = \App\Models\Stocks\Khazina\StoreKhazina::find($box_id);
        if ($box) {
            return response()->json(['balance' => $box->balance]);
        } else {
            return response()->json(['error' => 'Box not found'], 404);
        }
    }

    public function create()
    {
        // Fetch publishers for dropdown
        $publishers = \App\Models\User::all();
        $branches = \App\Models\Stocks\Setting\StoreBranchSetting::all();

        // Fetch suppliers and boxes for dropdowns
        $suppliers = \App\Models\Stocks\Other\StoreOtherSupplier::all();
        $boxes = \App\Models\Stocks\Khazina\StoreKhazina::all();

        // Fetch products for product name dropdown
        $products = \App\Models\Stocks\Items\StoreItem::all();

        // Generate next unique fatora_code
        $maxFatoraCode = StoreRequests::max('fatora_code');
        $nextFatoraCode = $maxFatoraCode ? $maxFatoraCode + 1 : 1;

        return view('admin.stocks.Orders.create', compact('publishers', 'suppliers', 'boxes', 'branches', 'products', 'nextFatoraCode'));
    }

    /**
     * Store a newly created request record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fatora_code' => 'required|integer',
            'main_branch_id_fk' => 'required|integer',
            'sub_branch_id_fk' => 'required|integer',
            'product_code' => 'required|string',
            'product_name' => 'required|string|max:255',
            'amount_buy' => 'required|numeric',
            'all_cost_buy' => 'required|numeric',
            'one_price_sell' => 'required|numeric',
            'one_price_buy' => 'required|numeric',
            'rasid_motah' => 'required|numeric',
            'date_s' => 'required|date',
            'date_ar' => 'nullable|date',
            'publisher' => 'required|integer',
            'had_back' => 'required|integer',
            'had_back_date' => 'nullable|date',
            'had_back_amount' => 'required|numeric',
            'old' => 'nullable|boolean',
            'box_id_fk' => 'required|integer',
        ]);

        $requestRecord = StoreRequests::create($validated);
        $requestRecord->save();

        return redirect()->route($this->routeName . '.index')->with('success', 'Request created successfully.');
    }

    /**
     * Display the specified request record.
     */
    public function show($id)
    {
        $requestRecord = StoreRequests::findOrFail($id);
        return view('admin.stocks.Orders.show', compact('requestRecord'));
    }

    /**
     * Update the specified request record in storage.
     */
    public function update(Request $request, $id)
    {
        $requestRecord = StoreRequests::findOrFail($id);

        $validated = $request->validate([
            'fatora_code' => 'sometimes|required|integer',
            'main_branch_id_fk' => 'sometimes|required|integer',
            'sub_branch_id_fk' => 'sometimes|required|integer',
            'product_code' => 'sometimes|required|string',
            'product_name' => 'sometimes|required|string|max:255',
            'amount_buy' => 'sometimes|required|numeric',
            'all_cost_buy' => 'sometimes|required|numeric',
            'one_price_sell' => 'sometimes|required|numeric',
            'one_price_buy' => 'sometimes|required|numeric',
            'rasid_motah' => 'sometimes|required|numeric',
            'date_s' => 'sometimes|required|date',
            'date_ar' => 'sometimes|nullable|date',
            'publisher' => 'sometimes|required|integer',
            'had_back' => 'sometimes|required|integer',
            'had_back_date' => 'sometimes|nullable|date',
            'had_back_amount' => 'sometimes|required|numeric',
            'old' => 'sometimes|nullable|boolean',
        ]);

        $requestRecord->update($validated);
        $requestRecord->save();

        return redirect()->route($this->routeName . '.index')->with('success', 'Request updated successfully.');
    }

    /**
     * Remove the specified request record from storage.
     */
    public function destroy($id)
    {
        $requestRecord = StoreRequests::findOrFail($id);
        $requestRecord->delete();

        return redirect()->route($this->routeName . '.index')->with('success', 'Request deleted successfully.');
    }

    /**
     * Show the form for editing the specified request record.
     */
    public function edit($id)
    {
        $requestRecord = StoreRequests::findOrFail($id);
        $publishers = \App\Models\User::all();
        $branches = \App\Models\Stocks\Setting\StoreBranchSetting::all();
        $suppliers = \App\Models\Stocks\Other\StoreOtherSupplier::all();
        $boxes = \App\Models\Stocks\Khazina\StoreKhazina::all();
        $products = \App\Models\Stocks\Items\StoreItem::all();

        return view('admin.stocks.Orders.edit', compact('requestRecord', 'publishers', 'branches', 'suppliers', 'boxes', 'products'));
    }

    /**
     * Approve the specified request.
     */
    public function approve($id)
    {
        $requestRecord = StoreRequests::findOrFail($id);
        $requestRecord->approved = true;
        $requestRecord->save();

        // Deduct the total cost from the balance of the selected box
        $box = \App\Models\Stocks\Khazina\StoreKhazina::find($requestRecord->box_id_fk);
        if ($box) {
            $box->balance -= $requestRecord->all_cost_buy;
            if ($box->balance < 0) {
                $box->balance = 0;
            }
            $box->save();
        }

        // Deduct the total cost from the treasury of the main branch
        $treasury = \App\Models\Stocks\Khazina\StoreKhazina::where('main_branch_id_fk', $requestRecord->main_branch_id_fk)->first();
        if ($treasury) {
            $treasury->balance -= $requestRecord->all_cost_buy;
            if ($treasury->balance < 0) {
                $treasury->balance = 0;
            }
            $treasury->save();
        }

        // Add the amount_buy to the all_amount field of the StoreItem
        $item = \App\Models\Stocks\Items\StoreItem::where('sanf_code', $requestRecord->product_code)->first();
        if ($item) {
            $item->all_amount += $requestRecord->amount_buy;
            $item->save();
        }

        return redirect()->route($this->routeName . '.index')->with('success', 'Request approved successfully.');
    }
}
