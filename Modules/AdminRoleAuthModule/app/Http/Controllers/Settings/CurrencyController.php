<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use Modules\AdminRoleAuthModule\Models\Currency;
use Modules\AdminRoleAuthModule\Http\Requests\CurrencyRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;

class CurrencyController extends Controller implements HasMiddleware
{
    protected $currencyRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Currencies', only: ['index']),
            new Middleware('permission:Create Currencies', only: ['store']),
            new Middleware('permission:Edit Currencies', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Currencies', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->currencyRepository = app(CurrencyRepositoryInterface::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $data = $this->currencyRepository->getAll();
            return DataTables::of($data)
                ->addColumn('default', function ($record) {
                    if ($record->default == 1)
                        $default = '<span class="text-success">&#10004;</span>';
                    else
                        $default = '<span class="text-danger">&#10006;</span>';
                    return $default;
                })
                ->addColumn('actions', 'adminroleauthmodule::settings.currencies.partials.actions')
                ->addColumn('active', 'adminroleauthmodule::settings.currencies.partials.active')
                ->rawColumns(['actions', 'active', 'default'])
                ->make(true);
        }
        return view('adminroleauthmodule::settings.currencies.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CurrencyRequest $request): RedirectResponse
    {
        try {
            $this->currencyRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CurrencyRequest $request, $currency): RedirectResponse
    {
        try {
            $this->currencyRepository->update($currency, $request->validated());
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
            $return = $this->currencyRepository->delete($id);
            if (!$return)
                toastr()->error(__('You cannot delete the default currency.'));
            else 
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
            return $this->currencyRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
