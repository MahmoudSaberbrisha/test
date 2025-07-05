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
                    'booking_date_time' => $firstRecord->booking->booking_date->format('Y-m-d') . ' ' . $firstRecord->booking->start_time->format('H:i'),
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
            $this->processExtraServicesRevenueEntry($bookingGroupId);
        } catch (\Exception $e) {
            toastr()->error(__('Something went wrong.'));
        }

        $pdfUrl = route(auth()->getDefaultDriver() . '.print-service-invoices', ['id' => $bookingGroupId]);
        session()->flash('generatePdf', $pdfUrl);

        if ($request->save == 'new') {
            return redirect()->route(auth()->getDefaultDriver() . '.booking-extra-services.create');
        } elseif ($request->save == 'close') {
            return redirect()->route(auth()->getDefaultDriver() . '.booking-extra-services.index');
        }
        return redirect()->route(auth()->getDefaultDriver() . '.booking-extra-services.edit', $bookingGroupId);
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

        $pdfUrl = route(auth()->getDefaultDriver() . '.print-service-invoices', ['id' => $booking_group_id]);
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

    private function processExtraServicesRevenueEntry($bookingGroupId)
    {
        try {
            $accountNumber = '40103';
            $account = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_number', $accountNumber)->first();

            $accountNumber2 = '1010103';
            $account2 = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_number', $accountNumber2)->first();

            $accountNumber3 = '1010504';
            $account3 = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_number', $accountNumber3)->first();

            $accountNumber4 = '1010503';
            $account4 = \Modules\AccountingDepartment\Models\ChartOfAccount::where('account_number', $accountNumber4)->first();

            if (!$account) {
                toastr()->error('حساب إيرادات الخدمات الإضافية غير موجود');
                return;
            }

            $extraServices = \App\Models\BookingGroupService::where('booking_group_id', $bookingGroupId)
                ->get()
                ->filter(function ($service) {
                    return $service->paid > 0;
                });

            if ($extraServices->isEmpty()) {
                toastr()->error('لا يوجد مبالغ مدفوعة للخدمات الإضافية لإضافتها');
                return;
            }

            $lastEntryNumber = \Modules\AccountingDepartment\Models\Entry::orderBy('id', 'desc')->value('entry_number');
            $newEntryNumber = 1;
            if ($lastEntryNumber !== null && is_numeric($lastEntryNumber)) {
                $newEntryNumber = intval($lastEntryNumber) + 1;
            }

            foreach ($extraServices as $service) {

                $cashAmount = $service->payments->where('payment_method_id', 3)->sum('paid');
                if ($cashAmount > 0) {
                    $desc = 'ايرادات الخدمات الإضافية -كاش مدفوعات الخدمة رقم ' . $service->id;
                    $exists = \Modules\AccountingDepartment\Models\Entry::where('description', $desc)->exists();
                    if ($exists) {
                        continue;
                    }

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

                $visaAmount = $service->payments->where('payment_method_id', 2)->sum('paid');
                if ($visaAmount > 0) {
                    $desc = 'ايرادات الخدمات الإضافية -فيزا مدفوعات الخدمة رقم ' . $service->id;
                    $exists = \Modules\AccountingDepartment\Models\Entry::where('description', $desc)->exists();
                    if ($exists) {
                        continue;
                    }

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

                $instaPayAmount = $service->payments->where('payment_method_id', 1)->sum('paid');
                if ($instaPayAmount > 0) {
                    $desc = 'ايرادات الخدمات الإضافية -انستا باي مدفوعات الخدمة رقم ' . $service->id;
                    $exists = \Modules\AccountingDepartment\Models\Entry::where('description', $desc)->exists();
                    if ($exists) {
                        continue;
                    }

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
        } catch (\Exception $e) {
            \Log::error('Error in processExtraServicesRevenueEntry: ' . $e->getMessage());
            toastr()->error(__('حدث خطأ أثناء معالجة قيود الإيرادات للخدمات الإضافية.'));
        }
    }


    public function printPdf($id)
    {
        $bookingService = $this->dataRepository->findOneService($id);
        $pdfService = new PdfService();
        $pdfService->generatePdf('admin.pages.extra-services-management.booking-group-services.invoice', $bookingService, __('Booking Extra Services Receipt'));
    }
}