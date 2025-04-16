@include('admin.pages.reports.print.header')

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>{{ __('Date') }}</th>
            <th>{{ __('Branch') }}</th>
            <th>{{ __('Expenses Types') }}</th>
            <th>{{ __('Note') }}</th>
            <th>{{ __('Currency') }}</th>
            <th>{{ __('Value') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data['expenses'] as $expense)
            <tr>
                <td>{{ $expense->expense_date }}</td>
                <td>{{ $expense->branch->name??'-' }}</td>
                <td>{{ $expense->expenses_type->name }}</td>
                <td>{{ $expense->note }}</td>
                <td>{{ $expense->currency->name }}</td>
                <td>{{ $expense->value }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">{{ __('No Data Found.') }}</td>
            </tr>
        @endforelse
        @forelse($data['reportDataCurrency'] as $dataCurrency)
            <tr style="background-color: #e1e4e7;">
                <th colspan="5">{{__('Total')}} ({{$dataCurrency->currency->name}})</th>
                <td>{{$dataCurrency->total}}</td>
            </tr>
        @empty
        @endforelse
    </tbody>
</table>

@include('admin.pages.reports.print.footer')
