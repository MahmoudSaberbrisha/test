<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Modules\AdminRoleAuthModule\Http\Requests\RoleRequest;
use Modules\AdminRoleAuthModule\RepositoryInterface\RolesRepositoryInterface;
use Illuminate\View\View;
use DataTables;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RolesController extends Controller implements HasMiddleware
{
    protected $roleRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Admin Roles', only: ['index']),
            new Middleware('permission:Create Admin Roles', only: ['create', 'store']),
            new Middleware('permission:Edit Admin Roles', only: ['edit', 'update', 'changeActive']),
            new Middleware('permission:Delete Admin Roles', only: ['destroy']),
        ];
    }

    public function __construct(RolesRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $roles = $this->roleRepository->getRoles();
            return DataTables::of($roles)
                ->addColumn('guard_name', function ($role) {
                    return __($role->guard_name);
                })
                ->addColumn('actions', 'adminroleauthmodule::roles.partials.actions')
                ->rawColumns(['actions', 'guard_name'])
                ->make(true);
        }
        return view('adminroleauthmodule::roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $guards = config()->get('permission.guards');
        // $permissions = $this->roleRepository->getPermissionsByGuard();
        $groups = $this->roleRepository->getGroupPermissions();
        $permissionsWithoutGroups = $this->roleRepository->getPermissionsWithoutGroups();
        return view('adminroleauthmodule::roles.create', compact('groups', 'guards', 'permissionsWithoutGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        try {
            $record = $this->roleRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver().'.roles.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver().'.roles.index');
        }

        return redirect()->route(auth()->getDefaultDriver().'.roles.edit', $record->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        //$guards = config()->get('permission.guards');
        //$role = $this->roleRepository->findById($id);
        $role_id = $id;
        //$permissions = $this->roleRepository->getPermissionsByGuard();
        return view('adminroleauthmodule::roles.edit', compact(/*'role', 'permissions', 'guards', */'role_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, $role): RedirectResponse
    {
        try {
            $this->roleRepository->update($role, $request->validated());
        } catch (\Exception $e) {
            // dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));  
        }
        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver().'.roles.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver().'.roles.index');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $this->roleRepository->delete($id);
        } catch (\Exception $e) {
            //dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }
}
