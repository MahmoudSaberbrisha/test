<div>
    <div class="row mt-3 no-print">
		<div class="mb-3 col-3">
            <label for="toDate">{{ __('Branch') }}</label>
            <select class="form-control" wire:model="branch_id" wire:change="getReportData">
                <option value="all">{{__('All')}}</option>
                @foreach($branches as $branch)
                <option value="{{$branch->id}}">{{$branch->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-3">
            <label for="toDate">{{ __('Currency') }}</label>
            <select class="form-control" wire:model="currency_id" wire:change="getReportData">
                <option value="all">{{__('All')}}</option>
                @foreach($currencies as $oneCurrency)
                <option value="{{$oneCurrency->id}}">{{$oneCurrency->name}}</option>
                @endforeach
            </select>
        </div>
	</div>

	<div wire:loading wire:target="getReportData" class="text-center mg-b-20 mb-4 mt-2 w-100 no-print">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>

    @if ($extraServicesReport)
    	<div class="mt-3">
            <div class="row col-6">
                <button class="btn btn-info mb-3" type="button" wire:click="exportPdf"><i class="pl-3 fa fa-file-pdf"></i>{{__('Export PDF')}}</button>
                <button wire:click="exportExcel" class="btn btn-success mb-3 mr-3"><i class="fa fa-file-excel"></i> {{__('Export Excel')}}</button>
            </div>
            <h5>{{ __('Extra Services') }}</h5>
            <table class="table table-bordered" border="1">
	            <thead class="table-dark">
	                <tr>
	                    <th>{{__('Basic Category')}}</th>
	                    <th>{{__('Number of Sales')}}</th>
	                    <th>{{__('Total Sales')}}</th>
	                    <th>{{__('Currency')}}</th>
	                    <th>{{__('Average Revenue')}}</th>
	                </tr>
	            </thead>
	            <tbody>
	                @forelse($extraServicesReport as $index => $service)
	                    <tr>
	                        <td>{{ $service->parent_service_name }}</td>
	                        <td>{{ number_format($service->service_count) }}</td>
	                        <td>{{ number_format($service->total_sales, 2) }}</td>
	                        <td>{{ $service->currency_name }}</td>
	                        <td>{{ number_format($service->total_income , 2)}}</td>
	                    </tr>
	                @empty
                        <tr>
                            <td colspan="14" class="text-center">{{ __('No Data Found.') }}</td>
                        </tr>
                    @endforelse
	            </tbody>
	            <tfoot>
			        @foreach ($currencyTotals as $currency => $total)
		            <tr style="font-weight: bold; background-color: #f0f0f0;">
		                <td>{{__('Total with')}} {{ $currency }}</td>
		                <td>{{ $total['total_service_count'] }}</td>
		                <td>{{ number_format($total['total_sales'], 2) }}</td>
		                <td></td>
		                <td>{{ number_format($total['average_revenue'], 2) }}</td>
		            </tr>
			        @endforeach
			    </tfoot>
	        </table>
        </div>
    @endif
</div>