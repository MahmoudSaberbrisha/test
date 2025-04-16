<?php

namespace App\Repositories;

use App\RepositoryInterface\BookingGroupRepositoryInterface;
use App\Models\BookingGroup;
use App\Models\BookingGroupMember;
use App\Models\BookingGroupPayment;
use Illuminate\Support\Facades\App;
use App\RepositoryInterface\EmployeeRepositoryInterface;

class DBBookingGroupsRepository implements BookingGroupRepositoryInterface
{
    private $clientSupplierRepository;

    public function __construct()
    {
        $this->clientSupplierRepository = App::make('ClientSupplierCrudRepository');
        $this->employeeRepository = app(EmployeeRepositoryInterface::class);
    }

    public function getAll()
    {
        return BookingGroup::with([
            "feed_backs",
            "booking",
            "client",
            "booking_group_members",
            "booking_group_payments",
            "booking_group_services",
            "client_supplier",
            "currency" => function ($query) {
                $query->withTranslation(); 
            },
            "sales_area" => function ($query) {
                $query->withTranslation(); 
            }
        ])->get();
    }

    public function create(array $request)
    {
        if( $request['supplier_type'] == "App\Models\ClientSupplier") {
            $clientSupplier = $this->clientSupplierRepository->findById($request['client_supplier_id']);
            $client_supplier_value = $clientSupplier ? $clientSupplier->value : 0.00;
        } else {
            $employee = $this->employeeRepository->findById($request['client_supplier_id']);
            $client_supplier_value = $employee ? $employee->commission_rate : 0.00;
        }
        $data['booking_id'] = $request['booking_id'];
        $data['sales_area_id'] = $request['sales_area_id'];
        $data['supplier_type'] = $request['supplier_type'];
        $data['client_id'] = $request['client_id'];
        $data['client_supplier_id'] = $request['client_supplier_id'];
        $data['client_supplier_value'] = $client_supplier_value;
        $data['currency_id'] = $request['currency_id'];
        $data['hour_member_price'] = $request['hour_member_price'];
        $data['price'] = $request['total'];
        $data['discounted'] = $request['discounted'];
        $data['total_after_discount'] = $request['total_after_discount'];
        $data['tax'] = $request['tax']??0.00;
        $data['total'] = $request['final_total'];
        $data['notes'] = $request['notes'];
        $data['description'] = $request['description'];
        $data['is_taxed'] = $request['is_taxed'];
        $data['out_marina'] = $request['out_marina'];
        $data['credit_sales'] = $request['credit_sales'];
        $bookingGroup = BookingGroup::create($data);
        $this->createBookingGroupMembers($bookingGroup->id, $request);
        if ($request['credit_sales'] == 0)
            $this->createBookingGroupPayments($bookingGroup->id, $request);
        return $bookingGroup;
    }

    public function findById(int $id)
    {
        return BookingGroup::with([
            "feed_backs",
            "booking",
            "client",
            "booking_group_members",
            "booking_group_payments",
            "booking_group_services",
            "client_supplier",
            "currency" => function ($query) {
                $query->withTranslation(); 
            },
            "sales_area" => function ($query) {
                $query->withTranslation(); 
            }
        ])->findOrFail($id);
    }

    public function update(int $id, array $request)
    {
        $record = $this->findById($id);
        if( $request['supplier_type'] == "App\Models\ClientSupplier") {
            $clientSupplier = $this->clientSupplierRepository->findById($request['client_supplier_id']);
            $client_supplier_value = $clientSupplier ? $clientSupplier->value : 0.00;
        } else {
            $employee = $this->employeeRepository->findById($request['client_supplier_id']);
            $client_supplier_value = $employee ? $employee->commission_rate : 0.00;
        }
        $data['booking_id'] = $request['booking_id'];
        $data['sales_area_id'] = $request['sales_area_id'];
        $data['supplier_type'] = $request['supplier_type'];
        $data['client_id'] = $request['client_id'];
        $data['client_supplier_id'] = $request['client_supplier_id'];
        $data['client_supplier_value'] = $client_supplier_value;
        $data['currency_id'] = $request['currency_id'];
        $data['hour_member_price'] = $request['hour_member_price'];
        $data['price'] = $request['total'];
        $data['discounted'] = $request['discounted'];
        $data['total_after_discount'] = $request['total_after_discount'];
        $data['tax'] = $request['tax']??0.00;
        $data['total'] = $request['final_total'];
        $data['notes'] = $request['notes'];
        $data['description'] = $request['description'];
        $data['is_taxed'] = $request['is_taxed'];
        $data['out_marina'] = $request['out_marina'];
        $data['credit_sales'] = $request['credit_sales'];
        $record->update($data);
        $record->booking_group_members()->delete();
        $record->booking_group_payments()->delete();
        $this->createBookingGroupMembers($id, $request);
        if ($request['credit_sales'] == 0)
            $this->createBookingGroupPayments($id, $request);
        return $record;
    }

    public function delete(int $id)
    {
        $record = $this->findById($id);
        return $record->delete();
    }

    public function active(int $id, string $value)
    {
        $record = $this->findById($id);
        if (!$record)
            return response()->json( array('type' => 'error', 'text' => __('Something went wrong during the process.')) );
        $record->active = ($value == 'true') ? 1 : 0;
        $record->save();
        if ($value == 'true') 
            return response()->json( array('type' => 'success', 'text' => __('Booking confirmed successfully.')) );
        return response()->json( array('type' => 'success', 'text' => __('Booking confirmation has been cancelled.')) );
    }

    public function createBookingGroupMembers(int $bookingGroupId, array $request)
    {
        foreach ($request['members_count'] as $key => $members_count) {
            $data = [];
            $data['booking_id'] = $request['booking_id'];
            $data['booking_group_id'] = $bookingGroupId;
            $data['client_type_id'] = $request['client_type_id'][$key];
            $data['members_count'] = $members_count;
            $data['discount_type'] = $request['discount_type'][$key]??0.00;
            $data['discount_value'] = $request['discount_value'][$key]??0.00;
            $data['member_price'] = $request['member_price'][$key]??0.00;
            $data['member_total_price'] = $request['member_total_price'][$key]??0.00;
            BookingGroupMember::create($data);
        }
    }

    public function createBookingGroupPayments(int $bookingGroupId, array $request)
    {
        foreach ($request['payment_method_id'] as $key => $payment_method_id) {
            $data = [];
            $data['booking_id'] = $request['booking_id'];
            $data['booking_group_id'] = $bookingGroupId;
            $data['payment_method_id'] = $payment_method_id;
            $data['paid'] = $request['paid'][$key];
            BookingGroupPayment::create($data);
        }
    }

}
