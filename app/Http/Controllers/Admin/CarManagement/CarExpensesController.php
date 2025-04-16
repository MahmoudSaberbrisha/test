<?php

namespace App\Http\Controllers\Admin\CarManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\CarManagement\CarExpensesRequest;
use DataTables;

class CarExpensesController extends Controller implements HasMiddleware
{
    protected $CarExpensesRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Car Expenses', only: ['index']),
            new Middleware('permission:Create Car Expenses', only: ['store']),
            new Middleware('permission:Edit Car Expenses', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Car Expenses', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->CarExpensesRepository = App::make('CarExpensesCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $expenses = $this->CarExpensesRepository->getAll();
            return DataTables::of($expenses)
                ->addColumn('actions', 'admin.pages.car-management.car-expenses.partials.actions')
                ->addColumn('active', 'admin.pages.car-management.car-expenses.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.car-management.car-expenses.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarExpensesRequest $request): RedirectResponse
    {
        try {
            $this->CarExpensesRepository->create($request->validated());
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
    public function update(CarExpensesRequest $request, $expenses): RedirectResponse
    {
        try {
            $this->CarExpensesRepository->update($expenses, $request->validated());
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
            $this->CarExpensesRepository->delete($id);
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
            return $this->CarExpensesRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
