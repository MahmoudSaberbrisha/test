<?php

namespace App\Http\Controllers\Admin\ClientsManagement;

use App\Http\Requests\ClientsManagement\FeedBackRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Validators\ValidationException;
use App\RepositoryInterface\FeedBackRepositoryInterface;
use DataTables;

class FeedBackController extends Controller implements HasMiddleware
{
    protected $dataRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View FeedBacks', only: ['index']),
            new Middleware('permission:Create FeedBacks', only: ['store']),
            new Middleware('permission:Edit FeedBacks', only: ['update']),
            new Middleware('permission:Delete FeedBacks', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->dataRepository = app(FeedBackRepositoryInterface::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $data = $this->dataRepository->getAll();
            return DataTables::of($data)
                ->addColumn('actions', 'admin.pages.clients-management.feedbacks.partials.actions')
                ->addColumn('colored_experience_type', function ($row) {
                    return view('admin.pages.clients-management.feedbacks.partials.colored_experience_type', ['experience_type' => $row->experience_type]);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('Y-m-d');
                })
                ->rawColumns(['actions', 'colored_experience_type', 'created_at'])
                ->make(true);
        }
        return view('admin.pages.clients-management.feedbacks.index');
    }

    public function create(): View
    {
        return view('admin.pages.clients-management.feedbacks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeedBackRequest $request): RedirectResponse
    {
        try {
            $data = $this->dataRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        if ($request->save == 'new') 
            return redirect()->route(auth()->getDefaultDriver().'.feedbacks.create');
        elseif ($request->save == 'continue') 
            return redirect()->route(auth()->getDefaultDriver().'.feedbacks.edit', $data->id);
        return redirect()->route(auth()->getDefaultDriver() . '.feedbacks.index');
    }

    public function edit($id): View
    {
        return view('admin.pages.clients-management.feedbacks.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FeedBackRequest $request, $feed_back): RedirectResponse
    {
        try {
            $this->dataRepository->update($feed_back, $request->validated());
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        if ($request->save == 'new') 
            return redirect()->route(auth()->getDefaultDriver().'.feedbacks.create');
        elseif ($request->save == 'continue') 
            return redirect()->back();
        return redirect()->route(auth()->getDefaultDriver() . '.feedbacks.index');
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
}
