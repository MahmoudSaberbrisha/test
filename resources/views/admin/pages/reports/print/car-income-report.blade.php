@include('admin.pages.reports.print.header')

<h4 class="text-center mb-4">{{ __('Car Income Report') }}</h4>

<table class="table table-bordered" border="1">
    <thead class="table-dark">
        <tr>
            <th>{{ __('Car Type') }}</th>
            <th>{{ __('Car Supplier') }}</th>
            <th>{{ __('Currency') }}</th>
            <th>{{ __('Date') }}</th>
            <th>{{ __('Car Income') }}</th>
            <th>{{ __('Paid') }}</th>
            <th>{{ __('Remain') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data['carTasks'] as $task)
            <tr>
                <td>{{ $task->car_contract->car_type }}</td>
                <td>{{ $task->car_contract->car_supplier->name }}</td>
                <td>{{ $task->currency->name }}</td>
                <td>{{ $task->date }}</td>
                <td>{{ number_format($task->car_income, 2) }}</td>
                <td>{{ number_format($task->paid, 2) }}</td>
                <td>{{ number_format($task->remain, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">{{ __('No Data Found.') }}</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        @foreach($data['currencyTotals'] as $currency => $total)
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="4">{{ __('Total with') }} {{ $currency }}</td>
                <td>{{ number_format($total['total_income'], 2) }}</td>
                <td>{{ number_format($total['total_paid'], 2) }}</td>
                <td>{{ number_format($total['total_remain'], 2) }}</td>
            </tr>
        @endforeach
    </tfoot>
</table>

@include('admin.pages.reports.print.footer')