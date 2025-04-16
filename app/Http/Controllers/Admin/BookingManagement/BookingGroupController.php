<?php

namespace App\Http\Controllers\Admin\BookingManagement;

use App\Models\BookingGroup;
use App\RepositoryInterface\BookingGroupRepositoryInterface;
use App\Http\Requests\BookingManagement\BookingGroupRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Services\PdfService;
use DataTables;

class BookingGroupController extends Controller implements HasMiddleware
{
    protected 
        $dataRepository,
        $clientRepository,
        $supplierRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Bookings', only: ['index']),
            new Middleware('permission:Create Booking Groups', only: ['create', 'store']),
            new Middleware('permission:Edit Booking Groups', only: ['edit', 'update', 'changeActive']),
            new Middleware('permission:Delete Booking Groups', only: ['destroy']),
        ];
    }

    public function __construct(BookingGroupRepositoryInterface $dataRepository)
    {
        $this->dataRepository = $dataRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return redirect()->route(auth()->getDefaultDriver().'.bookings.index');
    }

    public function create(): View
    {
        return view('admin.pages.booking-management.booking-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingGroupRequest $request): RedirectResponse
    {
        try {
            $bookingGroup = $this->dataRepository->create($request->validated());
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            // dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));  
        }

        $pdfUrl = route(auth()->getDefaultDriver().'.print-invoice', ['id' => $bookingGroup->id]);
        session()->flash('generatePdf', $pdfUrl);

        if ($request->save == 'new') 
            return redirect()->route(auth()->getDefaultDriver().'.booking-groups.create');
        elseif ($request->save == 'continue') 
            return redirect()->route(auth()->getDefaultDriver().'.booking-groups.edit', $bookingGroup->id);
        elseif ($request->save == 'book') {
            session()->put('bookingGroupId', $bookingGroup->id);
            return redirect()->route(auth()->getDefaultDriver() . '.booking-extra-services.create');
        }
        session()->forget('bookingId');
        session()->forget('bookingGroupId');
        return redirect()->route(auth()->getDefaultDriver().'.bookings.index');
    }

    public function edit($id): View
    {
        return view('admin.pages.booking-management.booking-groups.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookingGroupRequest $request, $booking_group): RedirectResponse
    {
        try {
            $this->dataRepository->update($booking_group, $request->validated());
            session()->forget('bookingId');
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));  
        }

        $pdfUrl = route(auth()->getDefaultDriver().'.print-invoice', ['id' => $booking_group]);
        session()->flash('generatePdf', $pdfUrl);

        if ($request->save == 'new') 
            return redirect()->route(auth()->getDefaultDriver().'.booking-groups.create');
        elseif ($request->save == 'continue') 
            return redirect()->back();
        elseif ($request->save == 'book') {
            session()->put('bookingGroupId', $booking_group);
            return redirect()->route(auth()->getDefaultDriver() . '.booking-extra-services.create');
        }
        session()->forget('bookingId');
        session()->forget('bookingGroupId');
        return redirect()->route(auth()->getDefaultDriver().'.bookings.index');
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

    public function clientBooking($id)
    {
        $booking = $this->dataRepository->findById($id);
        if ($booking) {
            session()->put('bookingId', $id);
            return redirect()->route(auth()->getDefaultDriver().'.booking-groups.create');
        } else {
            toastr()->warning(__('No such booking.'));
            return redirect()->route(auth()->getDefaultDriver().'.booking-groups.index');
        }
    }

    public function printPdf($id)
    {
        $bookingGroup = $this->dataRepository->findById($id);
        $pdfService = new PdfService();
        return $pdfService->generatePdf('admin.pages.booking-management.booking-groups.invoice', $bookingGroup, __('Cruise Booking Receipt'));
    }

    public function bookingGroupExtraServices($id)
    {
        $booking = BookingGroup::where('active', 1)->find($id);
        if ($booking) {
            session()->put('bookingGroupId', $id);
            return redirect()->route(auth()->getDefaultDriver().'.booking-extra-services.create');
        } else {
            toastr()->warning(__('No such booking.'));
            return redirect()->route(auth()->getDefaultDriver().'.booking-groups.index');
        }
    }

}
