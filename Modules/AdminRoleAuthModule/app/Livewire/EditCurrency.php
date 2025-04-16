<?php

namespace Modules\AdminRoleAuthModule\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Modules\AdminRoleAuthModule\RepositoryInterface\CurrencyRepositoryInterface;

class EditCurrency extends Component
{
    public $languageCode = null;
    public $modalData = null;
    public $name = '';
    public $color = '';

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
        $dataRepository = app(CurrencyRepositoryInterface::class);
        $this->modalData = $dataRepository->findById($languageId);
        if(empty($this->languageCode))
            $this->languageCode = app()->getLocale();
        $this->name = $this->modalData->translateOrNew($this->languageCode)->name;
        $this->color = $this->modalData->color;
        $this->dispatch('modalShow');
    }

    #[On('getByLanguage')]
    public function getByLanguage($languageCode)
    {
        $this->languageCode = $languageCode;
        $this->name = $this->modalData->translateOrNew($this->languageCode)->name;
    }

    public function render(): View
    {
        return view('adminroleauthmodule::livewire.edit-currency');
    }
}
