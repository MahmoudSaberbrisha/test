<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Client;
use App\Models\BookingGroup;
use App\Models\BookingGroupService;
use App\Models\ClientType;
use App\Services\PdfService;
use App\Exports\MultiTableExport;
use Maatwebsite\Excel\Facades\Excel;

class DetailedClientsReport extends Component
{
    public $clients = [];
    public $clientTypes = [];
    public $client_id; 
    public $selectedClient; 
    public $clientBookings = []; 
    public $clientServices = []; 
    public $clientTypeCount = [];

    public function mount()
    {
        $this->clients = Client::get();
    }

    public function fetchClientData()
    {
        if ($this->client_id) {
            $this->selectedClient = Client::find($this->client_id);

            $this->clientBookings = BookingGroup::with([
                    'booking', 
                    'currency', 
                    'booking_group_members.client_type', 
                    'booking_group_services'
                ])
                ->where('client_id', $this->client_id)
                ->withCount('booking_group_services')
                ->get();

            $this->clientServices = BookingGroupService::with(['booking', 'currency', 'extra_service', 'client', 'booking_group'])
                ->whereHas('client', function ($q) {
                    $q->where('client_id', $this->client_id);
                })
                ->get();

            $this->clientTypes = collect();

            $this->clientBookings->each(function ($booking) {
                foreach ($booking->booking_group_members as $member) {
                    $this->clientTypes->put($member->client_type_id, $member->client_type);
                }
            });
            
            $this->calculateCounts();
        } else {
            $this->selectedClient = null;
            $this->clientBookings = [];
            $this->clientServices = [];
            $this->clientTypeCount = [];
        }
    }

    protected function calculateCounts()
    {
        $this->clientTypeCount = [];

        foreach ($this->clientBookings as $booking) {
            $clientTypeCounts = $this->clientTypes->pluck('name', 'id')->map(function () {
                return 0;
            })->toArray();

            foreach ($booking->booking_group_members as $member) {
                if (isset($clientTypeCounts[$member->client_type_id])) {
                    $clientTypeCounts[$member->client_type_id] += $member->members_count;
                }
            }

            $this->clientTypeCount[$booking->id] = $clientTypeCounts;
        }
    }

    public function exportPdf()
    {
        session()->put('reportData', [
            'clientBookings'  => $this->clientBookings,
            'selectedClient'  => $this->selectedClient,
            'clientServices'  => $this->clientServices,
            'clientTypes'     => $this->clientTypes,
            'clientTypeCount' => $this->clientTypeCount,
        ]);
        session()->put('view', 'admin.pages.reports.print.detailed-clients-report');
        session()->put('title', __('Detailed Clients Report'));
        session()->put('format', 'A4-L');
        $pdfUrl = route(auth()->getDefaultDriver().'.print-report');
        $this->dispatch('openPdf', ['url' => $pdfUrl]);
    }

    public function exportExcel()
    {
        $clientBookings = $this->clientBookings->map(function ($booking) {
                $row = [
                    $booking->booking->booking_date->format('Y-m-d') . ' - ' . $booking->booking->start_time->format('H:i'),
                    ($booking->booking->type->name ?? '-') . ' (' . __(BOOKING_TYPES[$booking->booking->booking_type]) . ')',
                    $booking->hour_member_price . ' ' . $booking->currency->symbol,
                    $booking->booking_group_num,
                ];
                foreach ($this->clientTypes as $clientType) {
                    $row[] = $this->clientTypeCount[$booking->id][$clientType->id] ?? 0;
                }
                $row[] = $booking->total_members;
                return $row;
            })->toArray();
        if (empty($clientBookings)) {
            $clientBookings = [[__('No records found')]];
        }

        $clientServices = $this->clientBookings->map(function ($group) {
            return $group->booking_group_services->map(function ($service, $index) use ($group) {
                $row = [];
                if ($index == 0) {
                    $row[] = $group->booking->booking_date->format('Y-m-d') . ' - ' . 
                            $group->booking->start_time->format('H:i') . ' ' .
                            ($group->booking->type->name ?? '-') . ' ' .
                            '(' . __(BOOKING_TYPES[$group->booking->booking_type]) . ')';
                } else {
                    $row[] = null; 
                }
                $row[] = isset($service->extra_service->parent->name) 
                        ? ($service->extra_service->parent->name . ' (' . $service->extra_service->name . ')')
                        : $service->extra_service->name;
                $row[] = $service->booking_group_service_num;
                $row[] = $service->services_count;
                $row[] = $service->price . ' ' . $service->currency_symbol;
                $row[] = $service->paid . ' ' . $service->currency_symbol;
                $row[] = $service->remain . ' ' . $service->currency_symbol;
                return $row;
            });
        })->flatten(1)->toArray(); 

        if (empty($clientServices)) {
            $clientServices = [[__('No records found'), '', '', '', '', '', '']];
        }

        $tables = [
            [
                'title' => __('Client Data'),
                'headings' => [
                    __('Name'),
                    __('Phone'),
                    __('Mobile'),
                    __('Country'),
                    __('Area'),
                    __('City')
                ],
                'data' => [
                    [
                        __('Name') => $this->selectedClient->name,
                        __('Phone') => $this->selectedClient->phone,
                        __('Mobile') => $this->selectedClient->mobile,
                        __('Country') => $this->selectedClient->country,
                        __('Area') => $this->selectedClient->area,
                        __('City') => $this->selectedClient->city
                    ]
                ],
            ],
            [
                'title' => __('Bookings'),
                'headings' => array_merge(
                    [
                        __('Booking Date&Time'),
                        __('Type'),
                        __('Hourly Price'),
                        __('Serial No.'),
                    ],
                    $this->clientTypes->pluck('name')->toArray(),
                    [
                        __('Total Members')
                    ]
                ),
                'data' => $clientBookings,
            ],
            [
                'title' => __('Extra Services'),
                'headings' => [
                    __('Booking Date&Time'),
                    __('Name'),
                    __('Serial No.'),
                    __('Number'),
                    __('Price'),
                    __('Paid'),
                    __('Remain')
                ],
                'data' => $clientServices,
            ],
        ];

        return Excel::download(new MultiTableExport($tables, __('Detailed Clients Report')), 'detailed_clients_report.xlsx');
    }

    public function render()
    {
        return view('admin.livewire.reports.detailed-clients-report');
    }
}