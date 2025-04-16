<div>
    <div class="row mt-3 no-print">
        <div class="mb-3 col-4">
            <label for="fromDate">{{ __('From Date') }}</label>
            <input type="date" wire:model="fromDate" wire:change="getReportData" class="form-control">
        </div>

        <div class="mb-3 col-4">
            <label for="toDate">{{ __('To Date') }}</label>
            <input type="date" wire:model="toDate" wire:change="getReportData" class="form-control">
        </div>
    </div>
    <div wire:loading wire:target="getReportData" class="text-center mg-b-20 mb-4 mt-2 w-100 no-print">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>

    @if($reportData)
        <div class="mt-3">
            <div class="row col-6">
                <button class="btn btn-info mb-3" type="button" wire:click="exportPdf"><i class="pl-3 fa fa-file-pdf"></i>{{__('Export PDF')}}</button>
                <button wire:click="exportExcel" class="btn btn-success mb-3 mr-3"><i class="fa fa-file-excel"></i> {{__('Export Excel')}}</button>
            </div>
            <h5>{{ __('Client Suppliers') }}</h5>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Currency') }}</th>
                        <th>{{ __('Total Sales') }}</th>
                        <th>{{ __('Value') }}</th>
                        <th>{{ __('Supplier Earnings') }}</th>
                        <th>{{ __('Percentage Sales') }}</th>
                        <th>{{ __('Percentage Earings Sales') }}</th>
                        <th>{{ __('Daily Avg Sales') }}</th>
                        <th>{{ __('Adjusted Sales') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportData as $data)
                        <tr>
                            <td>{{ $data->client_supplier->name??'-' }}</td>
                            <td>{{ $data->currency->code }}</td>
                            <td>{{ $data->total_sales }}</td>
                            <td>{{ $data->client_supplier_value }} %</td>
                            <td>{{ $data->supplier_earnings }}</td>
                            <td>{{ $data->percentage_of_currency }}</td>
                            <td>{{ $data->percentage_earingd_of_currency }}</td>
                            <td>{{ $data->daily_avg_sales }}</td>
                            <td>{{ $data->adjusted_sales }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">{{ __('No Data Found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-5 p-0 mt-5">
            <h5>{{ __('Total') }}</h5>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>{{__('Currency')}}</th>
                        <th>{{__('Total Sales')}}</th>
                        <th>{{__('Total Supplier Earnings')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($totalPerCurrencyView as $key => $currency)
                        <tr>
                            <td style="background-color: #e1e4e7;">{{ $currency->currency->name }}</td>
                            <td>{{ number_format($currency->total_currency_sales, 2) }}</td>
                            <td>{{ number_format($totalEarningsPerCurrencyView[$key]->total_currency_earnings, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
