<?php

namespace App\Livewire\ClientsManagement;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

class EditClient extends Component
{
    public $modalData = null;

    public function resetModalData()
    {
        $this->reset(['modalData']);
    }

    #[On('openModal')]
    public function openModal($id)
    {
        $this->resetModalData();
        $dataRepository = App::make('ClientCrudRepository');
        $this->modalData = $dataRepository->findById($id);
        $this->dispatch('modalShow');
    }

    public function render(): View
    {
        return view('admin.livewire.clients-management.edit-client');
    }
}
