<?php

namespace App\Http\Controllers\Admin\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\EmployeeManagement\CardIssuerRequest;
use DataTables;

class EmployeeCardIssuerController extends Controller implements HasMiddleware
{
    protected $employeeCardIssuerRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Employee Card Issuers', only: ['index']),
            new Middleware('permission:Create Employee Card Issuers', only: ['store']),
            new Middleware('permission:Edit Employee Card Issuers', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Employee Card Issuers', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->employeeCardIssuerRepository = App::make('EmployeeCardIssuerCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $cardIssuer = $this->employeeCardIssuerRepository->getAll();
            return DataTables::of($cardIssuer)
                ->addColumn('actions', 'admin.pages.employee-management.employee-card-issuers.partials.actions')
                ->addColumn('active', 'admin.pages.employee-management.employee-card-issuers.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.employee-management.employee-card-issuers.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CardIssuerRequest $request): RedirectResponse
    {
        try {
            $this->employeeCardIssuerRepository->create($request->validated());
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
    public function update(CardIssuerRequest $request, $cardIssuer): RedirectResponse
    {
        try {
            $this->employeeCardIssuerRepository->update($cardIssuer, $request->validated());
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
            $this->employeeCardIssuerRepository->delete($id);
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
            return $this->employeeCardIssuerRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
