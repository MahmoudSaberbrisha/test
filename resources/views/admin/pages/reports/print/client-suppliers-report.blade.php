@include('admin.pages.reports.print.header')

<table>
    <thead>
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
        @forelse($data['reportData'] as $oneData)
            <tr>
                <td>{{ $oneData->client_supplier->name??'-' }}</td>
                <td>{{ $oneData->currency->code }}</td>
                <td>{{ $oneData->total_sales }}</td>
                <td>{{ $oneData->client_supplier_value }} %</td>
                <td>{{ $oneData->supplier_earnings }}</td>
                <td>{{ $oneData->percentage_of_currency }}</td>
                <td>{{ $oneData->percentage_earingd_of_currency }}</td>
                <td>{{ $oneData->daily_avg_sales }}</td>
                <td>{{ $oneData->adjusted_sales }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">{{ __('No Data Found.') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="col-5 p-0 mt-5">
    <table>
        <thead>
            <tr>
                <th>{{__('Currency')}}</th>
                <th>{{__('Total Sales')}}</th>
                <th>{{__('Total Supplier Earnings')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['totalPerCurrencyView'] as $key => $currency)
                <tr>
                    <td style="background-color: #e1e4e7;">{{ $currency->currency->name }}</td>
                    <td>{{ number_format($currency->total_currency_sales, 2) }}</td>
                    <td>{{ number_format($data['totalEarningsPerCurrencyView'][$key]->total_currency_earnings, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('admin.pages.reports.print.footer')
