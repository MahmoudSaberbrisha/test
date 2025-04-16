<?php

namespace App\Http\Controllers\Admin\FinancialManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinancialManagement\ExpensesRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\RepositoryInterface\ExpenseRepositoryInterface;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use DataTables;

class ExpensesController extends Controller implements HasMiddleware
{
    protected $expensesRepository, $expensesTypeRepository, $currencyRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Expenses', only: ['index']),
            new Middleware('permission:Create Expenses', only: ['store']),
            new Middleware('permission:Edit Expenses', only: ['update']),
            new Middleware('permission:Delete Expenses', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->expensesTypeRepository = App::make('ExpensesTypeCrudRepository');
        $this->expensesRepository = app(ExpenseRepositoryInterface::class);
        $this->currencyRepository = app(CurrencyRepositoryInterface::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $expenses = $this->expensesRepository->getAll();
            return DataTables::of($expenses)
                ->addColumn('actions', 'admin.pages.financial-management.expenses.partials.actions')
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.pages.financial-management.expenses.index');
    }

    public function create()
    {
        $expensesTypes = $this->expensesTypeRepository->getActiveRecords();
        $currencies = $this->currencyRepository->getActiveRecords();
        $defaultCurrency = $this->currencyRepository->getDefaultCurrency();
        return view('admin.pages.financial-management.expenses.create',compact( 'expensesTypes', 'currencies', 'defaultCurrency'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpensesRequest $request): RedirectResponse
    {
        try {
            $expense = $this->expensesRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));
        }
        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver().'.expenses.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver() . '.expenses.index');
        }
        return redirect()->route(auth()->getDefaultDriver().'.expenses.edit', $expense->id);
    }

    public function edit($id)
    {
        $expense = $this->expensesRepository->findById($id);
        $expensesTypes = $this->expensesTypeRepository->getAll();
        $currencies = $this->currencyRepository->getActiveRecords();
        return view('admin.pages.financial-management.expenses.edit', compact('expense', 'expensesTypes', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpensesRequest $request, $expense): RedirectResponse
    {
        try {
            $this->expensesRepository->update($expense, $request->validated());
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));
        }
        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver().'.expenses.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver() . '.expenses.index');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $this->expensesRepository->delete($id);
            toastr()->success(__('Record successfully deleted.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));
        }
        return redirect()->back();
    }
}
