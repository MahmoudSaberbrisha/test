<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use App\Models\Booking;
use App\Models\BookingGroup;
use App\RepositoryInterface\BookingGroupRepositoryInterface;

class BookingGroupDetails extends Component
{
    protected $dataRepository;
    public $modalData = null;
    public $isGrouped = false;

    public function __construct()
    {
        $this->dataRepository = app(BookingGroupRepositoryInterface::class);
    }

    public function resetModalData()
    {
        $this->reset(['modalData', 'isGrouped']);
    }

    #[On('openModal')]
    public function openModal($id)
    {
        $this->resetModalData();
        $this->modalData = $this->dataRepository->findById($id);
        $this->isGrouped = false;
        $this->dispatch('modalShow');
    }

    #[On('openGroupedModal')]
    public function openGroupedModal($id)
    {
        $this->resetModalData();
        $this->modalData = Booking::with([
            'booking_groups.client',
            'booking_groups.currency',
            'booking_groups.booking_group_members',
            'branch' => fn($q) => $q->withTranslation(),
            'sailing_boat' => fn($q) => $q->withTranslation(),
            'type' => fn($q) => $q->withTranslation()
        ])->find($id);
        $this->isGrouped = true;
        $this->dispatch('modalShow');
    }

    public function render(): View
    {
        return view('admin.livewire.booking-group-details');
    }
}