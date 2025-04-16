<?php

namespace App\Http\Controllers\Admin\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\EmployeeManagement\MaritalStatusRequest;
use DataTables;

class EmployeeMaritalStatusController extends Controller implements HasMiddleware
{
    protected $employeeMaritalStatusRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Employee Marital Status', only: ['index']),
            new Middleware('permission:Create Employee Marital Status', only: ['store']),
            new Middleware('permission:Edit Employee Marital Status', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Employee Marital Status', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->employeeMaritalStatusRepository = App::make('EmployeeMaritalStatusCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $maritalStatus = $this->employeeMaritalStatusRepository->getAll();
            return DataTables::of($maritalStatus)
                ->addColumn('actions', 'admin.pages.employee-management.employee-marital-status.partials.actions')
                ->addColumn('active', 'admin.pages.employee-management.employee-marital-status.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.employee-management.employee-marital-status.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaritalStatusRequest $request): RedirectResponse
    {
        try {
            $this->employeeMaritalStatusRepository->create($request->validated());
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
    public function update(MaritalStatusRequest $request, $maritalStatus): RedirectResponse
    {
        try {
            $this->employeeMaritalStatusRepository->update($maritalStatus, $request->validated());
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
            $this->employeeMaritalStatusRepository->delete($id);
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
            return $this->employeeMaritalStatusRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
