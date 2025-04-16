<div class="modal-body">
	<div wire:loading class="text-center mg-b-20 mb-4 mt-2 w-100">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>
    @if ($modalData)
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
    <div class="col-12 mt-5 table-responsive">
        <table class="table table-bordered mg-b-0 text-md-nowrap">
            <tr>
                <th>{{__('Client Type')}}</th>
                <th>{{__('Count')}}</th>
            </tr>
            @foreach($modalData->booking_group_members as $member)
            <tr>
                <td>{{$member->client_type->name}}</td>
                <td>{{$member->members_count}}</td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif
</div>

@push('js')
    <script type="text/javascript">
        Livewire.on('modalShow',()=>{
            $('#modal-details').modal('show');
        });
    </script>
@endpush
