<?php

namespace Modules\AdminRoleAuthModule\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AdminRoleAuthModule\Models\Type;
use Modules\AdminRoleAuthModule\Http\Requests\TypeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;

class TypeController extends Controller implements HasMiddleware
{
    protected $typeRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Types', only: ['index']),
            new Middleware('permission:Create Types', only: ['store']),
            new Middleware('permission:Edit Types', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Types', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->typeRepository = App::make('TypeCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $types = $this->typeRepository->getAll();
            return DataTables::of($types)
                ->addColumn('actions', 'adminroleauthmodule::settings.types.partials.actions')
                ->addColumn('active', 'adminroleauthmodule::settings.types.partials.active')
                ->rawColumns(['actions', 'active'])
                ->make(true);
        }
        return view('adminroleauthmodule::settings.types.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeRequest $request): RedirectResponse
    {
        try {
            $this->typeRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TypeRequest $request, $type): RedirectResponse
    {
        try {
            $this->typeRepository->update($type, $request->validated());
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
            $this->typeRepository->delete($id);
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
            return $this->typeRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
