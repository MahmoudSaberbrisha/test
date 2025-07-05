<?php

namespace App\Repositories;

use App\RepositoryInterface\BookingRepositoryInterface;
use App\Models\Booking;
use App\Models\BookingMember;
use App\Models\BookingPayment;
use Illuminate\Support\Facades\App;
use DateTime;

class DBBookingsRepository implements BookingRepositoryInterface
{
    private $boatRepository;

    public function __construct()
    {
        $this->boatRepository = App::make('SailingBoatCrudRepository');
    }

    public function getAll()
    {
        return Booking::with([
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
        ])->get();
    }

    public function create(array $request)
    {
        $data['branch_id'] = $this->boatRepository->findById($request['sailing_boat_id'])->branch_id;
        $data['sailing_boat_id'] = $request['sailing_boat_id'];
        $data['booking_type'] = $request['booking_type'];
        $data['type_id'] = $request['type_id'];
        $data['booking_date'] = $request['booking_date'];
        $data['start_time'] = $request['start_time'];
        $data['end_time'] = $request['end_time'];
        $data['total_hours'] = $request['total_hours'];
        unset($data['id']); // Ensure id is not set to avoid duplicate key error
        return Booking::create($data);
    }

    public function findById(int $id)
    {
        return Booking::with([
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
        ])->find($id);
    }

    public function update(int $id, array $request)
    {
        $record = $this->findById($id);
        $data['branch_id'] = $this->boatRepository->findById($request['sailing_boat_id'])->branch_id;
        $data['sailing_boat_id'] = $request['sailing_boat_id'];
        $data['booking_type'] = $request['booking_type'];
        $data['type_id'] = $request['type_id'];
        $data['booking_date'] = $request['booking_date'];
        $data['start_time'] = $request['start_time'];
        $data['end_time'] = $request['end_time'];
        $data['total_hours'] = $request['total_hours'];
        return $record->update($data);
    }

    public function delete(int $id)
    {
        $record = $this->findById($id);
        return $record->delete();
    }

    public function getBookings()
    {
        return Booking::with([
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
        ])
            ->where('booking_type', 'group')
            ->orWhere(function ($q) {
                $q->where('booking_type', 'private')
                    ->whereDoesntHave('booking_groups');
            })
            ->get();
    }
}
