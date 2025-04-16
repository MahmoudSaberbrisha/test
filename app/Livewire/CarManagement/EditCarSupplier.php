<?php

namespace App\Livewire\CarManagement;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

class EditCarSupplier extends Component
{
    public $modalData = null;
    public $name = '';

    public function resetModalData()
    {
        $this->reset(['modalData']);
    }

    #[On('openModal')]
    public function openModal($id)
    {
        $this->resetModalData();
        $this->dispatch('resetLanguageData');
        $this->loadModalData($id);
    }

    public function loadModalData($id)
    {
        $dataRepository = App::make('CarSupplierCrudRepository');
        $this->modalData = $dataRepository->findById($id);
        $this->name = $this->modalData->name;
        $this->dispatch('modalShow');
    }

    public function render(): View
    {
        return view('admin.livewire.car-management.edit-car-supplier');
    }
}