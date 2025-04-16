<?php

namespace Modules\AdminRoleAuthModule\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Modules\AdminRoleAuthModule\RepositoryInterface\LanguagesRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

class EditLanguage extends Component
{
    public $languages;
    public $languageCode = null;
    public $languageData = null;
    public $name = '';

    public function resetModalData()
    {
        $this->reset(['languageData', 'languageCode']);
    }

    #[On('openModal')]
    public function editLanguage($id)
    {
        $this->resetModalData();
        $this->dispatch('resetLanguageData');
        $this->dispatch('languageSelected', $id);
    }

    #[On('languageSelected')]
    public function loadLanguageData($languageId)
    {
        $languageRepository = App::make(LanguagesRepositoryInterface::class);
        $this->languageData = $languageRepository->findById($languageId);
        if(empty($this->languageCode))
            $this->languageCode = app()->getLocale();
        $this->name = $this->languageData->translateOrNew($this->languageCode)->name;
        $this->dispatch('modalShow');
    }

    #[On('getByLanguage')]
    public function getByLanguage($languageCode)
    {
        $this->languageCode = $languageCode;
        $this->name = $this->languageData->translateOrNew($this->languageCode)->name;
    }

    public function render(): View
    {
        return view('adminroleauthmodule::livewire.edit-language');
    }
}