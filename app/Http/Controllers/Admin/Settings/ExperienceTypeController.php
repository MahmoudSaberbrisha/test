<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\Settings\ExperienceTypeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use DataTables;

class ExperienceTypeController extends Controller implements HasMiddleware
{
    protected $homeworkStatusRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Experience Types', only: ['index']),
            new Middleware('permission:Create Experience Types', only: ['store']),
            new Middleware('permission:Edit Experience Types', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Experience Types', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->homeworkStatusRepository = App::make('ExperienceTypeCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $statuses = $this->homeworkStatusRepository->getAll();
            return DataTables::of($statuses)
                ->addColumn('colored_name', 'admin.pages.settings.experience-types.partials.colored_name')
                ->addColumn('actions', 'admin.pages.settings.experience-types.partials.actions')
                ->addColumn('active', 'admin.pages.settings.experience-types.partials.active')
                ->rawColumns(['actions', 'active', 'colored_name'])
                ->make(true);
        }
        return view('admin.pages.settings.experience-types.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExperienceTypeRequest $request): RedirectResponse
    {
        try {
            $this->homeworkStatusRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));

        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExperienceTypeRequest $request, $experience_type): RedirectResponse
    {
        try {
            $this->homeworkStatusRepository->update($experience_type, $request->validated());
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            // dd($e);
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
            $this->homeworkStatusRepository->delete($id);
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
            return $this->homeworkStatusRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong.')) );
        }
    }
}
