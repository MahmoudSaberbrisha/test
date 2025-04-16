@include('admin.pages.reports.print.header')

<table class="table table-bordered" border="1">
    <thead class="table-dark">
        <tr>
            <th>{{ __('Car Supplier') }}</th>
            <th>{{ __('Car Type') }}</th>
            <th>{{ __('Currency') }}</th>
            <th>{{ __('Contract Start Date') }}</th>
            <th>{{ __('Contract End Date') }}</th>
            <th>{{ __('Total') }}</th>
            <th>{{ __('Paid') }}</th>
            <th>{{ __('Remain') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data['contracts'] as $contract)
            <tr>
                <td>{{ $contract['car_supplier']['name'] }}</td>
                <td>{{ $contract['car_type'] }}</td>
                <td>{{ $contract['currency']['name'] }}</td>
                <td>{{ $contract['contract_start_date'] }}</td>
                <td>{{ $contract['contract_end_date'] }}</td>
                <td>{{ number_format($contract['total'], 2) }}</td>
                <td>{{ number_format($contract['paid'], 2) }}</td>
                <td>{{ number_format($contract['total'] - $contract['paid'], 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">{{ __('No Data Found.') }}</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        @foreach($data['currencyTotals'] as $currency => $totals)
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="5">{{__('Total with')}} {{ $currency }}</td>
                <td>{{ number_format($totals['total'], 2) }}</td>
                <td>{{ number_format($totals['paid'], 2) }}</td>
                <td>{{ number_format($totals['remain'], 2) }}</td>
            </tr>
        @endforeach
    </tfoot>
</table>

@include('admin.pages.reports.print.footer')