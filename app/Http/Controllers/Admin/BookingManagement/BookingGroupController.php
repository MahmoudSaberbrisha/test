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
        return redirect()->route(auth()->getDefaultDriver() . '.bookings.index');
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
            $this->processBookingRevenueEntry();
            // $this->processExtraServicesRevenueEntry();

            if ($request->save == 'close') {
                return redirect()->route('admin.bookings.index')->with('success', 'تمت إضافة إيرادات الحجوزات بنجاح');
            }
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
        }

        $pdfUrl = route('admin.print-invoice', ['id' => $bookingGroup->id]);
        session()->flash('generatePdf', $pdfUrl);

        if ($request->save == 'new')
            return redirect()->route('admin.booking-groups.create');
        elseif ($request->save == 'continue')
            return redirect()->route('admin.booking-groups.edit', $bookingGroup->id);
        elseif ($request->save == 'book') {
            session()->put('bookingGroupId', $bookingGroup->id);
            return redirect()->route('admin.booking-extra-services.create');
        }
        session()->forget('bookingId');
        session()->forget('bookingGroupId');
        return redirect()->route('admin.bookings.index');
    }
    private function processBookingRevenueEntry()
    {
        $accountNumber = '40103';
        $account = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_number', $accountNumber)->first();

        $accountNumber2 = '1010103';
        $account2 = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_number', $accountNumber2)->first();

        $accountNumber3 = '1010504';
        $account3 = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_number', $accountNumber3)->first();

        $accountNumber4 = '1010503';
        $account4 = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_number', $accountNumber4)->first();

        if (!$account) {
            toastr()->error('حساب إيرادات الحجوزات غير موجود');
            return;
        }

        $bookingGroups = \App\Models\BookingGroup::all()->filter(function ($group) {
            return $group->paid > 0;
        });

        if ($bookingGroups->isEmpty()) {
            toastr()->error('لا يوجد مبالغ مدفوعة لإضافتها');
            return;
        }

        $lastEntryNumber = \Modules\AccountingDepartment\Models\Entry::orderBy('id', 'desc')->value('entry_number');
        $newEntryNumber = 1;
        if ($lastEntryNumber !== null && is_numeric($lastEntryNumber)) {
            $newEntryNumber = intval($lastEntryNumber) + 1;
        }

        $createEntry = function ($entryNumber, $account, $debit, $credit, $desc) {
            $entry = new \Modules\AccountingDepartment\Models\Entry();
            $entry->entry_number = (string)$entryNumber;
            $entry->chart_of_account_id = $account->id;
            $entry->account_number = $account->account_number;
            $entry->account_name = $account->account_name;
            $entry->debit = $debit;
            $entry->credit = $credit;
            $entry->date = now();
            $entry->description = $desc;
            $entry->created_by = \Illuminate\Support\Facades\Auth::id();
            $entry->approved = 1;
            $entry->save();
        };

        foreach ($bookingGroups as $group) {
            // Determine cash account based on currency id
            $cashAccountNumber = '1010103'; // default
            if ($group->currency_id == 3) {
                $cashAccountNumber = '1010104';
            }
            $cashAccount = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_number', $cashAccountNumber)->first();

            $paymentMethods = [
                3 => $cashAccount,
                2 => $account3,
                1 => $account4,
            ];

            foreach ($paymentMethods as $paymentMethodId => $accountForMethod) {
                $amount = $group->booking_group_payments->where('payment_method_id', $paymentMethodId)->sum('paid');
                if ($amount > 0) {
                    $desc = 'ايرادات الحجوزات -' . match ($paymentMethodId) {
                        3 => 'كاش',
                        2 => 'فيزا',
                        1 => 'انستا باي',
                        default => 'مدفوعات الحجز',
                    } . ' رقم ' . $group->id;

                    // Check if entries exist for this payment method and booking group
                    $existingDebitEntry = \Modules\AccountingDepartment\Models\Entry::where('description', $desc . ' (مدين)')->first();
                    $existingCreditEntry = \Modules\AccountingDepartment\Models\Entry::where('description', $desc . ' (دائن)')->first();

                    if ($existingDebitEntry && $existingCreditEntry) {
                        // Update existing entries
                        $existingDebitEntry->debit = $amount;
                        $existingDebitEntry->credit = 0;
                        $existingDebitEntry->date = now();
                        $existingDebitEntry->save();

                        $existingCreditEntry->debit = 0;
                        $existingCreditEntry->credit = $amount;
                        $existingCreditEntry->date = now();
                        $existingCreditEntry->save();
                    } else {
                        // Create new entries
                        $createEntry($newEntryNumber++, $accountForMethod, $amount, 0, $desc . ' (مدين)');
                        $createEntry($newEntryNumber++, $account, 0, $amount, $desc . ' (دائن)');
                    }
                } else {
                    // If amount is 0, optionally update existing entries to zero or delete
                    $desc = 'ايرادات الحجوزات -' . match ($paymentMethodId) {
                        3 => 'كاش',
                        2 => 'فيزا',
                        1 => 'انستا باي',
                        default => 'مدفوعات الحجز',
                    } . ' رقم ' . $group->id;

                    $existingDebitEntry = \Modules\AccountingDepartment\Models\Entry::where('description', $desc . ' (مدين)')->first();
                    $existingCreditEntry = \Modules\AccountingDepartment\Models\Entry::where('description', $desc . ' (دائن)')->first();

                    if ($existingDebitEntry && $existingCreditEntry) {
                        $existingDebitEntry->debit = 0;
                        $existingDebitEntry->credit = 0;
                        $existingDebitEntry->date = now();
                        $existingDebitEntry->save();

                        $existingCreditEntry->debit = 0;
                        $existingCreditEntry->credit = 0;
                        $existingCreditEntry->date = now();
                        $existingCreditEntry->save();
                    }
                }
            }
        }
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
            if (method_exists($this, 'processBookingRevenueEntry')) {
                $this->processBookingRevenueEntry();
            }
            if (method_exists($this, 'processExtraServicesRevenueEntry')) {
                $this->processExtraServicesRevenueEntry();
            }
            session()->forget('bookingId');
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
        }

        $pdfUrl = route(auth()->getDefaultDriver() . '.print-invoice', ['id' => $booking_group]);
        session()->flash('generatePdf', $pdfUrl);

        if ($request->save == 'new')
            return redirect()->route(auth()->getDefaultDriver() . '.booking-groups.create');
        elseif ($request->save == 'continue')
            return redirect()->back();
        elseif ($request->save == 'book') {
            session()->put('bookingGroupId', $booking_group);
            return redirect()->route(auth()->getDefaultDriver() . '.booking-extra-services.create');
        }
        session()->forget('bookingId');
        session()->forget('bookingGroupId');
        return redirect()->route(auth()->getDefaultDriver() . '.bookings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            // Delete related accounting entries for this booking group
            $entries = \Modules\AccountingDepartment\Models\Entry::where('description', 'like', '%رقم ' . $id . '%')->get();
            foreach ($entries as $entry) {
                $entry->delete();
            }

            $this->dataRepository->delete($id);
            toastr()->success(__('Record successfully deleted.'));
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
        }
        return redirect()->back();
    }

    public function changeActive(Request $request)
    {
        try {
            return $this->dataRepository->active($request->id, $request->value);
        } catch (\Exception $e) {
            return response()->json(array('type' => 'error', 'text' => $e->getMessage()));
        }
    }

    public function clientBooking($id)
    {
        $booking = $this->dataRepository->findById($id);
        if ($booking) {
            session()->put('bookingId', $id);
            return redirect()->route(auth()->getDefaultDriver() . '.booking-groups.create');
        } else {
            toastr()->warning(__('No such booking.'));
            return redirect()->route(auth()->getDefaultDriver() . '.booking-groups.index');
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
            return redirect()->route(auth()->getDefaultDriver() . '.booking-extra-services.create');
        } else {
            toastr()->warning(__('No such booking.'));
            return redirect()->route(auth()->getDefaultDriver() . '.booking-groups.index');
        }
    }
}
