<?php

namespace App\Livewire\BookingManagement;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;
use App\RepositoryInterface\BookingGroupRepositoryInterface;
use App\RepositoryInterface\BookingRepositoryInterface;
use App\Models\BookingGroup;
use App\Models\Client;
use App\Rules\UniqueClientBookingGroup;
use App\RepositoryInterface\EmployeeRepositoryInterface;

class CreateEditBookingGroup extends Component
{
    
    protected $listeners = ['refreshSupplierDropdown' => 'refreshSupplierDropdown'];

    private 
        $currencyRepository, 
        $salesAreaRepository, 
        $clientTypeRepository, 
        $paymentMethodRepository, 
        $bookingGroupRepository,
        $clientRepository,
        $bookingRepository,
        $employeeRepository,
        $supplierRepository;

    public 
        $group,
        $tax = 0,
        $is_taxed = 0,
        $credit_sales = 0,
        $total_after_discount = 0,
        $total_hours = 0,
        $price = 0,
        $discounted = 0,
        $total_members = 0,
        $final_total = 0,
        $total = 0,
        $client_type_id = null,
        $currencies = [], 
        $clientTypes = [],
        $paymentMethods = [],
        $inputs = [],
        $paymentInputs = [],
        $start_time = null,
        $end_time = null,
        $defaultCurrency = null,
        $booking_type = 'group',
        $hour_member_price = 0,
        $bookingGroup = null,
        $remain = 0,
        $editMode = false,
        $bookings = [],
        $booking = null,
        $client_id = null,
        $booking_id,
        $clients = [],
        $supplier_type,
        $suppliers = [],
        $salesAreas = [],
        $employees = [];

    public function __construct()
    {
        $this->currencyRepository = app(CurrencyRepositoryInterface::class);
        $this->bookingRepository = app(BookingRepositoryInterface::class);
        $this->clientTypeRepository = App::make('ClientTypeCrudRepository');
        $this->salesAreaRepository = App::make('SalesAreaCrudRepository');
        $this->paymentMethodRepository = App::make('PaymentMethodCrudRepository');
        $this->bookingGroupRepository = app(BookingGroupRepositoryInterface::class);
        $this->clientRepository = App::make('ClientCrudRepository');
        $this->supplierRepository = App::make('ClientSupplierCrudRepository');
        $this->employeeRepository = app(EmployeeRepositoryInterface::class);
    }

    public function mount($booking_group_id = null)
    {
        $this->bookings = $this->bookingRepository->getBookings();
        $this->currencies = $this->currencyRepository->getActiveRecords();
        $this->salesAreas = $this->salesAreaRepository->getActiveRecords();
        $this->defaultCurrency = $this->currencyRepository->getDefaultCurrency();
        $this->clientTypes = $this->clientTypeRepository->getActiveRecords();
        $this->paymentMethods = $this->paymentMethodRepository->getActiveRecords();
        $this->suppliers = $this->supplierRepository->getActiveRecords();
        $this->employees = $this->employeeRepository->getAll();
        if (session()->get('bookingId') != null) {
            $this->booking_id = session()->get('bookingId');
            $this->getBookingData();
        }
        if ($booking_group_id) {
            session()->forget('bookingId');
            $this->editMode = true;
            $bookingGroup = $this->bookingGroup = $this->bookingGroupRepository->findById($booking_group_id);
            if ($bookingGroup) {
                $this->bookings = [$this->bookingRepository->findById($bookingGroup->booking_id)];
                $this->supplier_type = $bookingGroup->supplier_type;
                $this->changeSupplierType();
                $this->booking_id = $bookingGroup->booking_id;
                $this->client_id = $bookingGroup->client_id;
                $this->booking_type = $bookingGroup->booking->booking_type;
                $this->total_hours = $bookingGroup->booking->total_hours;
                $this->hour_member_price = $bookingGroup->hour_member_price;
                $this->price = $bookingGroup->price;
                $this->total_after_discount = $bookingGroup->total_after_discount;
                $this->tax = $bookingGroup->tax;
                $this->credit_sales = $bookingGroup->credit_sales;
                $this->changeIsTaxed($bookingGroup->is_taxed);
                $this->calcDecimalHours();
                $this->updateHourPrice();
                $this->getBookingData();
                foreach ($bookingGroup->booking_group_members as $key => $members) {
                    $this->inputs[$members->client_type_id] = [
                        'members_count' => $members->members_count, 
                        'client_type_id' => $members->client_type_id, 
                        'discount_type' => $members->discount_type, 
                        'discount_value' => $members->discount_value, 
                        'member_price' => $members->member_price,
                        'member_total_price' => $members->member_total_price
                    ];
                }
                foreach ($bookingGroup->booking_group_payments as $key => $payment) {
                    if ($key == 0) {
                        $this->fill([
                            'paymentInputs' => collect([['payment_method_id' => $payment->payment_method_id, 'paid' => $payment->paid]]),
                        ]);
                    } else {
                        $this->paymentInputs->push(['payment_method_id' => $payment->payment_method_id, 'paid' => $payment->paid]);
                    }
                }
                $this->discounted = $bookingGroup->discounted;
                $this->updateBookingType();
            }
        }
        $this->getClients();
    }

