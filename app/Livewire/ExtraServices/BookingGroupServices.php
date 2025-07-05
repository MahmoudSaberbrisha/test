<?php

namespace App\Livewire\ExtraServices;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use App\RepositoryInterface\BookingRepositoryInterface;
use App\RepositoryInterface\BookingGroupRepositoryInterface;
use App\RepositoryInterface\BookingGroupServicesInterface;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use App\RepositoryInterface\ExtraServicesInterface;
use App\Models\BookingGroupService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class BookingGroupServices extends Component
{
    private $extraServiceRepository, $paymentMethodRepository, $bookingRepository, $extraServicesRepository, $currencyRepository;

    public
        $booking_group_id,
        $bookingGroups = [],
        $paymentMethods = [],
        $extraServices = [],
        $currencies = [],
        $defaultCurrency = null,
        $booking = null,
        $services = [];

    public function __construct()
    {
        $this->extraServicesRepository = app(BookingGroupServicesInterface::class);
        $this->extraServiceRepository = app(ExtraServicesInterface::class);
        $this->currencyRepository = app(CurrencyRepositoryInterface::class);
        $this->paymentMethodRepository = App::make('PaymentMethodCrudRepository');
        $this->bookingRepository = app(BookingRepositoryInterface::class);
        $this->bookingGroupRepository = app(BookingGroupRepositoryInterface::class);
    }

    public function mount($booking_group_id = null)
    {
        $this->paymentMethods = $this->paymentMethodRepository->getActiveRecords();
        $this->extraServices = $this->extraServiceRepository->getActiveParents();
        $this->currencies = $this->currencyRepository->getActiveRecords();
        $this->defaultCurrency = $this->currencyRepository->getDefaultCurrency();
        $this->bookingGroups = $this->extraServicesRepository->getBookingsWithoutServices();
        if ($booking_group_id) {
            $services = $this->extraServicesRepository->findById($booking_group_id);
            foreach ($services as $key => $service) {
                $this->services[$key] = [
                    'count' => $service->services_count,
                    'extra_service_id' => $service->extra_service_id,
                    'price' => $service->price,
                    'total' => $service->total,
                    'currency_id' => $service->currency_id,
                    'payments' => [],
                ];
                foreach ($service->payments as $paymentKey => $payment) {
                    $this->services[$key]['payments'][] = [
                        'amount' => $payment->paid,
                        'method' => $payment->payment_method_id
                    ];
                }
            }
            $this->bookingGroups = [$services->first()->booking_group];
            $this->booking_group_id = $booking_group_id;
            $this->getBookingData();
        } else {
            $this->services[] = [
                'count' => 1,
                'extra_service_id' => null,
                'price' => 0,
                'total' => 0,
                'currency_id' => $this->defaultCurrency->id,
                'payments' => [],
            ];
        }
        if (session()->has('print_pdf')) {
            $this->booking_group_id = $booking_group_id;
        }
    }

    public function getBookingData()
    {
        $this->booking = $this->bookingGroupRepository->findById($this->booking_group_id);
    }

    public function addService()
    {
        $this->services[] = [
            'count' => 1,
            'extra_service_id' => null,
            'price' => 0,
            'total' => 0,
            'currency_id' => $this->defaultCurrency->id,
            'payments' => [],
        ];
    }

    public function updateTotalPrice($index)
    {
        if ($this->services[$index]['count'] <= 0)
            return $this->removeService($index);
        $this->services[$index]['total'] = $this->services[$index]['price'] * $this->services[$index]['count'];
        $this->validatePayments($index);
    }

    public function getSelectedServiceIds($index)
    {
        return array_column(array_filter($this->services, fn($s, $key) => !is_null($s['extra_service_id']) && $key !== $index, ARRAY_FILTER_USE_BOTH), 'extra_service_id');
    }

    public function checkDoubleService($index)
    {
        $servicesIds = $this->getSelectedServiceIds($index);
        if (in_array($this->services[$index]['extra_service_id'], $servicesIds)) {
            $this->alertMessage(__('This service is already selected.'), 'error');
            return $this->services[$index]['extra_service_id'] = null;
        }
    }

    public function removeService($index)
    {
        unset($this->services[$index]);
        $this->services = array_values($this->services);
    }

    public function updatePaymentAmount($serviceIndex)
    {
        $this->validatePayments($serviceIndex);
    }

    private function validatePayments($serviceIndex)
    {
        $totalServicePrice = $this->services[$serviceIndex]['total'];
        $paidAmount = $this->getPaidAmount($serviceIndex);

        if ($paidAmount >= $totalServicePrice) {
            $this->adjustPayments($serviceIndex);
        }
    }

    private function adjustPayments($serviceIndex)
    {
        $totalServicePrice = $this->services[$serviceIndex]['total'];
        $currentPaid = 0;

        foreach ($this->services[$serviceIndex]['payments'] as $index => &$payment) {
            if ($currentPaid + $payment['amount'] > $totalServicePrice) {
                $payment['amount'] = max(0, $totalServicePrice - $currentPaid);
            }
            $currentPaid += $payment['amount'];
        }

        $this->services[$serviceIndex]['payments'] = array_filter($this->services[$serviceIndex]['payments'], function ($payment) {
            return $payment['amount'] > 0;
        });

        $this->services[$serviceIndex]['payments'] = array_values($this->services[$serviceIndex]['payments']);
    }

    private function getPaidAmount($serviceIndex)
    {
        return array_sum(array_column($this->services[$serviceIndex]['payments'], 'amount'));
    }

    public function addPaymentMethod($serviceIndex)
    {
        if ($this->getPaidAmount($serviceIndex) < $this->services[$serviceIndex]['total']) {
            $this->services[$serviceIndex]['payments'][] = [
                'method' => null,
                'amount' => 0,
            ];
        }
    }

    public function removePaymentMethod($serviceIndex, $paymentIndex)
    {
        unset($this->services[$serviceIndex]['payments'][$paymentIndex]);
        $this->services[$serviceIndex]['payments'] = array_values($this->services[$serviceIndex]['payments']);
    }

    public function checkPaymentMethod($serviceIndex, $paymentIndex)
    {
        $existingMethods = array_column(
            array_filter($this->services[$serviceIndex]['payments'], fn($p, $i) => $i !== $paymentIndex, ARRAY_FILTER_USE_BOTH),
            'method'
        );

        if (in_array($this->services[$serviceIndex]['payments'][$paymentIndex]['method'], $existingMethods)) {
            $this->services[$serviceIndex]['payments'][$paymentIndex]['method'] = null;
            $this->alertMessage(__('This payment method is already selected.'), 'error');
        }
    }

    public function alertMessage($message, $type)
    {
        $this->dispatch(
            'alert',
            ['type' => $type,  'message' => $message]
        );
    }

    public function render(): View
    {
        return view('admin.livewire.extra-services.booking-group-services');
    }
}