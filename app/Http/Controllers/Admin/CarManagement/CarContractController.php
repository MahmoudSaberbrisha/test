<?php

namespace App\Http\Controllers\Admin\CarManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\CarManagement\CarContractRequest;
use DataTables;
use App\Models\CarContract;
use App\Services\PdfService;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;

class CarContractController extends Controller implements HasMiddleware
{
    protected $carContractRepository;
    protected $carSupplierRepository;
    protected $branchRepository;
    protected $currencyRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Car Contracts', only: ['index']),
            new Middleware('permission:Create Car Contracts', only: ['store']),
            new Middleware('permission:Edit Car Contracts', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Car Contracts', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->carContractRepository = App::make('CarContractCrudRepository');
        $this->carSupplierRepository = App::make('CarSupplierCrudRepository');
        $this->branchRepository = App::make('BranchCrudRepository');
        $this->currencyRepository = app(CurrencyRepositoryInterface::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $contract = $this->carContractRepository->getAll();
            return DataTables::of($contract)
                ->addColumn('actions', function ($contract) {
                    return view('admin.pages.car-management.car-contracts.partials.actions', ['id' => $contract->id])->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.pages.car-management.car-contracts.index');
    }

    public function create()
    {
        $carSuppliers = $this->carSupplierRepository->getActiveRecords();
        $branches = $this->branchRepository->getActiveRecords();
        $currencies = $this->currencyRepository->getActiveRecords();
        $defaultCurrency = $this->currencyRepository->getDefaultCurrency();
        return view('admin.pages.car-management.car-contracts.create',compact('carSuppliers', 'branches', 'currencies', 'defaultCurrency'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarContractRequest $request): RedirectResponse
    {
        try {
            $contract = $this->carContractRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        $pdfUrl = route(auth()->getDefaultDriver().'.print-car-invoice', ['id' => $contract->id]);
        session()->flash('generatePdf', $pdfUrl);
        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver().'.car-contracts.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver() . '.car-contracts.index');
        }
        return redirect()->route(auth()->getDefaultDriver().'.car-contracts.edit', $contract->id);
    }

    public function edit($id)
    {
        $contract = CarContract::findOrFail($id);
        $carSuppliers = $this->carSupplierRepository->getActiveRecords();
        $branches = $this->branchRepository->getActiveRecords();
        $currencies = $this->currencyRepository->getActiveRecords();
        return view('admin.pages.car-management.car-contracts.edit', compact('contract', 'carSuppliers', 'branches', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarContractRequest $request, $carContract): RedirectResponse
    {
        try {
            $this->carContractRepository->update($carContract, $request->validated());
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        $pdfUrl = route(auth()->getDefaultDriver().'.print-car-invoice', ['id' => $carContract]);
        session()->flash('generatePdf', $pdfUrl);
        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver().'.car-contracts.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver().'.car-contracts.index');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $this->carContractRepository->delete($id);
            toastr()->success(__('Record successfully deleted.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    public function printPdf($id)
    {
        $carContract = $this->carContractRepository->findById($id);
        $pdfService = new PdfService();
        return $pdfService->generatePdf('admin.pages.car-management.car-contracts.invoice', $carContract, __('Contract Receipt'));
    }

}
