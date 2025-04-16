<?php

namespace App\Http\Controllers\Admin\FinancialManagement;

use App\Http\Requests\AccountRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AccountController extends Controller
{
    protected $dataRepository, $accountTypeRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Accounts', only: ['index']),
            new Middleware('permission:Create Accounts', only: ['store']),
            new Middleware('permission:Edit Accounts', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Accounts', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->dataRepository = App::make('AccountCrudRepository');
        $this->accountTypeRepository = App::make('AccountTypeCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $accounts = $this->dataRepository->getAll();
        $types = $this->accountTypeRepository->getActiveRecords();
        return view('admin.pages.financial-management.accounts.index', compact('accounts', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRequest $request): RedirectResponse
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
    public function update(AccountRequest $request, $account): RedirectResponse
    {
        try {
            $this->dataRepository->update($account, $request->validated());
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
