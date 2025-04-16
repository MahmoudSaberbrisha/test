<?php

namespace App\Http\Controllers\Admin\ExtraServicesManagement;

use App\Models\ExtraService;
use App\Http\Requests\ExtraServicesManagement\ExtraServiceRequest;
use App\RepositoryInterface\ExtraServicesInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;

class ExtraServiceController extends Controller implements HasMiddleware
{
    protected $dataRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Extra Services', only: ['index']),
            new Middleware('permission:Create Extra Services', only: ['store']),
            new Middleware('permission:Edit Extra Services', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Extra Services', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->dataRepository = app(ExtraServicesInterface::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $types = $this->dataRepository->getAll();
            return DataTables::of($types)
                ->addColumn('actions', 'admin.pages.extra-services-management.extra-services.partials.actions')
                ->addColumn('active', 'admin.pages.extra-services-management.extra-services.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        $parents = $this->dataRepository->getParents();
        return view('admin.pages.extra-services-management.extra-services.index', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExtraServiceRequest $request): RedirectResponse
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
    public function update(ExtraServiceRequest $request, $extra_service): RedirectResponse
    {
        try {
            $this->dataRepository->update($extra_service, $request->validated());
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
