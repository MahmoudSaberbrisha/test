@include('admin.pages.reports.print.header')

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
            @foreach ($data['tripBranches'] as $tripBranch)
                <th>{{__('Percentage Sales of')}} {{ $tripBranch->name }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse ($data['trips'] as $trip)
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
                @foreach ($data['tripBranches'] as $tripBranch)
                    <td>{{ number_format($trip->{"branch_{$tripBranch->id}_percentage"}, 2) }}%</td>
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="14" class="text-center">{{ __('No Data Found.') }}</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        @foreach ($data['currencyTotals'] as $currency => $total)
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="3">{{__('Total with')}} {{ $currency }}</td>
                <td>{{ number_format($total['total_sales'], 2) }}</td>
                <td></td>
                <td></td>
                <td>{{number_format($total['total_discounted'], 2)}}</td>
                <td>{{number_format($total['average_discounted'], 2)}}</td>
                <td>{{number_format($total['discount_value'], 2)}}</td>
                <td>{{number_format($total['average_discount_value'], 2)}}</td>
                @foreach ($data['tripBranches'] as $tripBranch)
                    <td>{{ number_format($total["branch_{$tripBranch->id}_percentage"], 2) }}%</td>
                @endforeach
            </tr>
        @endforeach
    </tfoot>
</table>

@include('admin.pages.reports.print.footer')
