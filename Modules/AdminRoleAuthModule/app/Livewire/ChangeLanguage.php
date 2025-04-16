<?php

namespace Modules\AdminRoleAuthModule\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Modules\AdminRoleAuthModule\RepositoryInterface\LanguagesRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

class ChangeLanguage extends Component
{
    public $languages;
    public $selectedLanguageCode = null;
    public $key;

    public function mount(LanguagesRepositoryInterface $languageRepository, $key = '')
    {
        $this->key = $key;
        $this->languages = $languageRepository->getActiveLanguages();
    }

    #[On('resetLanguageData')]
    public function resetLanguageData()
    {
        $this->reset(['selectedLanguageCode']);
    }

    public function updatedSelectedLanguageCode($value)
    {
        $this->dispatch('getByLanguage', $value);
    }

    public function render(): View
    {
        if(empty($this->selectedLanguageCode)) 
            $this->selectedLanguageCode = app()->getLocale();
        return view('adminroleauthmodule::livewire.change-language');
    }
}
