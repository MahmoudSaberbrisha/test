<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Settings\ClientSupplierRequest;
use App\Models\ClientSupplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;

class ClientSupplierController extends Controller implements HasMiddleware
{
    protected $dataRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Client Suppliers', only: ['index']),
            new Middleware('permission:Create Client Suppliers', only: ['store']),
            new Middleware('permission:Edit Client Suppliers', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Client Suppliers', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->dataRepository = App::make('ClientSupplierCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $types = $this->dataRepository->getAll();
            return DataTables::of($types)
                ->addColumn('actions', 'admin.pages.settings.client-suppliers.partials.actions')
                ->addColumn('active', 'admin.pages.settings.client-suppliers.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.settings.client-suppliers.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientSupplierRequest $request): RedirectResponse
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
    public function update(ClientSupplierRequest $request, $client_supplier): RedirectResponse
    {
        try {
            $this->dataRepository->update($client_supplier, $request->validated());
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
