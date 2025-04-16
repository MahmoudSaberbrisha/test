@include('admin.pages.reports.print.header')

<table class="table table-bordered" border="1">
    <thead class="table-dark">
        <tr>
            <th>{{ __('Car Type') }}</th>
            <th>{{ __('Car Supplier') }}</th>
            <th>{{ __('Currency') }}</th>
            <th>{{ __('Date') }}</th>
            <th>{{ __('Total Income') }}</th>
            <th>{{ __('Total Expenses') }}</th>
            <th>{{ __('Difference') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data['carTasks'] as $task)
            <tr>
                <td>{{ $task['car_contract']['car_type'] }}</td>
                <td>{{ $task['car_contract']['car_supplier']['name'] }}</td>
                <td>{{ $task['car_contract']['currency']['name'] }}</td>
                <td>{{ $task['date'] }}</td>
                <td>{{ number_format($task['car_income'], 2) }}</td>
                <td>{{ number_format($task['total_expenses'], 2) }}</td>
                <td>{{ number_format($task['car_income'] - $task['total_expenses'], 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">{{ __('No Data Found.') }}</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        @foreach($data['currencyTotals'] as $currency => $total)
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="4">{{ __('Total with') }} {{ $currency }}</td>
                <td>{{ number_format($total['income'], 2) }}</td>
                <td>{{ number_format($total['expenses'], 2) }}</td>
                <td>{{ number_format($total['difference'], 2) }}</td>
            </tr>
        @endforeach
    </tfoot>
</table>

@include('admin.pages.reports.print.footer')