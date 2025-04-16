<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\ClientType;
use App\Http\Requests\Settings\ClientTypeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;

class ClientTypeController extends Controller implements HasMiddleware
{
    protected $dataRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Client Types', only: ['index']),
            new Middleware('permission:Create Client Types', only: ['store']),
            new Middleware('permission:Edit Client Types', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Client Types', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->dataRepository = App::make('ClientTypeCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $types = $this->dataRepository->getAll();
            return DataTables::of($types)
                ->addColumn('discount_type', function ($row) {
                    return __(DISCOUNT_TYPES[$row->discount_type]);
                })
                ->addColumn('discount_value', function ($row) {
                    return $row->discount_type=='percentage'? '%'.$row->discount_value:$row->discount_value;
                })
                ->addColumn('actions', 'admin.pages.settings.client-types.partials.actions')
                ->addColumn('active', 'admin.pages.settings.client-types.partials.active')
                ->rawColumns(['actions', 'active', 'discount_type'])
                ->make(true);
        }
        return view('admin.pages.settings.client-types.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientTypeRequest $request): RedirectResponse
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
    public function update(ClientTypeRequest $request, $client_type): RedirectResponse
    {
        try {
            $this->dataRepository->update($client_type, $request->validated());
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
