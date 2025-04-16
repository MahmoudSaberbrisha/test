<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers\Settings;

use Modules\AdminRoleAuthModule\Http\Requests\RegionRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AdminRoleAuthModule\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;

class RegionController extends Controller implements HasMiddleware
{
    protected $regionRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Regions', only: ['index']),
            new Middleware('permission:Create Regions', only: ['store']),
            new Middleware('permission:Edit Regions', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Regions', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->regionRepository = App::make('RegionCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $regions = $this->regionRepository->getAll();
            return DataTables::of($regions)
                ->editColumn('count', function($region) {
                    return $region->branches->count();
                })
                ->addColumn('actions', 'adminroleauthmodule::settings.regions.partials.actions')
                ->addColumn('active', 'adminroleauthmodule::settings.regions.partials.active')
                ->rawColumns(['actions', 'active', 'count'])
                ->make(true);
        }
        return view('adminroleauthmodule::settings.regions.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegionRequest $request): RedirectResponse
    {
        try {
            $this->regionRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegionRequest $request, $region): RedirectResponse
    {
        try {
            $this->regionRepository->update($region, $request->validated());
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
            $this->regionRepository->delete($id);
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
            return $this->regionRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
