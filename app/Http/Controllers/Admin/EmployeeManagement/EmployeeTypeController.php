<?php

namespace App\Http\Controllers\Admin\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\EmployeeManagement\TypeRequest;
use DataTables;

class EmployeeTypeController extends Controller implements HasMiddleware
{
    protected $employeeTypeRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Employee Types', only: ['index']),
            new Middleware('permission:Create Employee Types', only: ['store']),
            new Middleware('permission:Edit Employee Types', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Employee Types', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->employeeTypeRepository = App::make('EmployeeTypeCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $types = $this->employeeTypeRepository->getAll();
            return DataTables::of($types)
                ->addColumn('actions', 'admin.pages.employee-management.employee-types.partials.actions')
                ->addColumn('active', 'admin.pages.employee-management.employee-types.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.employee-management.employee-types.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeRequest $request): RedirectResponse
    {
        try {
            $this->employeeTypeRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            // dd($e);
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TypeRequest $request, $type): RedirectResponse
    {
        try {
            $this->employeeTypeRepository->update($type, $request->validated());
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
            $this->employeeTypeRepository->delete($id);
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
            return $this->employeeTypeRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
