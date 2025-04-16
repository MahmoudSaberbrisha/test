<?php

namespace App\Http\Controllers\Admin\CarManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\CarManagement\CarSupplierRequest;
use DataTables;

class CarSupplierController extends Controller implements HasMiddleware
{
    protected $carSupplierRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Car Suppliers', only: ['index']),
            new Middleware('permission:Create Car Suppliers', only: ['store']),
            new Middleware('permission:Edit Car Suppliers', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Car Suppliers', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->carSupplierRepository = App::make('CarSupplierCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $carSupplier = $this->carSupplierRepository->getAll();
            return DataTables::of($carSupplier)
                ->addColumn('actions', 'admin.pages.car-management.car-suppliers.partials.actions')
                ->addColumn('active', 'admin.pages.car-management.car-suppliers.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.car-management.car-suppliers.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarSupplierRequest $request): RedirectResponse
    {
        try {
            $this->carSupplierRepository->create($request->validated());
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
    public function update(CarSupplierRequest $request, $carSupplier): RedirectResponse
    {
        try {
            $this->carSupplierRepository->update($carSupplier, $request->validated());
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
            $this->carSupplierRepository->delete($id);
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
            return $this->carSupplierRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
