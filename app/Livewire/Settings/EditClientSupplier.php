<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

class EditClientSupplier extends Component
{
    public $modalData = null;
    public $name = '';
    public $value = '';

    public function resetModalData()
    {
        $this->reset(['modalData']);
    }

    #[On('openModal')]
    public function openModal($id)
    {
        $this->resetModalData();
        $dataRepository = App::make('ClientSupplierCrudRepository');
        $this->modalData = $dataRepository->findById($id);
        $this->name = $this->modalData->name;
        $this->value = $this->modalData->value;
        $this->dispatch('modalShow');
    }

    public function render(): View
    {
        return view('admin.livewire.settings.edit-client-supplier');
    }
}
