<?php

namespace App\Http\Controllers\Admin\FinancialManagement;

use App\Http\Requests\FinancialManagement\AccountTypeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;

class AccountTypeController extends Controller implements HasMiddleware
{
    protected $dataRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Account Types', only: ['index']),
            new Middleware('permission:Create Account Types', only: ['store']),
            new Middleware('permission:Edit Account Types', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Account Types', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->dataRepository = App::make('AccountTypeCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $types = $this->dataRepository->getAll();
            return DataTables::of($types)
                ->addColumn('actions', 'admin.pages.financial-management.account-types.partials.actions')
                ->addColumn('active', 'admin.pages.financial-management.account-types.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.financial-management.account-types.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountTypeRequest $request): RedirectResponse
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
    public function update(AccountTypeRequest $request, $account_type): RedirectResponse
    {
        try {
            $this->dataRepository->update($account_type, $request->validated());
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
