<?php

namespace Modules\AdminRoleAuthModule\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

class EditBranch extends Component
{
    public $regions;
    public $languageCode = null;
    public $modalData = null;
    public $name = '';
    public $region_id = '';

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
        $dataRepository = App::make('BranchCrudRepository');
        if(feature('regions-branches-feature')) {
            $regionRepository = App::make('RegionCrudRepository');
            $this->regions = $regionRepository->getAll();
        }
        $this->modalData = $dataRepository->findById($languageId);
        if(empty($this->languageCode))
            $this->languageCode = app()->getLocale();
        $this->name = $this->modalData->translateOrNew($this->languageCode)->name;
        $this->region_id = $this->modalData->region_id;
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
        return view('adminroleauthmodule::livewire.edit-branch');
    }
}
