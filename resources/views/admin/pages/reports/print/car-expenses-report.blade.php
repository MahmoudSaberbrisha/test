@include('admin.pages.reports.print.header')

<table class="table table-bordered" border="1">
    <thead class="table-dark">
        <tr>
            <th>{{ __('Car Type') }}</th>
            <th>{{ __('Car Supplier') }}</th>
            <th>{{ __('Date') }}</th>
            <th>{{ __('Currency') }}</th>
            @foreach ($data['expenseTypes'] as $expenseType)
                <th>{{ $expenseType->name }}</th>
            @endforeach
            <th>{{ __('Total') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data['carExpenses'] as $expenses)
            <tr>
                <td>{{ $expenses['car_contract']['car_type'] }}</td>
                <td>{{ $expenses['car_contract']['car_supplier']['name'] }}</td>
                <td>{{ $expenses['date'] }}</td>
                <td>{{ $expenses['currency'] }}</td>
                @foreach ($data['expenseTypes'] as $expenseType)
                    <td>{{ number_format($expenses['expense_types'][$expenseType->name], 2) }}</td>
                @endforeach
                <td>{{ number_format($expenses['total_expenses'], 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($data['expenseTypes']) + 5 }}" class="text-center">{{ __('No Data Found.') }}</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        @foreach ($data['currencyTotals'] as $currency => $totals)
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="3">{{__('Total with')}} {{ $currency }}</td>
                <td></td>
                @foreach ($data['expenseTypes'] as $expenseType)
                    <td>{{ number_format($totals['expense_types'][$expenseType->name] ?? 0.00, 2) }}</td>
                @endforeach
                <td>{{ number_format($totals['total'], 2) }}</td>
            </tr>
        @endforeach
    </tfoot>
</table>

@include('admin.pages.reports.print.footer')