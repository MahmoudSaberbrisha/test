<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\PaymentMethod;
use App\Http\Requests\Settings\PaymentMethodRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;

class PaymentMethodController extends Controller implements HasMiddleware
{
    protected $dataRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Payment Methods', only: ['index']),
            new Middleware('permission:Create Payment Methods', only: ['store']),
            new Middleware('permission:Edit Payment Methods', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Payment Methods', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->dataRepository = App::make('PaymentMethodCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $types = $this->dataRepository->getAll();
            return DataTables::of($types)
                ->addColumn('actions', 'admin.pages.settings.payment-methods.partials.actions')
                ->addColumn('active', 'admin.pages.settings.payment-methods.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.settings.payment-methods.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentMethodRequest $request): RedirectResponse
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
    public function update(PaymentMethodRequest $request, $payment_method): RedirectResponse
    {
        try {
            $this->dataRepository->update($payment_method, $request->validated());
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
