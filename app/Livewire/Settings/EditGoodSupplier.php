<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

class EditGoodSupplier extends Component
{
    public $modalData = null;
    public $name = '';
    public $phone = '';

    public function resetModalData()
    {
        $this->reset(['modalData']);
    }

    #[On('openModal')]
    public function openModal($id)
    {
        $this->resetModalData();
        $this->dispatch('resetLanguageData');
        $dataRepository = App::make('GoodSupplierCrudRepository');
        $this->modalData = $dataRepository->findById($id);
        $this->name = $this->modalData->name;
        $this->phone = $this->modalData->phone;
        $this->dispatch('modalShow');
    }

    public function render(): View
    {
        return view('admin.livewire.settings.edit-good-supplier');
    }
}
