<?php

namespace App\Http\Controllers\Admin\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\EmployeeManagement\IdentityTypeRequest;
use DataTables;

class EmployeeIdentityTypeController extends Controller implements HasMiddleware
{
    protected $employeeIdentityTypeRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Employee Identity Types', only: ['index']),
            new Middleware('permission:Create Employee Identity Types', only: ['store']),
            new Middleware('permission:Edit Employee Identity Types', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Employee Identity Types', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->employeeIdentityTypeRepository = App::make('EmployeeIdentityTypeCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $identityType = $this->employeeIdentityTypeRepository->getAll();
            return DataTables::of($identityType)
                ->addColumn('actions', 'admin.pages.employee-management.employee-identity-types.partials.actions')
                ->addColumn('active', 'admin.pages.employee-management.employee-identity-types.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.employee-management.employee-identity-types.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IdentityTypeRequest $request): RedirectResponse
    {
        try {
            $this->employeeIdentityTypeRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            dd($e);
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IdentityTypeRequest $request, $identityType): RedirectResponse
    {
        try {
            $this->employeeIdentityTypeRepository->update($identityType, $request->validated());
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            // dd($e);
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
            $this->employeeIdentityTypeRepository->delete($id);
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
            return $this->employeeIdentityTypeRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
