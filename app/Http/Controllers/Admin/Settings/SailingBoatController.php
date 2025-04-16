<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\SailingBoat;
use App\Http\Requests\Settings\SailingBoatRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;

class SailingBoatController extends Controller implements HasMiddleware
{
    protected $dataRepository;
    protected $branchRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Sailing Boats', only: ['index']),
            new Middleware('permission:Create Sailing Boats', only: ['store']),
            new Middleware('permission:Edit Sailing Boats', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Sailing Boats', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->dataRepository = App::make('SailingBoatCrudRepository');
        $this->branchRepository = App::make('BranchCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $branches = $this->branchRepository->getActiveRecords();
        if( $request->ajax() ) {
            $types = $this->dataRepository->getAll();
            return DataTables::of($types)
                ->addColumn('actions', 'admin.pages.settings.sailing-boats.partials.actions')
                ->addColumn('active', 'admin.pages.settings.sailing-boats.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.settings.sailing-boats.index', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SailingBoatRequest $request): RedirectResponse
    {
        try {
            $this->dataRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SailingBoatRequest $request, $sailing_boat): RedirectResponse
    {
        try {
            $this->dataRepository->update($sailing_boat, $request->validated());
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $this->dataRepository->delete($id);
            toastr()->success(__('Record successfully deleted.'));
        } catch (\Exception $e) {
            // dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    public function changeActive(Request $request)
    {
        try {
            return $this->dataRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
