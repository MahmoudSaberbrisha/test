@include('admin.pages.reports.print.header')

<table>
    <tr>
        <th width="15%">{{__('Name')}}</th><td>{{$data['selectedClient']->name}}</td>
        <th width="15%">{{__('Phone')}}</th><td>{{$data['selectedClient']->phone}}</td>
        <th width="15%">{{__('Mobile')}}</th><td>{{$data['selectedClient']->mobile}}</td>
    </tr>
    <tr>
        <th width="15%">{{__('Passport Number')}}</th><td>{{$data['selectedClient']->passport_number ?? '-'}}</td>
        <th width="15%">{{__('Country')}}</th><td>{{$data['selectedClient']->country ?? '-'}}</td>
        <th width="15%">{{__('Area')}}</th><td>{{$data['selectedClient']->area ?? '-'}}</td>
    </tr>
</table>

<div class="col-12 mt-4">
    <h5>{{ __('Bookings') }}</h5>
    <table>
        <thead >
            <tr>
                <th>{{ __('Booking Date&Time') }}</th>
                <th>{{ __('Type') }}</th>
                <th>{{ __('Hourly Price') }}</th>
                <th>{{ __('Serial No.') }}</th>
                @foreach ($data['clientTypes'] as $clientType)
                    <th>{{ $clientType->name }}</th>
                @endforeach
                <th>{{ __('Total Members') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['clientBookings'] as $booking)
                <tr>
                    <td>{{ $booking->booking->booking_date->format('Y-m-d') }} - {{ $booking->booking->start_time->format('H:i') }}</td>
                    <td>{{ $booking->booking->type->name ?? '-' }} ({{__(BOOKING_TYPES[$booking->booking->booking_type])}})</td>
                    <td>{{ $booking->hour_member_price }} {{ $booking->currency->symbol }}</td>
                    <td>{{ $booking->booking_group_num }}</td>
                    @foreach ($data['clientTypes'] as $clientType)
                        <td>{{ $data['clientTypeCount'][$booking->id][$clientType->id] ?? 0 }}</td>
                    @endforeach
                    <td>{{ $booking->total_members }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">{{ __('No records found') }}</td>
                </tr>
            @endforelse

            <tr style="background-color: #e1e4e7;">
                <td colspan="4"><strong>{{ __('Total') }}</strong></td>
                @foreach ($data['clientTypes'] as $clientType)
                    <td>
                        <strong>
                            {{ array_sum(array_column($data['clientTypeCount'], $clientType->id)) }}
                        </strong>
                    </td>
                @endforeach
                <td><strong>{{ $data['clientBookings']->sum('total_members') }}</strong></td>
            </tr>
        </tbody>
    </table>

    @if($data['clientServices']->isNotEmpty())
    <h5>{{ __('Extra Services') }}</h5>
    <table>
        <thead>
            <tr>
                <th>{{ __('Booking Date&Time') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Serial No.') }}</th>
                <th>{{ __('Number') }}</th>
                <th>{{ __('Price') }}</th>
                <th>{{ __('Paid') }}</th>
                <th>{{ __('Remain') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data['clientBookings'] as $group)
                @foreach($group->booking_group_services as $index => $service)
                    <tr>
                        @if($index == 0)
                        <td rowspan="{{ $group->booking_group_services_count }}">{{ $group->booking->booking_date->format('Y-m-d') }} - {{ $group->booking->start_time->format('H:i') }} {{$group->booking->type->name ?? '-' }} ({{__(BOOKING_TYPES[$group->booking->booking_type])}})</td>
                        @endif
                        <td>{{isset($service->extra_service->parent->name)?($service->extra_service->parent->name.' ('.$service->extra_service->name.')'):$service->extra_service->name}}</td>
                        <td>{{$service->booking_group_service_num}}</td>
                        <td>{{$service->services_count}}</td>
                        <td>{{$service->price}} {{ $service->currency_symbol }}</td>
                        <td>{{$service->paid}} {{ $service->currency_symbol }}</td>
                        <td>{{$service->remain}} {{ $service->currency_symbol }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="7" class="text-center">{{ __('No records found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @endif
</div>

@include('admin.pages.reports.print.footer')
