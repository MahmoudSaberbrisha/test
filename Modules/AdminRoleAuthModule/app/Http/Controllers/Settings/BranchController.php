<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers\Settings;

use Modules\AdminRoleAuthModule\Http\Requests\BranchRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AdminRoleAuthModule\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;

class BranchController extends Controller implements HasMiddleware
{
    protected $branchRepository;
    protected $regionRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Branches', only: ['index']),
            new Middleware('permission:Create Branches', only: ['store']),
            new Middleware('permission:Edit Branches', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Branches', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->branchRepository = App::make('BranchCrudRepository');
        $this->regionRepository = App::make('RegionCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $branches = $this->branchRepository->getAll();
            return DataTables::of($branches)
                ->editColumn('region', function($branch) {
                    if (feature('regions-branches-feature'))
                        return $branch->region->name;
                    return;
                })
                ->addColumn('actions', 'adminroleauthmodule::settings.branches.partials.actions')
                ->addColumn('active', 'adminroleauthmodule::settings.branches.partials.active')
                ->rawColumns(['actions', 'active', 'region'])
                ->make(true);
        }
        $regions = feature('regions-branches-feature')?$this->regionRepository->getAll():[];
        return view('adminroleauthmodule::settings.branches.index', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchRequest $request): RedirectResponse
    {
        try {
            $this->branchRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BranchRequest $request, $branch): RedirectResponse
    {
        try {
            $this->branchRepository->update($branch, $request->validated());
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
            $this->branchRepository->delete($id);
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
            return $this->branchRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
