<?php

namespace App\Http\Controllers\Admin\BookingManagement;

use App\Models\Booking;
use App\RepositoryInterface\BookingRepositoryInterface;
use App\Http\Requests\BookingManagement\BookingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use DataTables;
use App\Services\PdfService;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DynamicExport;
use App\Exports\MultiTableExport;

class BookingController extends Controller implements HasMiddleware
{
    protected
        $dataRepository,
        $boatRepository,
        $typeRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Bookings', only: ['index', 'printPdf', 'printExcel']),
            new Middleware('permission:Create Bookings', only: ['store']),
            new Middleware('permission:Edit Bookings', only: ['update']),
            new Middleware('permission:Delete Bookings', only: ['destroy']),
        ];
    }

    public function __construct(BookingRepositoryInterface $dataRepository)
    {
        $this->dataRepository = $dataRepository;
        $this->boatRepository = App::make('SailingBoatCrudRepository');
        $this->typeRepository = App::make('TypeCrudRepository');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->ajax() ) {
            $types = $this->dataRepository->getAll();
            return DataTables::of($types)
                ->addColumn('booking_type', function ($row) {
                    return __(BOOKING_TYPES[$row->booking_type]);
                })
                ->addColumn('expand', 'admin.pages.booking-management.bookings.partials.expand')
                ->addColumn('actions', 'admin.pages.booking-management.bookings.partials.actions')
                ->rawColumns(['actions', 'expand'])
                ->make(true);
        }
        $boats = $this->boatRepository->getActiveRecords();
        $types = $this->typeRepository->getActiveRecords();
        return view('admin.pages.booking-management.bookings.index', compact('boats', 'types'));
    }

    public function getGroups($bookingId)
    {
        $booking = $this->dataRepository->findById($bookingId);
        return response()->json(
            $booking->booking_groups()->with('client')->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request): RedirectResponse
    {
        try {
            $booking = $this->dataRepository->create($request->validated());
            session()->put('bookingId', $booking->id);
            toastr()->success(__('Record successfully created.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));
        }
        if ($request->save == 'continue')
            return redirect()->route(auth()->getDefaultDriver().'.booking-groups.create');
        return redirect()->route(auth()->getDefaultDriver().'.bookings.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookingRequest $request, $booking): RedirectResponse
    {
        try {
            $this->dataRepository->update($booking, $request->validated());
            session()->put('bookingId', $booking);
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            // dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));
        }
        if ($request->save == 'continue')
            return redirect()->route(auth()->getDefaultDriver().'.booking-groups.create');
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

    public function clientBooking($id)
    {
        $booking = $this->dataRepository->findById($id);
        if ($booking) {
            session()->put('bookingId', $id);
            return redirect()->route(auth()->getDefaultDriver().'.booking-groups.create');
        } else {
            toastr()->success(__('No such booking.'));
            return redirect()->route(auth()->getDefaultDriver().'.bookings.index');
        }
    }

    public function printPdf($id)
    {
        $booking = $this->dataRepository->findById($id);
        $clientTypes = collect();
        foreach ($booking->booking_groups as $group) {
            foreach ($group->booking_group_members as $member) {
                $clientTypes->put($member->client_type_id, $member->client_type);
            }
        }

        $clientTypeCounts = [];
        foreach ($booking->booking_groups as $group) {
            $counts = $clientTypes->mapWithKeys(function ($type) use ($group) {
                $count = $group->booking_group_members
                    ->where('client_type_id', $type->id)
                    ->sum('members_count');
                return [$type->id => $count];
            })->toArray();

            $clientTypeCounts[$group->id] = $counts;
        }

        $paymentMethods = collect();
        $paymentAmounts = [];
        foreach ($booking->booking_groups as $group) {
            foreach ($group->booking_group_payments as $payment) {
                $paymentMethods->put($payment->payment_method_id, $payment->payment_method);
                if (!isset($paymentAmounts[$group->id][$payment->payment_method_id])) {
                    $paymentAmounts[$group->id][$payment->payment_method_id] = 0;
                }
                $paymentAmounts[$group->id][$payment->payment_method_id] += $payment->paid;
            }
        }

        $pdfService = new PdfService();
        return $pdfService->generatePdf('admin.pages.booking-management.bookings.print-reservation-data', compact('booking', 'clientTypes', 'clientTypeCounts', 'paymentAmounts', 'paymentMethods'), __('Reservation Data'), 'A4-L');
    }

    public function printExcel($id)
    {
        $booking = $this->dataRepository->findById($id);

        $clientTypes = collect();
        foreach ($booking->booking_groups as $group) {
            foreach ($group->booking_group_members as $member) {
                $clientTypes->put($member->client_type_id, $member->client_type);
            }
        }

        $paymentMethods = collect();
        $paymentAmounts = [];
        foreach ($booking->booking_groups as $group) {
            foreach ($group->booking_group_payments as $payment) {
                $paymentMethods->put($payment->payment_method_id, $payment->payment_method);
                if (!isset($paymentAmounts[$group->id][$payment->payment_method_id])) {
                    $paymentAmounts[$group->id][$payment->payment_method_id] = 0;
                }
                $paymentAmounts[$group->id][$payment->payment_method_id] += $payment->paid;
            }
        }

        $headings = [
            __('Name'),
            __('Serial No.'),
            __('Total Members'),
            ...$clientTypes->pluck('name')->toArray(),
            __('Paid'),
            ...$paymentMethods->pluck('name')->toArray(),
            __('Remain'),
            __('Total'),
            __('Phone'),
            __('Client Supplier'),
            __('Notes')
        ];

        $data = $booking->booking_groups->map(function ($group) use ($clientTypes, $paymentMethods, $paymentAmounts) {
            $row = [
                $group->client->name,
                $group->booking_group_num,
                $group->total_members,
            ];

            foreach ($clientTypes as $clientType) {
                $count = $group->booking_group_members
                    ->where('client_type_id', $clientType->id)
                    ->sum('members_count');
                $row[] = $count === 0 ? '0' : $count;
            }

            $row[] = $group->paid === 0 ? '0' : $group->paid;

            foreach ($paymentMethods as $paymentMethod) {
                $amount = $paymentAmounts[$group->id][$paymentMethod->id] ?? 0;
                $row[] = $amount === 0 ? '0' : $amount;
            }

            $row = array_merge($row, [
                $group->remain == 0 ? '0' : $group->remain,
                $group->total == 0 ? '0' : $group->total,
                $group->client->phone,
                $group->client_supplier->name ?? '-',
                $group->notes ?? '-',
            ]);

            return $row;
        });

        $bookingInfo = [
            'title' => __('Cruise Data'),
            'headings' => [
                __('Reservation Day'),
                __('Booking Date'),
                __('Start Time'),
                __('End Time'),
                __('Cruise Type'),
                __('Boat Name')
            ],
            'data' => [
                [
                    __(WEEK_DAYES[$booking->booking_date->dayOfWeek]),
                    $booking->booking_date->format('Y-m-d'),
                    $booking->start_time->format('H:i'),
                    $booking->end_time->format('H:i'),
                    $booking->type->name,
                    $booking->sailing_boat->name
                ]
            ]
        ];

        $tables = [
            $bookingInfo,
            [
                'title' => __('Details'),
                'headings' => $headings,
                'data' => $data->toArray(),
            ]
        ];

        return Excel::download(
            new MultiTableExport($tables, __('Reservation Data')),
            'reservation_data.xlsx'
        );
    }
}
