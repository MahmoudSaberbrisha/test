<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\ExpensesType;
use App\Http\Requests\Settings\ExpensesTypeRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;

class ExpensesTypeController extends Controller implements HasMiddleware
{
    protected $expensesTypeRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Expenses Types', only: ['index']),
            new Middleware('permission:Create Expenses Types', only: ['store']),
            new Middleware('permission:Edit Expenses Types', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Expenses Types', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->expensesTypeRepository = App::make('ExpensesTypeCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $expensesTypes = $this->expensesTypeRepository->getAll();
            return DataTables::of($expensesTypes)
                ->addColumn('actions', 'admin.pages.settings.expenses-types.partials.actions')
                ->addColumn('active', 'admin.pages.settings.expenses-types.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.settings.expenses-types.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpensesTypeRequest $request): RedirectResponse
    {
        try {
            $this->expensesTypeRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpensesTypeRequest $request, $expenses_type): RedirectResponse
    {
        try {
            $this->expensesTypeRepository->update($expenses_type, $request->validated());
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
            $this->expensesTypeRepository->delete($id);
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
            return $this->expensesTypeRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
