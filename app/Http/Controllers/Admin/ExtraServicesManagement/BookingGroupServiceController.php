<?php

namespace App\Http\Controllers\Admin\ExtraServicesManagement;

use App\Models\BookingExtraService;
use App\Models\BookingGroupService;
use App\Models\BookingGroup;
use App\Http\Requests\ExtraServicesManagement\BookingGroupServiceRequest;
use App\RepositoryInterface\BookingGroupServicesInterface;
use App\RepositoryInterface\BookingRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Services\PdfService;
use DataTables;

class BookingGroupServiceController extends Controller implements HasMiddleware
{
    protected $dataRepository, $bookingRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Booking Extra Services', only: ['index']),
            new Middleware('permission:Create Booking Extra Services', only: ['create', 'store']),
            new Middleware('permission:Edit Booking Extra Services', only: ['edit', 'update']),
            new Middleware('permission:Delete Booking Extra Services', only: ['destroy']),
        ];
    }

    public function __construct(BookingGroupServicesInterface $dataRepository)
    {
        $this->dataRepository = $dataRepository;
        $this->bookingRepository = app(BookingRepositoryInterface::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bookingGroupServices = $this->dataRepository->getAll();
            $groupedBookings = $bookingGroupServices->groupBy('booking_group_id')->map(function ($group) {
                $firstRecord = $group->first();
                return [
                    'booking_group_id' => $firstRecord->booking_group_id,
                    'client_name' => $firstRecord->booking_group->client->name,
                    'branch' => $firstRecord->branch->name,
                    'sailing_boat' => $firstRecord->booking->sailing_boat->name,
                    'booking_date_time' => $firstRecord->booking->booking_date->format('Y-m-d').' '.$firstRecord->booking->start_time->format('H:i'),
                    'total_services' => $group->sum('services_count'),
                    'booking_type' => __(BOOKING_TYPES[$firstRecord->booking->booking_type]),
                ];
            });

            return DataTables::of($groupedBookings)
                ->addColumn('expand', 'admin.pages.extra-services-management.booking-group-services.partials.expand')
                ->addColumn('actions', function ($row) {
                    return view('admin.pages.extra-services-management.booking-group-services.partials.actions', [
                        'booking_group_id' => $row['booking_group_id'],
                    ])->render();
                })
                ->rawColumns(['actions', 'expand'])
                ->make(true);
        }
        return view('admin.pages.extra-services-management.booking-group-services.index');
    }

    public function getServices($booking_group_id)
    {
        $services = $this->dataRepository->findById($booking_group_id);
        return response()->json($services);
    }

    public function create(): View
    {
        return view('admin.pages.extra-services-management.booking-group-services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingGroupServiceRequest $request): RedirectResponse
    {
        try {
            $bookingGroupId = $this->dataRepository->create($request->validated());
            session()->forget('bookingGroupId');
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }

        $pdfUrl = route(auth()->getDefaultDriver().'.print-service-invoices', ['id' => $bookingGroupId]);
        session()->flash('generatePdf', $pdfUrl);

        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver().'.booking-extra-services.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver() . '.booking-extra-services.index');
        }
        return redirect()->route(auth()->getDefaultDriver().'.booking-extra-services.edit', $bookingGroupId);
    }

    public function edit($booking_group_id)
    {
        $bookingGroupServices = $this->dataRepository->findById($booking_group_id);
        session()->forget('bookingGroupId');
        if ($bookingGroupServices)
            return view('admin.pages.extra-services-management.booking-group-services.edit', [
                'booking_group_id' => $booking_group_id
            ]);
        else
            toastr()->error(__('No such booking.'));  
        return redirect()->route(auth()->getDefaultDriver() . '.booking-extra-services.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookingGroupServiceRequest $request, $booking_group_id): RedirectResponse
    {
        try {
            $this->dataRepository->update($request->validated());
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }

        $pdfUrl = route(auth()->getDefaultDriver().'.print-service-invoices', ['id' => $booking_group_id]);
        session()->flash('generatePdf', $pdfUrl);

        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver() . '.booking-extra-services.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver() . '.booking-extra-services.index');
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

    public function deleteService($id)
    {
        try {
            $this->dataRepository->deleteService($id);
            toastr()->success(__('Record successfully deleted.'));
        } catch (\Exception $e) {
            // dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));  
        }
        return redirect()->back();
    }

    public function printMultiPdf($id)
    {
        $bookingServices = $this->dataRepository->findById($id);
        $pdfService = new PdfService();
        $pdfService->generateMultiPdf('admin.pages.extra-services-management.booking-group-services.invoice', $bookingServices, __('Booking Extra Services Receipt'));
    }

    public function printPdf($id)
    {
        $bookingService = $this->dataRepository->findOneService($id);
        $pdfService = new PdfService();
        $pdfService->generatePdf('admin.pages.extra-services-management.booking-group-services.invoice', $bookingService, __('Booking Extra Services Receipt'));
    }

}
