<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Requests\Settings\SalesAreaRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;

class SalesAreaController extends Controller implements HasMiddleware
{
    protected $dataRepository;
    protected $branchRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Sales Areas', only: ['index']),
            new Middleware('permission:Create Sales Areas', only: ['store']),
            new Middleware('permission:Edit Sales Areas', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Sales Areas', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->dataRepository = App::make('SalesAreaCrudRepository');
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
                ->addColumn('actions', 'admin.pages.settings.sales-areas.partials.actions')
                ->addColumn('active', 'admin.pages.settings.sales-areas.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.settings.sales-areas.index', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalesAreaRequest $request): RedirectResponse
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
    public function update(SalesAreaRequest $request, $sales_area): RedirectResponse
    {
        try {
            $this->dataRepository->update($sales_area, $request->validated());
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
