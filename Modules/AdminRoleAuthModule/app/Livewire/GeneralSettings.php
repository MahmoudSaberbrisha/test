<?php

namespace Modules\AdminRoleAuthModule\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Modules\AdminRoleAuthModule\RepositoryInterface\SettingsRepositoryInterface as GeneralInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

class GeneralSettings extends Component
{
    public $settings;
    public $languageCode = null;
    public $name = '';
    public $description = '';

    public function mount(GeneralInterface $generalInterface)
    {
        $this->settings = $generalInterface->getGeneralSettings();
        if(empty($this->languageCode))
            $this->languageCode = app()->getLocale();
    }

    public function resetData()
    {
        $this->reset(['name', 'description']);
    }

    #[On('getByLanguage')]
    public function getByLanguage($languageCode)
    {
        $this->resetData();
        $this->languageCode = $languageCode;
    }

    public function render(): View
    {
        $this->name = $this->settings['site_name']->getProcessedValue($this->languageCode);
        $this->description = $this->settings['site_description']->getProcessedValue($this->languageCode);
        return view('adminroleauthmodule::livewire.general-settings');
    }
}