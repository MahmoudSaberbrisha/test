<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

class EditExpensesType extends Component
{
    public $languageCode = null;
    public $modalData = null;
    public $name = '';

    public function resetModalData()
    {
        $this->reset(['modalData', 'languageCode']);
    }

    #[On('openModal')]
    public function openModal($id)
    {
        $this->resetModalData();
        $this->dispatch('resetLanguageData');
        $this->dispatch('languageSelected', $id);
    }

    #[On('languageSelected')]
    public function loadModalData($languageId)
    {
        $dataRepository = App::make('ExpensesTypeCrudRepository');
        $this->modalData = $dataRepository->findById($languageId);
        if(empty($this->languageCode))
            $this->languageCode = app()->getLocale();
        $this->name = $this->modalData->translateOrNew($this->languageCode)->name;
        $this->dispatch('modalShow');
    }

    #[On('getByLanguage')]
    public function getByLanguage($languageCode)
    {
        $this->languageCode = $languageCode;
        $this->name = $this->modalData->translateOrNew($this->languageCode)->name;
    }

    public function render()
    {
        return view('admin.livewire.settings.edit-expenses-type');
    }
}
