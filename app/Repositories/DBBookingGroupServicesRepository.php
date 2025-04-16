<?php

namespace App\Repositories;

use App\RepositoryInterface\BookingGroupServicesInterface;
use App\Models\BookingGroupService;
use App\Models\BookingGroupServicePayment;
use App\Models\BookingGroup;
use App\Repositories\DBBookingGroupsRepository;

class DBBookingGroupServicesRepository implements BookingGroupServicesInterface
{
    private $bookingGroupsRepository;

    public function __construct()
    {
        $this->bookingGroupsRepository = app(DBBookingGroupsRepository::class);
    }

    public function getAll()
    {
        return BookingGroupService::with([
                'booking_group',
                'currency',
                'booking',
                'branch',
                'extra_service',
                'payments'
            ])
            ->get();
    }

    public function create(array $request)
    {
        $bookingGroup = $this->bookingGroupsRepository->findById($request['booking_group_id']);
        $branch_id = $bookingGroup->booking->branch_id;
        foreach ($request['services'] as $key => $service) {
            $data = [
                'booking_id' => $bookingGroup->booking_id,
                'branch_id' => $branch_id,
                'booking_group_id' => $request['booking_group_id'],
                'services_count' => $service['services_count'],
                'extra_service_id' => $service['extra_service_id'],
                'currency_id' => $service['currency_id'],
                'price' => $service['price'],
                'total' => $service['total'],
            ];
            $groupService = BookingGroupService::create($data);
            if (isset($service['payments'])) {
                foreach ($service['payments'] as $payment) {
                    $paymentData = [
                        'booking_group_service_id' => $groupService->id,
                        'payment_method_id' => $payment['payment_method_id'],
                        'paid' => $payment['paid'],
                    ];
                    BookingGroupServicePayment::create($paymentData);
                }
            }
        }
        return $request['booking_group_id'];
    }

    public function findById($id)
    {
        return BookingGroupService::where('booking_group_id', $id)
            ->with([
                'payments',
                'extra_service',
                'currency'
            ])->get();
    }

    public function update(array $request)
    {
        $extraServiceIdsInRequest = collect($request['services'])->pluck('extra_service_id')->toArray();
        BookingGroupService::where('booking_group_id', $request['booking_group_id'])
            ->whereNotIn('extra_service_id', $extraServiceIdsInRequest)
            ->delete();

        $bookingGroup = $this->bookingGroupsRepository->findById($request['booking_group_id']);
        $branch_id = $bookingGroup->booking->branch_id;

        foreach ($request['services'] as $service) {
            $groupService = BookingGroupService::updateOrCreate(
                    [
                        'booking_group_id' => $request['booking_group_id'],
                        'extra_service_id' => $service['extra_service_id'],
                    ],
                    [
                        'booking_id' => $bookingGroup->booking_id,
                        'branch_id' => $branch_id,
                        'booking_group_id' => $request['booking_group_id'],
                        'extra_service_id' => $service['extra_service_id'],
                        'services_count' => $service['services_count'],
                        'price' => $service['price'],
                        'total' => $service['total'],
                        'currency_id' => $service['currency_id'],
                    ]
                );
            $groupService->payments()->delete();
            if (isset($service['payments'])) {
                foreach ($service['payments'] as $payment) {
                    $paymentData = [
                        'booking_group_service_id' => $groupService->id,
                        'payment_method_id' => $payment['payment_method_id'],
                        'paid' => $payment['paid'],
                    ];
                    BookingGroupServicePayment::create($paymentData);
                }
            }
        }
        return $request['booking_group_id'];
    }

    public function delete(int $id)
    {
        return BookingGroupService::where('booking_group_id', $id)->delete();
    }

    public function deleteService(int $id)
    {
        return $this->findOneService($id)->delete();
    }

    public function findOneService($id)
    {
        return BookingGroupService::with([
                'booking_group',
                'currency',
                'booking',
                'branch',
                'extra_service',
                'payments'
            ])->find($id);
    }

    public function getBookingsWithoutServices()
    {
        return BookingGroup::whereDoesntHave('booking_group_services')
            ->where('active', 1)
            ->with([
                'booking'
            ])
            ->get();
    }
}
