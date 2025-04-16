<div class="modal" id="modal-add">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">{{__('Add Cruise')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<form method="POST" action="{{route(auth()->getDefaultDriver().'.bookings.store')}}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
				@csrf
				<div class="modal-body">
                    <div class="row m-2">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('Sailing Boat') }}</label>
                                <select class="form-control" name="sailing_boat_id" required>
                                    <option value="">{{__('Select')}}</option>
                                    @foreach ($boats as $boat)
                                        <option value="{{$boat->id}}" {{$boat->id==old('sailing_boat_id')?'selected':''}}>{{$boat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ __('Booking Type') }}</label>
                                <select class="form-control" name="type_id" required>
                                    <option value="">{{ __('Select') }}</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
					        <label class="form-label">{{__('Date')}}</label>
					        <div class="input-group">
					            <div class="input-group-prepend">
					                <div class="input-group-text">
					                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
					                </div>
					            </div>
					            <input class="form-control fc-datepicker" placeholder="YYYY-MM-DD" type="text" data-parsley-errors-container="#date" name="booking_date" value="{{date('Y-m-d')}}" autocomplete="no" required>
					        </div>
					        <div id="date"></div>
					    </div>
					    <div class="col-md-4">
					        <label class="form-label">{{__('Start Time')}}</label>
					        <div class="input-group">
					            <div class="input-group-prepend">
					                <div class="input-group-text">
					                    <i class="typcn typcn-time tx-24 lh--9 op-6"></i>
					                </div>
					            </div>
					            <input required placeholder="{{__('Start Time')}}" class="form-control timepicker" type="text" name="start_time" autocomplete="nop" data-parsley-errors-container="#start_time">
					        </div>
        					<div id="start_time"></div>
					    </div>
					    <div class="col-md-4">
					        <label class="form-label">{{__('End Time')}}</label>
					        <div class="input-group">
					            <div class="input-group-prepend">
					                <div class="input-group-text">
					                    <i class="typcn typcn-time tx-24 lh--9 op-6"></i>
					                </div>
					            </div>
					            <input required placeholder="{{__('End Time')}}" class="form-control timepicker" type="text" name="end_time" autocomplete="nop" data-parsley-errors-container="#end_time">
					        </div>
        					<div id="end_time"></div>
					    </div>
					    <div class="col-md-4">
					        <div class="form-group">
					            <label class="form-label">{{ __('Booking Hours') }}</label>
					            <input type="text" id="duration" name="total_hours" class="form-control" required readonly>
					        </div>
					    </div>
					    <div class="col-md-4">
					        <div class="form-group">
					            <label class="form-label">{{ __('Resevation Type') }}</label>
				                <select name="booking_type" class="form-control" x-model="booking_type" required>
				                    @foreach(BOOKING_TYPES as $key => $type)
				                    	<option value="{{$key}}">{{__($type)}}</option>
				                    @endforeach
				                </select>
					        </div>
					    </div>
                    </div>
                </div>
				<div class="modal-footer">
					<button name="save" value="continue" class="btn ripple btn-success" type="submit">{{__('Save & Add Group')}}</button>
					<button name="save" value="close" class="btn ripple btn-primary" type="submit">{{__('Save')}}</button>
					<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('Close')}}</button>
				</div>
			</form>
		</div>
	</div>
</div>
