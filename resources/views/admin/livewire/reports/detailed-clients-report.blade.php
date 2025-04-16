<div x-data x-init="$nextTick(() => initSelect2Drop());">
    <div class="col-lg-6 mg-t-20 mg-lg-t-0">
        <div class="form-group w-100" wire:ignore>
            <label class="form-label mb-2">{{__('Clients')}}</label>
            <select class="form-control select2 js-example-basic-single" wire:model="client_id">
                <option value="" selected>{{ __('Select') }}</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($selectedClient)
        <div class="mt-5 col-12 table-responsive">
            <div class="row col-6">
                <button class="btn btn-info mb-3" type="button" wire:click="exportPdf"><i class="pl-3 fa fa-file-pdf"></i>{{__('Export PDF')}}</button>
                <button wire:click="exportExcel" class="btn btn-success mb-3 mr-3"><i class="fa fa-file-excel"></i> {{__('Export Excel')}}</button>
            </div>
            <h5>{{ __('Client Data') }}</h5>
            <table class="table table-bordered mg-b-0 text-md-nowrap">
                <tr>
                    <th width="15%">{{__('Name')}}</th><td>{{$selectedClient->name}}</td>
                    <th width="15%">{{__('Phone')}}</th><td>{{$selectedClient->phone}}</td>
                    <th width="15%">{{__('Mobile')}}</th><td>{{$selectedClient->mobile}}</td>
                </tr>
                <tr>
                    <th width="15%">{{__('Country')}}</th><td>{{$selectedClient->country ?? '-'}}</td>
                    <th width="15%">{{__('Area')}}</th><td>{{$selectedClient->area ?? '-'}}</td>
                    <th width="15%">{{__('City')}}</th><td>{{$selectedClient->city ?? '-'}}</td>
                </tr>
            </table>
        </div>

        <div class="col-12 mt-4">
            <div class="table-responsive">
                <h5>{{ __('Bookings') }}</h5>
                <table class="table table-bordered mg-b-0 text-md-nowrap">
                    <thead class="table-dark">
                        <tr>
                            <th>{{ __('Booking Date&Time') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Hourly Price') }}</th>
                            <th>{{ __('Serial No.') }}</th>
                            @foreach ($clientTypes as $clientType)
                                <th>{{ $clientType->name }}</th>
                            @endforeach
                            <th>{{ __('Total Members') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientBookings as $booking)
                            <tr>
                                <td>{{ $booking->booking->booking_date->format('Y-m-d') }} - {{ $booking->booking->start_time->format('H:i') }}</td>
                                <td>{{ $booking->booking->type->name ?? '-' }} ({{__(BOOKING_TYPES[$booking->booking->booking_type])}})</td>
                                <td>{{ $booking->hour_member_price }} {{ $booking->currency->symbol }}</td>
                                <td>{{ $booking->booking_group_num }}</td>
                                @foreach ($clientTypes as $clientType)
                                    <td>{{ $clientTypeCount[$booking->id][$clientType->id] ?? 0 }}</td>
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
                            @foreach ($clientTypes as $clientType)
                                <td>
                                    <strong>
                                        {{ array_sum(array_column($clientTypeCount, $clientType->id)) }}
                                    </strong>
                                </td>
                            @endforeach
                            <td><strong>{{ $clientBookings->sum('total_members') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($clientServices->isNotEmpty())
            <div class="table-responsive mt-4">
                <h5>{{ __('Extra Services') }}</h5>
                <table class="table table-bordered mg-b-0 text-md-nowrap">
                    <thead class="table-dark">
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
                        @forelse ($clientBookings as $group)
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
            </div>
            @endif
        </div>
    @endif
</div>

@push('js')
    <script type="text/javascript">
        function initSelect2Drop() {
            $('.js-example-basic-single').select2({
                language: "{{ app()->getLocale() }}",
                dir: "{{ session()->get('rtl', 1)?'rtl':'ltr' }}"
            });
        }
        $('.js-example-basic-single').on('change', function (e) {
            const selectedClientId = $(this).val();
            @this.set('client_id', selectedClientId);
            @this.call('fetchClientData');
        });
    </script>
@endpush