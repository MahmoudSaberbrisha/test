@include('admin.pages.reports.print.header')

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>{{ __('Date') }}</th>
            <th>{{ __('Branch') }}</th>
            <th>{{ __('Resevation Type') }}</th>
            <th>{{ __('Booking Type') }}</th>
            <th>{{ __('Client Supplier') }}</th>
            <th>{{ __('Currency') }}</th>
            <th>{{ __('Price Person / Hour') }}</th>
            <th>{{ __('Total') }}</th>
            <th>{{ __('Paid') }}</th>
            <th>{{ __('Remain') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data['reportData'] as $oneData)
            <tr>
                <td>{{ $oneData->booking->booking_date->format('Y-m-d') }}</td>
                <td>{{$oneData->booking->branch->name}}</td>
                <td>{{__(BOOKING_TYPES[$oneData->booking->booking_type])}}</td>
                <td>{{$oneData->booking->type->name}}</td>
                <td>{{$oneData->client_supplier->name??'-'}}</td>
                <td>{{$oneData->currency->name}}</td>
                <td>{{$oneData->hour_member_price}}</td>
                <td>{{$oneData->total}}</td>
                <td>{{$oneData->paid}}</td>
                <td>{{$oneData->remain}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="11" class="text-center">{{ __('No Data Found.') }}</td>
            </tr>
        @endforelse
        @forelse($data['reportDataCurrency'] as $dataCurrency)
            <tr style="background-color: #e1e4e7;">
                <th colspan="6">{{__('Total')}} ({{$dataCurrency->currency->name}})</th>
                <td>{{$dataCurrency->total_hour_member_price}}</td>
                <td>{{$dataCurrency->final_total}}</td>
                <td>{{$dataCurrency->total_paid}}</td>
                <td>{{$dataCurrency->total_remain}}</td>
            </tr>
        @empty
        @endforelse
    </tbody>
</table>

@include('admin.pages.reports.print.footer')
