<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Modules\AdminRoleAuthModule\RepositoryInterface\RolesRepositoryInterface;
use Modules\AdminRoleAuthModule\Http\Requests\Admin\AdminRequest;
use Modules\AdminRoleAuthModule\Http\Requests\Admin\UpdateAccountRequest;
use Modules\AdminRoleAuthModule\Http\Requests\Admin\UpdatePasswordRequest;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use DataTables;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminsController extends Controller implements HasMiddleware
{
    protected $adminRepository;
    protected $roleRepository;
    protected $jobRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Admins', only: ['index']),
            new Middleware('permission:Create Admins', only: ['create', 'store']),
            new Middleware('permission:Edit Admins', only: ['edit', 'update', 'changeActive']),
            new Middleware('permission:Delete Admins', only: ['destroy']),
        ];
    }

    public function __construct(RolesRepositoryInterface $roleRepository)
    {
        $this->adminRepository = App::make('AdminCrudRepository');
        $this->roleRepository = $roleRepository;
        $this->jobRepository = App::make('JobCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $admins = $this->adminRepository->getAll();
            return DataTables::of($admins)
                ->addColumn('role', function ($admin) {
                    return $admin->role->name ?? __('Without Role');
                })
                ->addColumn('actions', 'adminroleauthmodule::admins.partials.actions')
                ->addColumn('active', 'adminroleauthmodule::admins.partials.active')
                ->rawColumns(['actions', 'active', 'role'])
                ->make(true);
        }
        return view('adminroleauthmodule::admins.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = $this->roleRepository->getRolesByGuard();
        $jobs = $this->jobRepository->getActiveRecords();
        return view('adminroleauthmodule::admins.create', compact('roles', 'jobs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request): RedirectResponse
    {
        try {
            $record = $this->adminRepository->create($request->validated());
            if ($record)
                toastr()->success(__('Record successfully created.'));
            else
                return redirect()->back();
        } catch (\Exception $e) {
            //dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));
        }
        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver().'.admins.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver().'.admins.index');
        }

        return redirect()->route(auth()->getDefaultDriver().'.admins.edit', $record->id);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {   
        if ($id != auth()->guard('admin')->user()->id) {
            toastr()->error(__('It is not your profile to edit.'));
            return redirect(route(auth()->getDefaultDriver().'.admins.show', auth()->guard('admin')->user()->id));
        }
        return view('adminroleauthmodule::admins.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $admin = $this->adminRepository->findById($id);
        $roles = $this->roleRepository->getRolesByGuard();
        $jobs = $this->jobRepository->getActiveRecords();
        return view('adminroleauthmodule::admins.edit', compact('admin', 'roles', 'jobs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, $admin): RedirectResponse
    {
        try {
            $record = $this->adminRepository->update($admin, $request->validated());
            if ($record)
                toastr()->success(__('Record successfully updated.'));
            else
                return redirect()->back();  
        } catch (\Exception $e) {
            //dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));  
        }
        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver().'.admins.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver().'.admins.index');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $return = $this->adminRepository->delete($id);
            if (!$return)
                toastr()->error(__('You cannot delete your own account.'));
            else 
                toastr()->success(__('Record successfully deleted.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    public function changeActive(Request $request)
    {
        try {
            return $this->adminRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        try {
            $record = $this->adminRepository->updateAccount($request->validated());
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));
        }
        return redirect()->back();
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $record = $this->adminRepository->updatePassword($request->validated());
            if ($record) 
                toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));
        }
        return redirect()->back();
    }

}
