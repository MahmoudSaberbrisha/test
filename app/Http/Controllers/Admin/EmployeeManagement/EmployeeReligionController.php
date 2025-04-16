<?php

namespace App\Http\Controllers\Admin\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\EmployeeManagement\ReligionRequest;
use DataTables;

class EmployeeReligionController extends Controller implements HasMiddleware
{
    protected $employeeReligionRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Employee Religions', only: ['index']),
            new Middleware('permission:Create Employee Religions', only: ['store']),
            new Middleware('permission:Edit Employee Religions', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Employee Religions', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->employeeReligionRepository = App::make('EmployeeReligionCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $religions = $this->employeeReligionRepository->getAll();
            return DataTables::of($religions)
                ->addColumn('actions', 'admin.pages.employee-management.employee-religions.partials.actions')
                ->addColumn('active', 'admin.pages.employee-management.employee-religions.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.employee-management.employee-religions.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReligionRequest $request): RedirectResponse
    {
        try {
            $this->employeeReligionRepository->create($request->validated());
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
    public function update(ReligionRequest $request, $religion): RedirectResponse
    {
        try {
            $this->employeeReligionRepository->update($religion, $request->validated());
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
            $this->employeeReligionRepository->delete($id);
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
            return $this->employeeReligionRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
