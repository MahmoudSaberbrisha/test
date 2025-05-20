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

            if ($request->save == 'close') {
                return redirect()->route('admin.bookings.index')->with('success', 'تمت إضافة إيرادات الحجوزات بنجاح');
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            toastr()->error(__('Something went wrong.'));
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
        $accountNumber = '41';
        $account = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_number', $accountNumber)->first();

        $accountNumber2 = '31';
        $account2 = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_number', $accountNumber2)->first();

        $accountNumber3 = '32';
        $account3 = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_number', $accountNumber3)->first();

        $accountNumber4 = '33';
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

        foreach ($bookingGroups as $group) {
            // كاش
            $cashAmount = $group->booking_group_payments->where('payment_method_id', 3)->sum('paid');
            if ($cashAmount > 0) {
                $desc = 'ايرادات الحجوزات -كاش مدفوعات الحجز رقم ' . $group->id;
                $exists = \Modules\AccountingDepartment\Models\Entry::where('description', $desc)->exists();
                if ($exists) {
                    continue;
                }
                // قيد أول: من حساب الكاش إلى حساب الإيرادات
                $entry1 = new \Modules\AccountingDepartment\Models\Entry();
                $entry1->entry_number = (string)$newEntryNumber++;
                $entry1->chart_of_account_id = $account2->id;
                $entry1->account_number = $account2->account_number;
                $entry1->account_name = $account2->account_name;
                $entry1->debit = $cashAmount;
                $entry1->credit = 0;
                $entry1->date = now();
                $entry1->description = $desc . ' (مدين)';
                $entry1->created_by = \Illuminate\Support\Facades\Auth::id();
                $entry1->approved = 1;
                $entry1->save();

                // قيد ثاني: إلى حساب الإيرادات
                $entry2 = new \Modules\AccountingDepartment\Models\Entry();
                $entry2->entry_number = (string)$newEntryNumber++;
                $entry2->chart_of_account_id = $account->id;
                $entry2->account_number = $account->account_number;
                $entry2->account_name = $account->account_name;
                $entry2->debit = 0;
                $entry2->credit = $cashAmount;
                $entry2->date = now();
                $entry2->description = $desc . ' (دائن)';
                $entry2->created_by = \Illuminate\Support\Facades\Auth::id();
                $entry2->approved = 1;
                $entry2->save();
            }
            // فيزا
            $visaAmount = $group->booking_group_payments->where('payment_method_id', 2)->sum('paid');
            if ($visaAmount > 0) {
                $desc = 'ايرادات الحجوزات -فيزا مدفوعات الحجز رقم ' . $group->id;
                $exists = \Modules\AccountingDepartment\Models\Entry::where('description', $desc)->exists();
                if ($exists) {
                    continue;
                }
                // قيد أول: من حساب الفيزا إلى حساب الإيرادات
                $entry1 = new \Modules\AccountingDepartment\Models\Entry();
                $entry1->entry_number = (string)$newEntryNumber++;
                $entry1->chart_of_account_id = $account3->id;
                $entry1->account_number = $account3->account_number;
                $entry1->account_name = $account3->account_name;
                $entry1->debit = $visaAmount;
                $entry1->credit = 0;
                $entry1->date = now();
                $entry1->description = $desc . ' (مدين)';
                $entry1->created_by = \Illuminate\Support\Facades\Auth::id();
                $entry1->approved = 1;
                $entry1->save();

                // قيد ثاني: إلى حساب الإيرادات
                $entry2 = new \Modules\AccountingDepartment\Models\Entry();
                $entry2->entry_number = (string)$newEntryNumber++;
                $entry2->chart_of_account_id = $account->id;
                $entry2->account_number = $account->account_number;
                $entry2->account_name = $account->account_name;
                $entry2->debit = 0;
                $entry2->credit = $visaAmount;
                $entry2->date = now();
                $entry2->description = $desc . ' (دائن)';
                $entry2->created_by = \Illuminate\Support\Facades\Auth::id();
                $entry2->approved = 1;
                $entry2->save();
            }
            // انستا باي
            $instaPayAmount = $group->booking_group_payments->where('payment_method_id', 1)->sum('paid');
            if ($instaPayAmount > 0) {
                $desc = 'ايرادات الحجوزات -انستا باي مدفوعات الحجز رقم ' . $group->id;
                $exists = \Modules\AccountingDepartment\Models\Entry::where('description', $desc)->exists();
                if ($exists) {
                    continue;
                }
                // قيد أول: من حساب انستا باي إلى حساب الإيرادات
                $entry1 = new \Modules\AccountingDepartment\Models\Entry();
                $entry1->entry_number = (string)$newEntryNumber++;
                $entry1->chart_of_account_id = $account4->id;
                $entry1->account_number = $account4->account_number;
                $entry1->account_name = $account4->account_name;
                $entry1->debit = $instaPayAmount;
                $entry1->credit = 0;
                $entry1->date = now();
                $entry1->description = $desc . ' (مدين)';
                $entry1->created_by = \Illuminate\Support\Facades\Auth::id();
                $entry1->approved = 1;
                $entry1->save();

                // قيد ثاني: إلى حساب الإيرادات
                $entry2 = new \Modules\AccountingDepartment\Models\Entry();
                $entry2->entry_number = (string)$newEntryNumber++;
                $entry2->chart_of_account_id = $account->id;
                $entry2->account_number = $account->account_number;
                $entry2->account_name = $account->account_name;
                $entry2->debit = 0;
                $entry2->credit = $instaPayAmount;
                $entry2->date = now();
                $entry2->description = $desc . ' (دائن)';
                $entry2->created_by = \Illuminate\Support\Facades\Auth::id();
                $entry2->approved = 1;
                $entry2->save();
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
            $this->processBookingRevenueEntry();
            session()->forget('bookingId');
            toastr()->success(__('Record successfully updated.'));
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));
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
            return response()->json(array('type' => 'error', 'text' => __('Something went wrong.')));
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
