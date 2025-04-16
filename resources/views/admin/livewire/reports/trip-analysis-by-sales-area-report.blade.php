<div>
    <div class="row mt-3 no-print">
		<div class="mb-3 col-3">
            <label for="toDate">{{ __('Sales Areas') }}</label>
            <select class="form-control" wire:model="sales_area_id" wire:change="getReportData">
                <option value="all">{{__('All')}}</option>
                @foreach($salesAreas as $salesArea)
                <option value="{{$salesArea->id}}">{{$salesArea->name}}</option>
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

    @if($trips)
        <div class="mt-3">
            <div class="row col-6">
                <button class="btn btn-info mb-3" type="button" wire:click="exportPdf"><i class="pl-3 fa fa-file-pdf"></i>{{__('Export PDF')}}</button>
                <button wire:click="exportExcel" class="btn btn-success mb-3 mr-3"><i class="fa fa-file-excel"></i> {{__('Export Excel')}}</button>
            </div>
            <h5>{{ __('Trips Analysis') }}</h5>
            <table class="table table-bordered" border="1">
                <thead class="table-dark">
                    <tr>
                        <th>{{__('Booking Type')}}</th>
                        <th>{{__('Currency')}}</th>
                        <th>{{__('Number of Trips')}}</th>
                        <th>{{__('Total Sales')}}</th>
                        <th>{{__('Sales Percentage')}}</th>
                        <th>{{__('Average Sale')}}</th>
                        <th>{{__('Discount Value')}}</th>
                        <th>{{__('Discount Rate')}}</th>
                        <th>{{__('Hospitality Value')}}</th>
                        <th>{{__('Hospitality Percentage')}}</th>
                        @foreach ($tripSalesAreas as $tripSalesArea)
                            <th>{{__('Percentage Sales of')}} {{ $tripSalesArea->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trips as $trip)
                        <tr>
                            <td>{{ $trip->trip_type }}</td>
                            <td>{{ $trip->currency_name }}</td>
                            <td>{{ $trip->trip_count }}</td>
                            <td>{{ number_format($trip->total_sales, 2) }}</td>
                            <td>{{ number_format($trip->sales_percentage, 2) }}%</td>
                            <td>{{ number_format($trip->average_sales, 2) }}</td>
                            <td>{{ number_format($trip->total_discounted, 2) }}</td>
                            <td>{{ number_format($trip->average_discounted, 2) }}%</td>
                            <td>{{ number_format($trip->discount_value, 2) }}</td>
                            <td>{{ number_format($trip->average_discount_value, 2) }}%</td>
                            @foreach ($tripSalesAreas as $tripSalesArea)
                                <td>{{ number_format($trip->{"area_{$tripSalesArea->id}_percentage"}, 2) }}%</td>
                            @endforeach
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
                            <td colspan="3">{{__('Total with')}} {{ $currency }}</td>
                            <td>{{ number_format($total['total_sales'], 2) }}</td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($total['total_discounted'], 2)}}</td>
                            <td>{{number_format($total['average_discounted'], 2)}}</td>
                            <td>{{number_format($total['discount_value'], 2)}}</td>
                            <td>{{number_format($total['average_discount_value'], 2)}}</td>
                            @foreach ($tripSalesAreas as $tripSalesArea)
                                <td>{{ number_format($total["area_{$tripSalesArea->id}_percentage"], 2) }}%</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tfoot>
            </table>
        </div>
    @endif
</div>