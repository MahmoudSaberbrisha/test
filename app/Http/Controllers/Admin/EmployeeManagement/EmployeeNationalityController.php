<?php

namespace App\Http\Controllers\Admin\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\EmployeeManagement\NationalityRequest;
use DataTables;

class EmployeeNationalityController extends Controller implements HasMiddleware
{
    protected $employeeNationalityRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Employee Nationalities', only: ['index']),
            new Middleware('permission:Create Employee Nationalities', only: ['store']),
            new Middleware('permission:Edit Employee Nationalities', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Employee Nationalities', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->employeeNationalityRepository = App::make('EmployeeNationalityCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $nationalities = $this->employeeNationalityRepository->getAll();
            return DataTables::of($nationalities)
                ->addColumn('actions', 'admin.pages.employee-management.employee-nationalities.partials.actions')
                ->addColumn('active', 'admin.pages.employee-management.employee-nationalities.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.employee-management.employee-nationalities.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NationalityRequest $request): RedirectResponse
    {
        try {
            $this->employeeNationalityRepository->create($request->validated());
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
    public function update(NationalityRequest $request, $nationality): RedirectResponse
    {
        try {
            $this->employeeNationalityRepository->update($nationality, $request->validated());
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
            $this->employeeNationalityRepository->delete($id);
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
            return $this->employeeNationalityRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
