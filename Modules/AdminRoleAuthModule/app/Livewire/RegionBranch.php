<?php

namespace Modules\AdminRoleAuthModule\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

class RegionBranch extends Component
{
    protected $regionRepository, $branchRepository;
    public $regions = [];
    public $branches = [];
    public $region_id = null;
    public $branch_id = null;
    public $requiredBranch = false;

    public function mount($region_id= null, $branch_id = null, $requiredBranch = false)
    {
        if (feature('regions-branches-feature')) {
            $this->regionRepository = App::make('RegionCrudRepository');
            $this->regions = $this->regionRepository->getActiveRecords();
            if ($region_id) {
                $this->region_id = $region_id;
                $this->getBranches($branch_id);
            }
        }
        if (feature('branches-feature')) {
            $this->branchRepository = App::make('BranchCrudRepository');
            $this->branches = $this->branchRepository->getActiveRecords();
            if ($branch_id)
                $this->branch_id = $branch_id;
        }
        $this->requiredBranch = $requiredBranch;
    }

    public function getBranches($branch_id = null)
    {
        $this->branchRepository = App::make('BranchCrudRepository');
        $this->branches = $this->branchRepository->getActiveRecords()->where('region_id', $this->region_id);
        if ($branch_id)
            $this->branch_id = $branch_id;
    }

    public function render(): View
    {
        return view('adminroleauthmodule::livewire.region-branch');
    }
}