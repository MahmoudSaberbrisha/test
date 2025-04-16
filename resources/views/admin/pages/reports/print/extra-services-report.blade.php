@include('admin.pages.reports.print.header')

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
        @forelse($data['extraServicesReport'] as $index => $service)
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
        @foreach ($data['currencyTotals'] as $currency => $total)
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

@include('admin.pages.reports.print.footer')
