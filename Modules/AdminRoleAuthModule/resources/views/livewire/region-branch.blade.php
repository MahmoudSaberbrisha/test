<div class="row w-full pl-2">
    @feature('regions-branches-feature')
	<div class="col-6 pl-2">
        <div class="form-group">
            <label class="form-label">{{__('Region')}} </label>
            <select class="form-control" wire:model="region_id" wire:change="getBranches" name="region_id">
                <option value="">{{__('Select')}}</option>
                @foreach ($regions as $region)
                    <option value="{{$region->id}}">{{$region->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endfeature
    @if (feature('regions-branches-feature') || feature('branches-feature'))
    <div class="col-12 pr-3 pl-0">
        <div class="form-group">
            <label class="form-label">{{__('Branch')}} <span x-data x-show="@js($requiredBranch)" class="tx-danger">*</span></label>
            <select class="form-control" wire:model="branch_id" name="branch_id" {{$requiredBranch?'required':''}}>
                <option value="">{{__('Select')}}</option>
                @foreach ($branches as $branch)
                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endif
</div>