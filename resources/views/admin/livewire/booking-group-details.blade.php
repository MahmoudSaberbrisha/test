

<div class="modal-body">
    <div wire:loading class="text-center mg-b-20 mb-4 mt-2 w-100">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>
    
    @if ($modalData)
        @if ($isGrouped)
            <div class="col-12">
                <div class="table-responsive mt-3">
                    <table class="table table-bordered mg-b-0 text-md-nowrap">
                        <tr>
                            <th>{{__('Sailing Boat')}}</th>
                            <td>{{ $modalData->sailing_boat->name }}</td>
                            <th>{{__('Booking Type')}}</th>
                            <td>{{ $modalData->type->name }}</td>
                            <th>{{__('Branch')}}</th>
                            <td>{{ $modalData->branch->name }}</td>
                        </tr>
                        <tr>
                            <th width="20%">{{__('Start Time')}}</th>
                            <td>{{ $modalData->start_time->format('H:i') }}</td>
                            <th width="20%">{{__('End Time')}}</th>
                            <td>{{ $modalData->end_time->format('H:i') }}</td>
                            <th>{{__('Total Hours')}}</th>
                            <td>{{ $modalData->total_hours }}</td>
                        </tr>
                    </table>
                </div>
                
                <h5 class="mt-4">{{ __('Groups') }}</h5>
                @foreach($modalData->booking_groups as $group)
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mg-b-0">
                                    <tr>
                                        <th width="20%">{{__('Client')}}</th>
                                        <td>{{ $group->client->name }}</td>
                                        <th width="20%">{{__('Total Members')}}</th>
                                        <td>{{ $group->total_members }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Price/Hour')}}</th>
                                        <td>{{ $group->currency->symbol.' '.$group->hour_member_price }}</td>
                                        <th>{{__('Price')}}</th>
                                        <td>{{ $group->currency->symbol.' '.$group->price }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Discounted')}}</th>
                                        <td>{{ $group->currency->symbol.' '.$group->discounted }}</td>
                                        <th>{{__('Paid')}}</th>
                                        <td>{{ $group->currency->symbol.' '.$group->paid }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{__('Remain')}}</th>
                                        <td colspan="3">{{ $group->currency->symbol.' '.$group->remain }}</td>
                                    </tr>
                                </table>
                            </div>
                            
                            @if($group->booking_group_members->count())
                                <div class="mt-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mg-b-0">
                                            <thead>
                                                <tr>
                                                    <th>{{__('Client Type')}}</th>
                                                    <th>{{__('Count')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($group->booking_group_members as $member)
                                                <tr>
                                                    <td>{{ $member->client_type->name }}</td>
                                                    <td>{{ $member->members_count }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="col-12 table-responsive">
                <table class="table table-bordered mg-b-0 text-md-nowrap">
                    <tr>
                        <th width="15%">{{__('Client')}}</th><td>{{$modalData->client->name}}</td>
                        <th width="15%">{{__('Sailing Boat')}}</th><td>{{$modalData->booking->sailing_boat->name}}</td>
                        <th width="15%">{{__('Booking Type')}}</th><td>{{$modalData->booking->type->name}}</td>

                    </tr>
                    <tr>
                        <th width="15%">{{__('Total Members')}}</th><td>{{$modalData->total_members}}</td>
                        <th width="15%">{{__('Start Time')}}</th><td>{{$modalData->booking->start_time->format('H:i')}}</td>
                        <th width="15%">{{__('End Time')}}</th><td>{{$modalData->booking->end_time->format('H:i')}}</td>
                    </tr>
                    <tr>
                        <th width="15%">{{__('Total Hours')}}</th><td>{{$modalData->booking->total_hours}}</td>
                        <th width="15%">{{__('Price/Hour')}}</th><td>{{$modalData->currency->symbol.' '.$modalData->hour_member_price}}</td>
                        <th width="15%">{{__('Price')}}</th><td>{{$modalData->currency->symbol.' '.$modalData->price}}</td>
                    </tr>
                    <tr>
                        <th width="15%">{{__('Discounted')}}</th><td>{{$modalData->currency->symbol.' '.$modalData->discounted}}</td>
                        <th width="15%">{{__('Paid')}}</th><td>{{$modalData->currency->symbol.' '.$modalData->paid}}</td>
                        <th width="15%">{{__('Remain')}}</th><td>{{$modalData->currency->symbol.' '.$modalData->remain}}</td>
                    </tr>
                </table>
            </div>
            
            @if($modalData->booking_group_members->count())
                <div class="col-12 mt-4 table-responsive">
                    <h5>{{ __('Group Members') }}</h5>
                    <table class="table table-bordered mg-b-0">
                        <thead>
                            <tr>
                                <th>{{__('Client Type')}}</th>
                                <th>{{__('Count')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modalData->booking_group_members as $member)
                            <tr>
                                <td>{{ $member->client_type->name }}</td>
                                <td>{{ $member->members_count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
    @endif
</div>

@push('js')
    <script type="text/javascript">
        Livewire.on('modalShow', () => {
            $('#modal-details').modal('show');
        });
    </script>
@endpush