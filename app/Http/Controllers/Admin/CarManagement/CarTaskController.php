<?php

namespace App\Http\Controllers\Admin\CarManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\CarManagement\CarTaskRequest;
use DataTables;
use App\Models\CarTask;
use App\Services\PdfService;

class CarTaskController extends Controller implements HasMiddleware
{
    protected $carTaskRepository;
    protected $carContractRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Car Tasks', only: ['index']),
            new Middleware('permission:Create Car Tasks', only: ['store']),
            new Middleware('permission:Edit Car Tasks', only: ['update', 'changeActive']),
            new Middleware('permission:Delete Car Tasks', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->carTaskRepository = App::make('CarTaskCrudRepository');
        $this->carContractRepository = App::make('CarContractCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $task = $this->carTaskRepository->getAll();
            return DataTables::of($task)
                ->addColumn('actions', function ($task) {
                    return view('admin.pages.car-management.car-tasks.partials.actions', ['id' => $task->id])->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.pages.car-management.car-tasks.index');
    }

    public function create()
    {
        return view('admin.pages.car-management.car-tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarTaskRequest $request): RedirectResponse
    {
        try {
            $contract = $this->carTaskRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }
        $pdfUrl = route(auth()->getDefaultDriver().'.car-task-invoice', ['id' => $contract->id]);
        session()->flash('generatePdf', $pdfUrl);
        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver().'.car-tasks.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver() . '.car-tasks.index');
        }
        return redirect()->route(auth()->getDefaultDriver().'.car-tasks.edit', $contract->id);
    }

    public function edit($id)
    {
        $carTask = CarTask::findOrFail($id);
        return view('admin.pages.car-management.car-tasks.edit', compact('carTask'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarTaskRequest $request, $carContract): RedirectResponse
    {
        try {
            $this->carTaskRepository->update($carContract, $request->validated());
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            // dd($e);
            toastr()->error(__('Something went wrong.'));  
        }
        $pdfUrl = route(auth()->getDefaultDriver().'.car-task-invoice', ['id' => $carContract]);
        session()->flash('generatePdf', $pdfUrl);
        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver().'.car-tasks.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver().'.car-tasks.index');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $this->carTaskRepository->delete($id);
            toastr()->success(__('Record successfully deleted.'));
        } catch (\Exception $e) {
            // dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    public function printPdf($id)
    {
        $carTask = $this->carTaskRepository->findById($id);
        $pdfService = new PdfService();
        return $pdfService->generatePdf('admin.pages.car-management.car-tasks.invoice', $carTask, __('Car Task Receipt'));
    }
}
