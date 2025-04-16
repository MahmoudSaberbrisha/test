<?php

namespace App\Http\Controllers\Admin\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use DataTables;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\RepositoryInterface\EmployeeRepositoryInterface;
use App\Http\Requests\EmployeeManagement\EmployeeRequest;
use Illuminate\Support\Facades\App;

class EmployeesController extends Controller implements HasMiddleware
{
    protected $employeeRepository, $employeeCardIssuerRepository, $employeeIdentityTypeRepository, $employeeMaritalStatusRepository, $employeeNationalityRepository, $employeeReligionRepository, $employeeTypeRepository, $jobRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Employees', only: ['index']),
            new Middleware('permission:Create Employees', only: ['create', 'store']),
            new Middleware('permission:Edit Employees', only: ['edit', 'update']),
            new Middleware('permission:Delete Employees', only: ['destroy']),
        ];
    }

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->employeeCardIssuerRepository = App::make('EmployeeCardIssuerCrudRepository');
        $this->employeeIdentityTypeRepository = App::make('EmployeeIdentityTypeCrudRepository');
        $this->employeeMaritalStatusRepository = App::make('EmployeeMaritalStatusCrudRepository');
        $this->employeeNationalityRepository = App::make('EmployeeNationalityCrudRepository');
        $this->employeeReligionRepository = App::make('EmployeeReligionCrudRepository');
        $this->employeeTypeRepository = App::make('EmployeeTypeCrudRepository');
        $this->jobRepository = App::make('JobCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $employees = $this->employeeRepository->getAll();
            return DataTables::of($employees)
                ->addColumn('branch', function ($row) {
                    return $row->branch ? $row->branch->name : '-';
                })
                ->addColumn('job', function ($row) {
                    return $row->job ? $row->job->name : '-';
                })
                ->addColumn('actions', 'admin.pages.employee-management.employees.partials.actions')
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.pages.employee-management.employees.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $cardIssuers = $this->employeeCardIssuerRepository->getActiveRecords();
        $employeeTypes = $this->employeeTypeRepository->getActiveRecords();
        $employeeNationalities = $this->employeeNationalityRepository->getActiveRecords();
        $employeeReligions = $this->employeeReligionRepository->getActiveRecords();
        $maritalStatus = $this->employeeMaritalStatusRepository->getActiveRecords();
        $identityTypes = $this->employeeIdentityTypeRepository->getActiveRecords();
        $jobs = $this->jobRepository->getActiveRecords();

        return view('admin.pages.employee-management.employees.create',compact('cardIssuers', 'employeeTypes', 'employeeNationalities', 'employeeReligions', 'maritalStatus', 'identityTypes', 'jobs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request): RedirectResponse
    {
        try {
            $record = $this->employeeRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            dd($e);
            toastr()->error(__('Something went wrong.'));
        }
        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver() . '.employees.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver() . '.employees.index');
        }
        return redirect()->route(auth()->getDefaultDriver() . '.employees.edit', $record->id);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $employee = $this->employeeRepository->findById($id);

        $cardIssuers = $this->employeeCardIssuerRepository->getActiveRecords();
        $employeeTypes = $this->employeeTypeRepository->getActiveRecords();
        $employeeNationalities = $this->employeeNationalityRepository->getActiveRecords();
        $employeeReligions = $this->employeeReligionRepository->getActiveRecords();
        $maritalStatus = $this->employeeMaritalStatusRepository->getActiveRecords();
        $identityTypes = $this->employeeIdentityTypeRepository->getActiveRecords();
        $jobs = $this->jobRepository->getActiveRecords();

        return view('admin.pages.employee-management.employees.edit', compact('employee', 'cardIssuers', 'employeeTypes', 'employeeNationalities', 'employeeReligions', 'maritalStatus', 'identityTypes', 'jobs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, $id): RedirectResponse
    {
        try {
            $record = $this->employeeRepository->update($id, $request->validated());
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));
        }
        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver() . '.employees.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver() . '.employees.index');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id): RedirectResponse
    {
        try {
            $this->employeeRepository->delete($id);
            toastr()->success(__('Record successfully deleted.'));
        } catch (\Exception $e) {
            // dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }
}