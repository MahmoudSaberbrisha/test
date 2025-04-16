<div>
	<div class="row mt-3 no-print">
        <div class="mb-3 col-3">
            <label for="from_date">{{ __('From Date') }}</label>
            <input type="date" wire:model="from_date" wire:change="getReportData" class="form-control">
        </div>

        <div class="mb-3 col-3">
            <label for="to_date">{{ __('To Date') }}</label>
            <input type="date" wire:model="to_date" wire:change="getReportData" class="form-control">
        </div>

        <div class="mb-3 col-3">
            <label for="toDate">{{ __('Branch') }}</label>
            <select class="form-control" wire:model="branch_id" wire:change="getReportData">
                <option value="all">{{__('All')}}</option>
                @foreach($branches as $branch)
                <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div wire:loading wire:target="getReportData" class="text-center mg-b-20 mb-4 mt-2 w-100 no-print">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>

	<div class="mt-3">
        <div class="row col-6">
            <button class="btn btn-info mb-3" type="button" wire:click="exportPdf"><i class="pl-3 fa fa-file-pdf"></i>{{__('Export PDF')}}</button>
            <button wire:click="exportExcel" class="btn btn-success mb-3 mr-3"><i class="fa fa-file-excel"></i> {{__('Export Excel')}}</button>
        </div>
        <h5>{{ __('Clients') }}</h5>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>{{__('Name')}}</th>
					<th>{{__('Phone')}}</th>
					<th>{{__('Mobile')}}</th>
					<th>{{__('Country')}}</th>
					<th>{{__('Area')}}</th>
					<th>{{__('City')}}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->mobile }}</td>
                        <td>{{ $client->country }}</td>
                        <td>{{ $client->area }}</td>
                        <td>{{ $client->city }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">{{ __('No Data Found.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>