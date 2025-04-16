<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use App\RepositoryInterface\BookingGroupRepositoryInterface;

class BookingGroupDetails extends Component
{
    protected $dataRepository;
    public $modalData = null;

    public function __construct()
    {
        $this->dataRepository = app(BookingGroupRepositoryInterface::class);
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
        $this->dispatch('modalShow');
    }

    public function render(): View
    {
        return view('admin.livewire.booking-group-details');
    }
}
