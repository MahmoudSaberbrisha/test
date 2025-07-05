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
        $admin = auth()->guard('admin')->user();

        $query = Booking::with([
            'booking_groups',
            'branch' => function ($query) {
                $query->withTranslation();
            },
            'sailing_boat' => function ($query) {
                $query->withTranslation();
            },
            'type' => function ($query) {
                $query->withTranslation();
            },
        ]);

        if ($admin->branch_id) {
            $query->where('branch_id', $admin->branch_id);
        }

        // Calculate total paid sum for all booking group payments, filtered by branch if applicable
        $totalPaid = \App\Models\BookingGroupPayment::query()
            ->when($admin->branch_id, function ($q) use ($admin) {
                $q->whereHas('booking_group', function ($q2) use ($admin) {
                    $q2->whereHas('booking', function ($q3) use ($admin) {
                        $q3->where('branch_id', $admin->branch_id);
                    });
                });
            })
            ->sum('paid');

        if ($request->ajax()) {
            return DataTables::of($query->get())
                ->addColumn('booking_type', function ($row) {
                    return __(BOOKING_TYPES[$row->booking_type]);
                })
                ->addColumn('total_paid', function ($row) {
                    return $row->booking_groups->sum(function ($group) {
                        return $group->booking_group_payments->sum('paid');
                    });
                })
                ->addColumn('expand', 'admin.pages.booking-management.bookings.partials.expand')
                ->addColumn('actions', 'admin.pages.booking-management.bookings.partials.actions')
                ->rawColumns(['actions', 'expand'])
                ->make(true);
        }

        $boats = $this->boatRepository->getActiveRecords();
        $types = $this->typeRepository->getActiveRecords();

        if ($admin->branch_id) {
            $boats = $boats->filter(function($boat) use ($admin) {
                return $boat->branch_id == $admin->branch_id;
            });
        }

        $types = $this->typeRepository->getActiveRecords();

        return view('admin.pages.booking-management.bookings.index', compact('boats', 'types', 'totalPaid'));
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
            return redirect()->route(auth()->getDefaultDriver() . '.booking-groups.create');
        return redirect()->route(auth()->getDefaultDriver() . '.bookings.index');
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
            return redirect()->route(auth()->getDefaultDriver() . '.booking-groups.create');
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

    public function clientBooking($id)
    {
        $booking = $this->dataRepository->findById($id);
        if ($booking) {
            session()->put('bookingId', $id);
            return redirect()->route(auth()->getDefaultDriver() . '.booking-groups.create');
        } else {
            toastr()->success(__('No such booking.'));
            return redirect()->route(auth()->getDefaultDriver() . '.bookings.index');
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

        // Calculate total members for each client type
        $totalClientTypeCounts = [];
        foreach ($clientTypes as $type) {
            $totalClientTypeCounts[$type->id] = 0;
            foreach ($booking->booking_groups as $group) {
                $totalClientTypeCounts[$type->id] += $group->booking_group_members
                    ->where('client_type_id', $type->id)
                    ->sum('members_count');
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

        // Calculate totals for payments
        $totalPayments = [];
        foreach ($paymentMethods as $method) {
            $totalPayments[$method->id] = 0;
            foreach ($booking->booking_groups as $group) {
                $totalPayments[$method->id] += $paymentAmounts[$group->id][$method->id] ?? 0;
            }
        }

        $pdfService = new PdfService();
        return $pdfService->generatePdf(
            'admin.pages.booking-management.bookings.print-reservation-data',
            compact(
                'booking',
                'clientTypes',
                'clientTypeCounts',
                'paymentAmounts',
                'paymentMethods',
                'totalClientTypeCounts',
                'totalPayments'
            ),
            __('Reservation Data'),
            'A4-L'
        );
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
    public function cruiseStatementPdf($id)
    {
        $booking = $this->dataRepository->findById($id);

        $aggregatedClientTypes = [];
        foreach ($booking->booking_groups as $group) {
            foreach ($group->booking_group_members as $member) {
                $clientTypeId = $member->client_type_id;
                if (!isset($aggregatedClientTypes[$clientTypeId])) {
                    $aggregatedClientTypes[$clientTypeId] = [
                        'name' => $member->client_type->name,
                        'count' => 0,
                    ];
                }
                $aggregatedClientTypes[$clientTypeId]['count'] += $member->members_count;
            }
        }

        $currencyTotals = [];
        foreach ($booking->booking_groups as $group) {
            $currencyId = $group->currency_id;
            $currencySymbol = $group->currency_symbol;

            if (!isset($currencyTotals[$currencyId])) {
                $currencyTotals[$currencyId] = [
                    'symbol' => $currencySymbol,
                    'discount' => 0,
                    'price' => 0,
                    'paid' => 0,
                    'total' => 0
                ];
            }
            $currencyTotals[$currencyId]['discount'] += $group->discounted;
            $currencyTotals[$currencyId]['paid'] += $group->paid;
            $currencyTotals[$currencyId]['total'] += $group->total;
            $currencyTotals[$currencyId]['price'] += $group->price;
        }

        $paymentMethodTotals = [];
        $paymentMethodByCurrency = [];
        foreach ($booking->booking_groups as $group) {
            foreach ($group->booking_group_payments as $payment) {
                $methodId = $payment->payment_method_id;
                $methodName = $payment->payment_method->name;
                $currencyId = $group->currency_id;
                $currencySymbol = $group->currency_symbol;

                if (!isset($paymentMethodTotals[$methodId])) {
                    $paymentMethodTotals[$methodId] = [
                        'name' => $methodName,
                        'total' => 0
                    ];
                }
                $paymentMethodTotals[$methodId]['total'] += $payment->paid;

                if (!isset($paymentMethodByCurrency[$currencyId]['methods'][$methodId])) {
                    $paymentMethodByCurrency[$currencyId]['methods'][$methodId] = [
                        'name' => $methodName,
                        'total' => 0,
                        'symbol' => $currencySymbol
                    ];
                }
                $paymentMethodByCurrency[$currencyId]['methods'][$methodId]['total'] += $payment->paid;
                $paymentMethodByCurrency[$currencyId]['symbol'] = $currencySymbol;
            }
        }

        $servicesWithParents = [];
        $servicesWithoutParents = [];
foreach ($booking->booking_groups as $group) {
    foreach ($group->booking_group_services as $service) {
        if ($service->extra_service) {
            $parentId = $service->extra_service->parent_id;
            $serviceName = $service->extra_service->name;
            $currencyId = $service->currency_id;
            $currencySymbol = $service->currency->symbol;

            if ($parentId) {
                if (!isset($servicesWithParents[$parentId])) {
                    $servicesWithParents[$parentId] = [
                        'parent_name' => $service->extra_service->parent->name,
                        'services' => [],
                        'currencies' => [],
                        'payment_methods' => []
                    ];
                }

                if (!isset($servicesWithParents[$parentId]['services'][$serviceName])) {
                    $servicesWithParents[$parentId]['services'][$serviceName] = 0;
                }
                $servicesWithParents[$parentId]['services'][$serviceName] += $service->services_count;

                if (!isset($servicesWithParents[$parentId]['currencies'][$currencyId])) {
                    $servicesWithParents[$parentId]['currencies'][$currencyId] = [
                        'symbol' => $currencySymbol,
                        'paid' => 0
                    ];
                }
                $servicesWithParents[$parentId]['currencies'][$currencyId]['paid'] += $service->paid;

                foreach ($service->payments as $payment) {
                    $methodId = $payment->payment_method_id;
                    $methodName = $payment->payment_method->name;

                    if (!isset($servicesWithParents[$parentId]['payment_methods'][$methodId])) {
                        $servicesWithParents[$parentId]['payment_methods'][$methodId] = [
                            'name' => $methodName,
                            'amounts' => []
                        ];
                    }

                    if (!isset($servicesWithParents[$parentId]['payment_methods'][$methodId]['amounts'][$currencyId])) {
                        $servicesWithParents[$parentId]['payment_methods'][$methodId]['amounts'][$currencyId] = [
                            'symbol' => $currencySymbol,
                            'amount' => 0
                        ];
                    }

                    $servicesWithParents[$parentId]['payment_methods'][$methodId]['amounts'][$currencyId]['amount'] += $payment->paid;
                }
            } else {
                if (!isset($servicesWithoutParents[$serviceName])) {
                    $servicesWithoutParents[$serviceName] = [
                        'total_count' => 0,
                        'currencies' => [],
                        'payment_methods' => []
                    ];
                }

                $servicesWithoutParents[$serviceName]['total_count'] += $service->services_count;

                if (!isset($servicesWithoutParents[$serviceName]['currencies'][$currencyId])) {
                    $servicesWithoutParents[$serviceName]['currencies'][$currencyId] = [
                        'symbol' => $currencySymbol,
                        'unit_price' => $service->price,
                        'paid' => 0
                    ];
                }
                $servicesWithoutParents[$serviceName]['currencies'][$currencyId]['paid'] += $service->paid;

                foreach ($service->payments as $payment) {
                    $methodId = $payment->payment_method_id;
                    $methodName = $payment->payment_method->name;

                    if (!isset($servicesWithoutParents[$serviceName]['payment_methods'][$methodId])) {
                        $servicesWithoutParents[$serviceName]['payment_methods'][$methodId] = [
                            'name' => $methodName,
                            'amounts' => []
                        ];
                    }

                    if (!isset($servicesWithoutParents[$serviceName]['payment_methods'][$methodId]['amounts'][$currencyId])) {
                        $servicesWithoutParents[$serviceName]['payment_methods'][$methodId]['amounts'][$currencyId] = [
                            'symbol' => $currencySymbol,
                            'amount' => 0
                        ];
                    }

                    $servicesWithoutParents[$serviceName]['payment_methods'][$methodId]['amounts'][$currencyId]['amount'] += $payment->paid;
                }
            }
        }
    }
}

        $combinedTotals = [];
        $combinedPaymentMethods = [];

        foreach ($currencyTotals as $currencyId => $currency) {
            $combinedTotals[$currencyId] = [
                'symbol' => $currency['symbol'],
                'total' => $currency['paid']
            ];
        }

        foreach ($servicesWithParents as $parentData) {
            foreach ($parentData['currencies'] as $currencyId => $currency) {
                if (!isset($combinedTotals[$currencyId])) {
                    $combinedTotals[$currencyId] = [
                        'symbol' => $currency['symbol'],
                        'total' => 0
                    ];
                }
                $combinedTotals[$currencyId]['total'] += $currency['paid'];
            }
        }

        foreach ($servicesWithoutParents as $serviceData) {
            foreach ($serviceData['currencies'] as $currencyId => $currency) {
                if (!isset($combinedTotals[$currencyId])) {
                    $combinedTotals[$currencyId] = [
                        'symbol' => $currency['symbol'],
                        'total' => 0
                    ];
                }
                $combinedTotals[$currencyId]['total'] += $currency['paid'];
            }
        }

        foreach ($paymentMethodByCurrency as $currencyId => $currencyData) {
            foreach ($currencyData['methods'] as $methodId => $method) {
                if (!isset($combinedPaymentMethods[$methodId])) {
                    $combinedPaymentMethods[$methodId] = [
                        'name' => $method['name'],
                        'amounts' => []
                    ];
                }
                if (!isset($combinedPaymentMethods[$methodId]['amounts'][$currencyId])) {
                    $combinedPaymentMethods[$methodId]['amounts'][$currencyId] = [
                        'symbol' => $currencyData['symbol'],
                        'amount' => 0
                    ];
                }
                $combinedPaymentMethods[$methodId]['amounts'][$currencyId]['amount'] += $method['total'];
            }
        }

        foreach ($servicesWithParents as $parentData) {
            foreach ($parentData['payment_methods'] as $methodId => $method) {
                if (!isset($combinedPaymentMethods[$methodId])) {
                    $combinedPaymentMethods[$methodId] = [
                        'name' => $method['name'],
                        'amounts' => []
                    ];
                }
                foreach ($method['amounts'] as $currencyId => $amount) {
                    if (!isset($combinedPaymentMethods[$methodId]['amounts'][$currencyId])) {
                        $combinedPaymentMethods[$methodId]['amounts'][$currencyId] = [
                            'symbol' => $amount['symbol'],
                            'amount' => 0
                        ];
                    }
                    $combinedPaymentMethods[$methodId]['amounts'][$currencyId]['amount'] += $amount['amount'];
                }
            }
        }

        foreach ($servicesWithoutParents as $serviceData) {
            foreach ($serviceData['payment_methods'] as $methodId => $method) {
                if (!isset($combinedPaymentMethods[$methodId])) {
                    $combinedPaymentMethods[$methodId] = [
                        'name' => $method['name'],
                        'amounts' => []
                    ];
                }
                foreach ($method['amounts'] as $currencyId => $amount) {
                    if (!isset($combinedPaymentMethods[$methodId]['amounts'][$currencyId])) {
                        $combinedPaymentMethods[$methodId]['amounts'][$currencyId] = [
                            'symbol' => $amount['symbol'],
                            'amount' => 0
                        ];
                    }
                    $combinedPaymentMethods[$methodId]['amounts'][$currencyId]['amount'] += $amount['amount'];
                }
            }
        }

        $pdfService = new PdfService();
        return $pdfService->generatePdf(
            'admin.pages.booking-management.bookings.print-cruise-statement-data',
            compact('booking', 'aggregatedClientTypes', 'currencyTotals', 'paymentMethodTotals', 'paymentMethodByCurrency', 'servicesWithParents', 'servicesWithoutParents', 'combinedTotals', 'combinedPaymentMethods'),
            __('Cruise Statement'),
            'A4'
        );
    }

    public function cruiseStatementExcel($id)
    {
        $booking = $this->dataRepository->findById($id);

        $aggregatedClientTypes = [];
        foreach ($booking->booking_groups as $group) {
            foreach ($group->booking_group_members as $member) {
                $clientTypeId = $member->client_type_id;
                if (!isset($aggregatedClientTypes[$clientTypeId])) {
                    $aggregatedClientTypes[$clientTypeId] = [
                        'name' => $member->client_type->name,
                        'count' => 0,
                    ];
                }
                $aggregatedClientTypes[$clientTypeId]['count'] += $member->members_count;
            }
        }

        $currencyTotals = [];
        foreach ($booking->booking_groups as $group) {
            $currencyId = $group->currency_id;
            $currencySymbol = $group->currency_symbol;

            if (!isset($currencyTotals[$currencyId])) {
                $currencyTotals[$currencyId] = [
                    'symbol' => $currencySymbol,
                    'discount' => 0,
                    'price' => 0,
                    'paid' => 0,
                    'total' => 0
                ];
            }
            $currencyTotals[$currencyId]['discount'] += $group->discounted;
            $currencyTotals[$currencyId]['paid'] += $group->paid;
            $currencyTotals[$currencyId]['total'] += $group->total;
            $currencyTotals[$currencyId]['price'] += $group->price;
        }

        $paymentMethodTotals = [];
        $paymentMethodByCurrency = [];
        foreach ($booking->booking_groups as $group) {
            foreach ($group->booking_group_payments as $payment) {
                $methodId = $payment->payment_method_id;
                $methodName = $payment->payment_method->name;
                $currencyId = $group->currency_id;
                $currencySymbol = $group->currency_symbol;

                if (!isset($paymentMethodTotals[$methodId])) {
                    $paymentMethodTotals[$methodId] = [
                        'name' => $methodName,
                        'total' => 0
                    ];
                }
                $paymentMethodTotals[$methodId]['total'] += $payment->paid;

                if (!isset($paymentMethodByCurrency[$currencyId]['methods'][$methodId])) {
                    $paymentMethodByCurrency[$currencyId]['methods'][$methodId] = [
                        'name' => $methodName,
                        'total' => 0,
                        'symbol' => $currencySymbol
                    ];
                }
                $paymentMethodByCurrency[$currencyId]['methods'][$methodId]['total'] += $payment->paid;
                $paymentMethodByCurrency[$currencyId]['symbol'] = $currencySymbol;
            }
        }

        $servicesWithParents = [];
        $servicesWithoutParents = [];
        foreach ($booking->booking_groups as $group) {
            foreach ($group->booking_group_services as $service) {
                $parentId = $service->extra_service->parent_id;
                $serviceName = $service->extra_service->name;
                $currencyId = $service->currency_id;
                $currencySymbol = $service->currency->symbol;

                if ($parentId) {
                    if (!isset($servicesWithParents[$parentId])) {
                        $servicesWithParents[$parentId] = [
                            'parent_name' => $service->extra_service->parent->name,
                            'services' => [],
                            'currencies' => [],
                            'payment_methods' => []
                        ];
                    }

                    if (!isset($servicesWithParents[$parentId]['services'][$serviceName])) {
                        $servicesWithParents[$parentId]['services'][$serviceName] = 0;
                    }
                    $servicesWithParents[$parentId]['services'][$serviceName] += $service->services_count;

                    if (!isset($servicesWithParents[$parentId]['currencies'][$currencyId])) {
                        $servicesWithParents[$parentId]['currencies'][$currencyId] = [
                            'symbol' => $currencySymbol,
                            'paid' => 0
                        ];
                    }
                    $servicesWithParents[$parentId]['currencies'][$currencyId]['paid'] += $service->paid;

                    foreach ($service->payments as $payment) {
                        $methodId = $payment->payment_method_id;
                        $methodName = $payment->payment_method->name;

                        if (!isset($servicesWithParents[$parentId]['payment_methods'][$methodId])) {
                            $servicesWithParents[$parentId]['payment_methods'][$methodId] = [
                                'name' => $methodName,
                                'amounts' => []
                            ];
                        }

                        if (!isset($servicesWithParents[$parentId]['payment_methods'][$methodId]['amounts'][$currencyId])) {
                            $servicesWithParents[$parentId]['payment_methods'][$methodId]['amounts'][$currencyId] = [
                                'symbol' => $currencySymbol,
                                'amount' => 0
                            ];
                        }

                        $servicesWithParents[$parentId]['payment_methods'][$methodId]['amounts'][$currencyId]['amount'] += $payment->paid;
                    }
                } else {
                    if (!isset($servicesWithoutParents[$serviceName])) {
                        $servicesWithoutParents[$serviceName] = [
                            'total_count' => 0,
                            'currencies' => [],
                            'payment_methods' => []
                        ];
                    }

                    $servicesWithoutParents[$serviceName]['total_count'] += $service->services_count;

                    if (!isset($servicesWithoutParents[$serviceName]['currencies'][$currencyId])) {
                        $servicesWithoutParents[$serviceName]['currencies'][$currencyId] = [
                            'symbol' => $currencySymbol,
                            'unit_price' => $service->price,
                            'paid' => 0
                        ];
                    }
                    $servicesWithoutParents[$serviceName]['currencies'][$currencyId]['paid'] += $service->paid;

                    foreach ($service->payments as $payment) {
                        $methodId = $payment->payment_method_id;
                        $methodName = $payment->payment_method->name;

                        if (!isset($servicesWithoutParents[$serviceName]['payment_methods'][$methodId])) {
                            $servicesWithoutParents[$serviceName]['payment_methods'][$methodId] = [
                                'name' => $methodName,
                                'amounts' => []
                            ];
                        }

                        if (!isset($servicesWithoutParents[$serviceName]['payment_methods'][$methodId]['amounts'][$currencyId])) {
                            $servicesWithoutParents[$serviceName]['payment_methods'][$methodId]['amounts'][$currencyId] = [
                                'symbol' => $currencySymbol,
                                'amount' => 0
                            ];
                        }

                        $servicesWithoutParents[$serviceName]['payment_methods'][$methodId]['amounts'][$currencyId]['amount'] += $payment->paid;
                    }
                }
            }
        }

        $combinedTotals = [];
        $combinedPaymentMethods = [];

        foreach ($currencyTotals as $currencyId => $currency) {
            $combinedTotals[$currencyId] = [
                'symbol' => $currency['symbol'],
                'total' => $currency['paid']
            ];
        }

        foreach ($servicesWithParents as $parentData) {
            foreach ($parentData['currencies'] as $currencyId => $currency) {
                if (!isset($combinedTotals[$currencyId])) {
                    $combinedTotals[$currencyId] = [
                        'symbol' => $currency['symbol'],
                        'total' => 0
                    ];
                }
                $combinedTotals[$currencyId]['total'] += $currency['paid'];
            }
        }

        foreach ($servicesWithoutParents as $serviceData) {
            foreach ($serviceData['currencies'] as $currencyId => $currency) {
                if (!isset($combinedTotals[$currencyId])) {
                    $combinedTotals[$currencyId] = [
                        'symbol' => $currency['symbol'],
                        'total' => 0
                    ];
                }
                $combinedTotals[$currencyId]['total'] += $currency['paid'];
            }
        }

        foreach ($paymentMethodByCurrency as $currencyId => $currencyData) {
            foreach ($currencyData['methods'] as $methodId => $method) {
                if (!isset($combinedPaymentMethods[$methodId])) {
                    $combinedPaymentMethods[$methodId] = [
                        'name' => $method['name'],
                        'amounts' => []
                    ];
                }
                if (!isset($combinedPaymentMethods[$methodId]['amounts'][$currencyId])) {
                    $combinedPaymentMethods[$methodId]['amounts'][$currencyId] = [
                        'symbol' => $currencyData['symbol'],
                        'amount' => 0
                    ];
                }
                $combinedPaymentMethods[$methodId]['amounts'][$currencyId]['amount'] += $method['total'];
            }
        }

        foreach ($servicesWithParents as $parentData) {
            foreach ($parentData['payment_methods'] as $methodId => $method) {
                if (!isset($combinedPaymentMethods[$methodId])) {
                    $combinedPaymentMethods[$methodId] = [
                        'name' => $method['name'],
                        'amounts' => []
                    ];
                }
                foreach ($method['amounts'] as $currencyId => $amount) {
                    if (!isset($combinedPaymentMethods[$methodId]['amounts'][$currencyId])) {
                        $combinedPaymentMethods[$methodId]['amounts'][$currencyId] = [
                            'symbol' => $amount['symbol'],
                            'amount' => 0
                        ];
                    }
                    $combinedPaymentMethods[$methodId]['amounts'][$currencyId]['amount'] += $amount['amount'];
                }
            }
        }

        foreach ($servicesWithoutParents as $serviceData) {
            foreach ($serviceData['payment_methods'] as $methodId => $method) {
                if (!isset($combinedPaymentMethods[$methodId])) {
                    $combinedPaymentMethods[$methodId] = [
                        'name' => $method['name'],
                        'amounts' => []
                    ];
                }
                foreach ($method['amounts'] as $currencyId => $amount) {
                    if (!isset($combinedPaymentMethods[$methodId]['amounts'][$currencyId])) {
                        $combinedPaymentMethods[$methodId]['amounts'][$currencyId] = [
                            'symbol' => $amount['symbol'],
                            'amount' => 0
                        ];
                    }
                    $combinedPaymentMethods[$methodId]['amounts'][$currencyId]['amount'] += $amount['amount'];
                }
            }
        }

        $tables = [];

        $summaryHeadings = [
            __('Booking Date'),
            __('Boat Name'),
            __('Booking Type'),
            __('Price Person / Hour')
        ];

        $pricePerHour = [];
        foreach ($booking->booking_groups as $group) {
            $pricePerHour[] = $group->hour_member_price . $group->currency_symbol;
        }

        $summaryData = [
            [
                $booking->booking_date->format('Y-m-d'),
                $booking->sailing_boat->name,
                $booking->type->name . ' - ' . __($booking->booking_type) . ' - ' . $booking->branch->name . ' ( ' . $booking->start_time->format('H:i') . ' )',
                implode(', ', $pricePerHour)
            ]
        ];

        $tables = [];

        $summaryHeadings = [
            __('Booking Date'),
            __('Boat Name'),
            __('Booking Type'),
            __('Price Person / Hour')
        ];

        $pricePerHour = [];
        foreach ($booking->booking_groups as $group) {
            $pricePerHour[] = $group->hour_member_price . $group->currency_symbol;
        }

        $summaryData = [
            [
                $booking->booking_date->format('Y-m-d'),
                $booking->sailing_boat->name,
                $booking->type->name . ' - ' . __($booking->booking_type) . ' - ' . $booking->branch->name . ' ( ' . $booking->start_time->format('H:i') . ' )',
                implode(', ', $pricePerHour)
            ]
        ];

        $tables[] = [
            'title' => __('Cruise Statement'),
            'headings' => $summaryHeadings,
            'data' => $summaryData,
        ];

        $statementHeadings = [
            __('Client Type'),
            __('Count')
        ];

        $statementData = [];

        $totalMembers = 0;
        foreach ($aggregatedClientTypes as $clientType) {
            $totalMembers += $clientType['count'];
        }

        $statementData[] = [
            __('Total Members'),
            $totalMembers
        ];

        foreach ($aggregatedClientTypes as $clientType) {
            $statementData[] = [
                $clientType['name'],
                $clientType['count']
            ];
        }

        $statementData[] = [('Total'), ''];
        foreach ($currencyTotals as $currency) {
            $statementData[] = [
                '',
                number_format($currency['price'], 2) . $currency['symbol']
            ];
        }

        $statementData[] = [('Discounted'), ''];
        foreach ($currencyTotals as $currency) {
            $statementData[] = [
                '',
                number_format($currency['discount'], 2) . $currency['symbol']
            ];
        }

        $statementData[] = [('Paid'), ''];
        foreach ($currencyTotals as $currency) {
            $statementData[] = [
                '',
                number_format($currency['paid'], 2) . $currency['symbol']
            ];
        }

        foreach ($paymentMethodTotals as $methodId => $method) {
            $statementData[] = [$method['name'], ''];
            foreach ($paymentMethodByCurrency as $currencyData) {
                if (isset($currencyData['methods'][$methodId])) {
                    $statementData[] = [
                        '',
                        number_format($currencyData['methods'][$methodId]['total'], 2) . $currencyData['symbol']
                    ];
                }
            }
        }

        $tables[] = [
            'title' => __('Cruise Statements'),
            'headings' => $statementHeadings,
            'data' => $statementData,
        ];

        $servicesHeadings = [
            __('Type'),
            __('Count')
        ];

        $servicesData = [];

        foreach ($servicesWithParents as $parentData) {
            $servicesData[] = [
                'is_merged' => true,
                'value' => $parentData['parent_name']
            ];

            foreach ($parentData['services'] as $serviceName => $count) {
                $servicesData[] = [
                    $serviceName,
                    $count
                ];
            }

            $servicesData[] = [('Paid'), ''];
            foreach ($parentData['currencies'] as $currency) {
                $servicesData[] = [
                    '',
                    number_format($currency['paid'], 2) . $currency['symbol']
                ];
            }

            foreach ($parentData['payment_methods'] as $methodId => $method) {
                $servicesData[] = [
                    'value' => $method['name']
                ];
                foreach ($method['amounts'] as $currency) {
                    $servicesData[] = [
                        '',
                        number_format($currency['amount'], 2) . $currency['symbol']
                    ];
                }
            }

            $servicesData[] = ['', ''];
            $servicesData[] = ['', ''];
        }

        foreach ($servicesWithoutParents as $serviceName => $serviceData) {
            $servicesData[] = [
                'is_merged' => true,
                'value' => $serviceName
            ];
            $servicesData[] = [
                __('Count'),
                $serviceData['total_count']
            ];

            $servicesData[] = [('Unit Price'), ''];
            foreach ($serviceData['currencies'] as $currency) {
                $servicesData[] = [
                    '',
                    number_format($currency['unit_price'], 2) . $currency['symbol']
                ];
            }

            $servicesData[] = [('Paid'), ''];
            foreach ($serviceData['currencies'] as $currency) {
                $servicesData[] = [
                    '',
                    number_format($currency['paid'], 2) . $currency['symbol']
                ];
            }

            foreach ($serviceData['payment_methods'] as $methodId => $method) {
                $servicesData[] = [
                    'value' => $method['name']
                ];
                foreach ($method['amounts'] as $currency) {
                    $servicesData[] = [
                        '',
                        number_format($currency['amount'], 2) . $currency['symbol']
                    ];
                }
            }

            $servicesData[] = ['', ''];
            $servicesData[] = ['', ''];
        }

        $tables[] = [
            'title' => __('Extra Services'),
            'headings' => $servicesHeadings,
            'data' => $servicesData,
        ];

        $totalsHeadings = [
            __('Type'),
            __('Value')
        ];

        $totalsData = [];

        $totalsData[] = [('Total'), ''];
        foreach ($combinedTotals as $currency) {
            $totalsData[] = [
                '',
                number_format($currency['total'], 2) . $currency['symbol']
            ];
        }

        foreach ($combinedPaymentMethods as $methodId => $method) {
            $totalsData[] = [$method['name'], ''];
            foreach ($method['amounts'] as $currencyId => $amount) {
                $totalsData[] = [
                    '',
                    number_format($amount['amount'], 2) . $amount['symbol']
                ];
            }
        }

        $tables[] = [
            'title' => __('Total'),
            'headings' => $totalsHeadings,
            'data' => $totalsData,
        ];

        return Excel::download(
            new MultiTableExport($tables, __('Cruise Statement')),
            'cruise_statement.xlsx'
        );
    }
}