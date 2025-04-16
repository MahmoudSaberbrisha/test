<?php

namespace App\Livewire\BookingManagement;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use App\RepositoryInterface\BookingRepositoryInterface;

class EditBooking extends Component
{
    private $dataRepository, $boatRepository, $typeRepository;
    public 
        $modalData = null,
        $types,
        $start_time = null,
        $end_time = null,
        $booking_date = null,
        $total_hours = null,
        $boats;

    public function __construct()
    {
        $this->dataRepository = app(BookingRepositoryInterface::class);
        $this->boatRepository = App::make('SailingBoatCrudRepository');
        $this->typeRepository = App::make('TypeCrudRepository');
    }

    public function mount()
    {
        $this->boats = $this->boatRepository->getActiveRecords();
        $this->types = $this->typeRepository->getActiveRecords();
    }

    public function resetModalData()
    {
        $this->reset(['modalData']);
    }

    #[On('openModal')]
    public function openModal($id)
    {
        $this->resetModalData();
        $this->modalData = $this->dataRepository->findById($id);
        $this->start_time = $this->modalData->start_time->format('H:i');
        $this->end_time = $this->modalData->end_time->format('H:i');
        $this->total_hours = $this->modalData->total_hours;
        $this->booking_date = $this->modalData->booking_date->format('Y-m-d');
        $this->dispatch('modalShow');
    }

    public function render(): View
    {
        return view('admin.livewire.booking-management.edit-booking');
    }
}
