<?php

namespace App\Http\Controllers\Admin\ClientsManagement;

use App\Models\Client;
use App\Http\Requests\ClientsManagement\ClientRequest;
use App\Http\Requests\ExcelRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Validators\ValidationException;
use App\Imports\ClientsImport;
use DataTables;
use Excel;

class ClientController extends Controller implements HasMiddleware
{
    protected $dataRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Clients', only: ['index']),
            new Middleware('permission:Create Clients', only: ['store']),
            new Middleware('permission:Edit Clients', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Clients', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->dataRepository = App::make('ClientCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $types = $this->dataRepository->getAll();
            return DataTables::of($types)
                ->addColumn('actions', 'admin.pages.clients-management.clients.partials.actions')
                ->addColumn('active', 'admin.pages.clients-management.clients.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('admin.pages.clients-management.clients.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request): RedirectResponse
    {
        try {
            $client = $this->dataRepository->create($request->validated());
            session()->put('client_id', $client->id);
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        if ($request->save == 'close') {
            return redirect()->back();
        }
        return redirect()->route(auth()->getDefaultDriver() . '.booking-groups.create');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, $client): RedirectResponse
    {
        try {
            $this->dataRepository->update($client, $request->validated());
            session()->put('client_id', $client);
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        if ($request->save == 'close') {
            return redirect()->back();
        }
        return redirect()->route(auth()->getDefaultDriver() . '.booking-groups.create');
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

    public function importExcel(ExcelRequest $request)
    {
        try {
            $import = new ClientsImport();
            Excel::import($import, $request->file('excel_file'));

            $failures = collect($import->getFailures())->sortBy('row')->values()->toArray();

            if (!empty($failures)) {
                session()->flash('import_errors', $failures);
            } else {
                toastr()->success(__('Records successfully imported.'));
            }
        } catch (ValidationException $e) {
            session()->flash('import_errors', $e->failures());
        }
        return redirect()->back();
    }

    public function clientBooking($id)
    {
        $client = $this->dataRepository->findById($id)->where('active', 1);
        if ($client) {
            session()->put('client_id', $id);
            return redirect()->route(auth()->getDefaultDriver().'.booking-groups.create');
        } else {
            toastr()->success(__('No such client.'));
            return redirect()->route(auth()->getDefaultDriver().'.bookings.index');
        }
    }

}
