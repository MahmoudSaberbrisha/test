@include('admin.pages.reports.print.header')

<table>
    <thead>
        <tr>
            <th>{{ __('Date') }}</th>
            <th>{{ __('Branch') }}</th>
            <th>{{ __('Resevation Type') }}</th>
            <th>{{ __('Booking Type') }}</th>
            <th>{{ __('Sailing Boat') }}</th>
            <th>{{ __('Total Hours') }}</th>
            <th>{{ __('Client Supplier') }}</th>
            <th>{{ __('Currency') }}</th>
            <th>{{ __('Price Person / Hour') }}</th>
            <th>{{ __('Price') }}</th>
            <th>{{ __('Discounted') }}</th>
            <th>{{ __('Tax 14%') }}</th>
            <th>{{ __('Total') }}</th>
            <th>{{ __('Confirmed') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data['reportData'] as $oneData)
            <tr>
                <td>{{ $oneData->booking->booking_date->format('Y-m-d') }}</td>
                <td>{{$oneData->booking->branch->name}}</td>
                <td>{{__(BOOKING_TYPES[$oneData->booking->booking_type])}}</td>
                <td>{{$oneData->booking->type->name}}</td>
                <td>{{$oneData->booking->sailing_boat->name}}</td>
                <td>{{$oneData->booking->total_hours}}</td>
                <td>{{$oneData->client_supplier->name??'-'}}</td>
                <td>{{$oneData->currency->name}}</td>
                <td>{{$oneData->hour_member_price}}</td>
                <td>{{$oneData->price}}</td>
                <td>{{$oneData->discounted}}</td>
                <td>{{$oneData->tax}}</td>
                <td>{{$oneData->total}}</td>
                <td>
                    @if($oneData->active == 1)
                        <span class="text-success">&#10004;</span>
                    @else
                        <span class="text-danger">&#10006;</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="14" class="text-center">{{ __('No Data Found.') }}</td>
            </tr>
        @endforelse
        @forelse($data['reportDataCurrency'] as $dataCurrency)
            <tr style="background-color: #e1e4e7;">
                <th colspan="8">{{__('Total')}} ({{$dataCurrency->currency->name}})</th>
                <td>{{$dataCurrency->total_hour_member_price}}</td>
                <td>{{$dataCurrency->total_price}}</td>
                <td>{{$dataCurrency->total_discount}}</td>
                <td>{{$dataCurrency->total_tax}}</td>
                <td>{{$dataCurrency->final_total}}</td>
                <td></td>
            </tr>
        @empty
        @endforelse
    </tbody>
</table>

@include('admin.pages.reports.print.footer')