    public function addPaymentInput()
    {
        if (empty($this->paymentInputs))
            $this->fill([
                'paymentInputs' => collect([['payment_method_id' => '', 'paid' => 0.00]]),
            ]);
        else
            $this->paymentInputs->push(['payment_method_id' => '', 'paid' => 0.00]);
    }

    public function removePaymentInput($key)
    {
        $this->paymentInputs->pull($key);
        $this->paymentInputs = $this->paymentInputs->values();
    }

    public function resetComponentData()
    {
        $this->reset(['client_type_id', 'booking', 'booking_type']);
    }

    public function addInput()
    {
        if ( ($this->client_type_id && $this->hour_member_price) && (($this->total_hours && $this->booking_type == 'private') || $this->booking_type == 'group') ) {
            $client_type = $this->getClientType($this->client_type_id);
            if (isset($this->inputs[$this->client_type_id])) {
                $this->inputs[$this->client_type_id]['members_count']++;
            } else {
                $this->inputs[$this->client_type_id] = [
                    'members_count' => 1, 
                    'client_type_id' => $this->client_type_id, 
                    'discount_type' => $client_type->discount_type, 
                    'discount_value' => $client_type->discount_value, 
                    'member_price' => 0.00,
                    'member_total_price' => 0.00
                ];
            }
            $this->updateTotalPrice($this->client_type_id);
            if (empty($this->paymentInputs))
                $this->fill([
                    'paymentInputs' => collect([['payment_method_id' => '', 'paid' => 0.00]]),
                ]);
        } elseif (!$this->client_type_id) {       
            return $this->alertMessage( __('Choose type first.'), 'error');
        } elseif (!$this->hour_member_price) {
            if ($this->booking_type == 'group')
                return $this->alertMessage( __('Specify memeber price.'), 'error');
            else
                return $this->alertMessage( __('Specify the price per hour of booking.'), 'error');
        } elseif (!$this->total_hours && $this->booking_type == 'private'){
            return $this->alertMessage( __('Specify booking hours.'), 'error');
        }
    }

    public function calculateMemberPrice($hour_member_price, $discountType, $discount_value)
    {
        if ($discountType === 'percentage') {
            return $hour_member_price - ($hour_member_price * ($discount_value / 100));
        } elseif ($discountType === 'fixed') {
            return max(0, $hour_member_price - $discount_value);
        }

        return $hour_member_price;
    }

    public function changeClientType($key)
    {
        $newKey = $this->inputs[$key]['client_type_id'];
        $client_type = $this->getClientType($newKey);
        if (isset($this->inputs[$newKey]) && count($this->inputs[$newKey]) == 6) {
            $this->inputs[$newKey]['members_count'] += $this->inputs[$key]['members_count'];
        } else {
            $this->inputs[$newKey] = $this->inputs[$key];
        }
        $this->inputs[$newKey]['discount_type'] = $client_type->discount_type;
        $this->inputs[$newKey]['discount_value'] = $client_type->discount_value;
        $this->removeInput($key);
        $this->updateTotalPrice($newKey);
    }

    public function getClientType($key)
    {
        return $this->clientTypeRepository->findById($key);
    }

    public function updateTotalPrice($key = null)
    {
        $payingMembers = 0;
        foreach ($this->inputs as $index => $input) {
            if (count($input) == 6) {
                if (!($input['discount_type'] == 'percentage' && $input['discount_value'] == 100)) {
                    $payingMembers += $input['members_count'];
                }
            } else {
                unset($this->inputs[$index]);
            }
        }

        if ($this->booking_type == 'group')
            $this->price = $this->total_members * $this->hour_member_price;

        if ($key) {
            if (!isset($this->inputs[$key])) {
                return;
            }

            if ($this->inputs[$key]['members_count'] == 0 || $this->inputs[$key]['members_count'] == null)
                return $this->removeInput($key);

            if (!is_numeric($this->inputs[$key]['member_price'])) {
                $this->inputs[$key]['member_price'] = 0;
            }

            $member_price = $this->calculateMemberPrice($this->hour_member_price, $this->inputs[$key]['discount_type'], $this->inputs[$key]['discount_value']);
            $this->inputs[$key]['member_price'] = $member_price;
            $this->inputs[$key]['member_total_price'] = $this->inputs[$key]['member_price'] * $this->inputs[$key]['members_count'];
        } else {
            foreach ($this->inputs as $index => $input) {
                if (count($input) == 6) {
                    $this->updateTotalPrice($index);
                } else {
                    unset($this->inputs[$index]);
                }
            }
        }
    }

    public function removeInput($key)
    {
        unset($this->inputs[$key]);
        $this->updateTotalPrice();
    }

    public function updateTotals()
    {
        if (! is_numeric($this->discounted)) {
            $this->discounted = 0;
        }
        if ($this->inputs) {
            $this->total_members = collect($this->inputs)->sum('members_count');
            if ($this->booking_type == 'group') {
                $this->total = collect($this->inputs)->sum('member_total_price');
            } else {
                $this->total = $this->price;
            }
            $this->total_after_discount = $this->total - $this->discounted;
            $this->tax = 0;
            if ($this->is_taxed) {
                $this->tax =  round($this->total_after_discount * 0.14, 2);
            }
            $this->final_total = $this->tax + $this->total_after_discount;
        }
        if ($this->final_total < 0) {
            $this->final_total = $this->tax = 0;
        }
    }

    public function updateHourPrice()
    {
        if (is_numeric($this->hour_member_price) && $this->hour_member_price != 0) {
            $this->price = $this->hour_member_price * $this->total_hours;
            $this->updateTotalPrice();
        } elseif (!is_numeric($this->hour_member_price) || $this->hour_member_price == 0) {
            $this->hour_member_price = 0;
            $this->inputs = [];
            $this->paymentInputs = [];
            $this->price = 0;
        }
    }

    public function calcDecimalHours()
    {
        list($hours, $minutes) = explode(':', $this->total_hours);
        $this->total_hours = round(($hours + ($minutes / 60)), 2);
    }

    public function alertMessage($message, $type)
    {
        $this->dispatch(
            'alert',
            ['type' => $type,  'message' => $message]
        );
    }

    public function updateRemain($key = null)
    {
        $remain = $this->final_total - collect($this->paymentInputs)->sum('paid');
        $count = $this->paymentInputs?$this->paymentInputs->count():0;
        if ($remain < 0) {
            $this->paymentInputs = $this->paymentInputs->map(function ($item, $index) use ($key, $count) {
                $isLast = $index === ($count - 1);
                if ($key == $index) {
                    $item['paid'] = $this->remain; 
                }
                if ($key === null && !$isLast) {
                    return null; 
                }
                return $item;
            })->filter();
            $this->remain = 0;
            return $this->alertMessage(__('The amount paid exceeded the required amount.'), 'error');
        }
        $this->remain = $remain;
    }

    public function checkPaymentMethod($index)
    {
        $selectedPaymentMethod = $this->paymentInputs[$index]['payment_method_id'];
        $exists = $this->paymentInputs->where('payment_method_id', $selectedPaymentMethod)->count() > 1;
        if ($exists) {
            $this->paymentInputs = $this->paymentInputs->map(function ($item, $key) use ($index) {
                if ($key == $index) {
                    $item['payment_method_id'] = ''; 
                }
                return $item;
            });
            $this->alertMessage(__('This payment method is already selected.'), 'error');
        }
    }

    public function updateBookingType()
    {
        if ($this->booking_type == 'private') {
            $this->price = $this->hour_member_price * $this->total_hours;
            $this->total = $this->price;
        }
    }

    public function getBookingData()
    {
        $this->resetComponentData();
        $this->booking = $this->bookingRepository->findById($this->booking_id);
        if ($this->booking) {
            $this->booking_type = $this->booking->booking_type;
            $this->total_hours = $this->booking->total_hours;
            $this->calcDecimalHours();
        } else {
            session()->forget('bookingId');
            $this->booking_id = null;
        }
    }

    public function getClients()
    {
        if ($this->booking_id) {
            $clientIds = BookingGroup::where('booking_id', $this->booking_id)->pluck('client_id')->toArray();
            if (!$this->editMode) {
                $this->clients = $this->clientRepository->getActiveRecords()->whereNotIn('id', $clientIds);
            } else {
                $this->clients = Client::where('active', 1)
                    ->whereNotIn('id', $clientIds)
                    ->orWhere('id', $this->client_id)
                    ->get();
            }
        } else
            $this->clients = $this->clientRepository->getActiveRecords();
    }

    public function checkClientValidation()
    {
        if ($this->client_id && $this->booking_id) {
            $rule = new UniqueClientBookingGroup($this->client_id, $this->booking_id);
            if (!$rule->passes()) {
                $this->client_id = null;
                $this->dispatch('clearClientSelect2');
                return $this->alertMessage( $rule->message(), 'error');
            }
        }
    }

    public function changeSupplierType()
    {
        if ($this->supplier_type == "App\Models\EmployeeManagement\Employee") {
            $this->suppliers = $this->employeeRepository->getAll();
        } elseif ($this->supplier_type == "App\Models\ClientSupplier") {
            $this->suppliers = $this->supplierRepository->getAll();
        }
    }

    public function changeIsTaxed($value)
    {
        $this->is_taxed = $value;
    }

    public function render(): View
    {
        $this->updateTotals();
        $this->updateRemain();
        $this->dispatch('initSelect2Drop');
        $this->dispatch('bookingTypeChanged', $this->booking_type);
        return view('admin.livewire.booking-management.create-edit-booking-group');
    }
}
