<div x-data x-init="
    $nextTick(() => initDatePicker());
	$nextTick(() => initParsley());
	$nextTick(() => initTimePicker());
">
    @if ($modalData)
		<form method="POST" action="{{route(auth()->getDefaultDriver().'.bookings.update', $modalData->id)}}" id="my-form-id" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
			@csrf
            @method('PUT')
			<div class="modal-body">
                <div class="row m-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">{{ __('Sailing Boat') }}</label>
                            <select class="form-control" name="sailing_boat_id" required>
                                <option value="">{{__('Select')}}</option>
                                @foreach ($boats as $boat)
                                    <option value="{{$boat->id}}" {{$boat->id==$modalData->sailing_boat_id?'selected':''}}>{{$boat->name}}</option>
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
                                    <option value="{{ $type->id }}" {{ $modalData->type_id == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4" wire:ignore>
				        <label class="form-label">{{__('Date')}}</label>
				        <div class="input-group">
				            <div class="input-group-prepend">
				                <div class="input-group-text">
				                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
				                </div>
				            </div>
				            <input class="form-control fc-datepicker" placeholder="YYYY-MM-DD" type="text" data-parsley-errors-container="#date" name="booking_date" wire:model="booking_date" autocomplete="no" required>
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
				            <input required placeholder="{{__('Start Time')}}" class="form-control timepicker" type="text" name="start_time" autocomplete="nop" wire:model="start_time" data-parsley-errors-container="#start_time">
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
				            <input required placeholder="{{__('End Time')}}" class="form-control timepicker" type="text" name="end_time" autocomplete="nop" wire:model="end_time" data-parsley-errors-container="#end_time">
				        </div>
    					<div id="end_time"></div>
				    </div>
				    <div class="col-md-4">
				        <div class="form-group">
				            <label class="form-label">{{ __('Booking Hours') }}</label>
				            <input type="text" id="duration" name="total_hours" class="form-control" required readonly wire:model="total_hours" >
				        </div>
				    </div>
				    <div class="col-md-4">
				        <div class="form-group">
				            <label class="form-label">{{ __('Resevation Type') }}</label>
			                <select name="booking_type" class="form-control" required>
			                    @foreach(BOOKING_TYPES as $key => $type)
                                	@if ($modalData->booking_type != $key)
                                		@continue
                                	@endif
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
	@endif
</div>

@push('js')
    <script type="text/javascript">
        Livewire.on('modalShow',()=>{
            $('#modal-edit').modal('show');
            initDatePicker();
            initTimePicker();
            initParsley();
        });
    </script>

    <script type="text/javascript">
    	function calculateDuration() {
	        var startTime = @this.get('start_time');
	        var endTime = @this.get('end_time');

	        if (startTime != null && endTime != null) {
	            var startMinutes = convertTimeToMinutes(startTime);
	            var endMinutes = convertTimeToMinutes(endTime);
	            var durationMinutes = endMinutes - startMinutes;
	            var duration = convertMinutesToTime(durationMinutes);

	            @this.set('total_hours', duration);
	            $('#duration').val(duration);
	        } else {
	            @this.set('total_hours', null);
	        }
            initDatePicker();
	    }

	    function convertTimeToMinutes(time) {
	        var parts = time.split(':');
	        var hours = parseInt(parts[0]);
	        var minutes = parseInt(parts[1]);
	        return hours * 60 + minutes;
	    }

	    function convertMinutesToTime(minutes) {
	        var hours = Math.floor(minutes / 60);
	        var mins = minutes % 60;
	        return hours + ':' + (mins < 10 ? '0' + mins : mins);
	    }

		function initTimePicker() {
			const dateString = @this.get('booking_date');
			const dateObj = new Date(dateString);
			const formattedDate = dateObj.toDateString();

            var selectedDate = formattedDate??new Date();
            var now = new Date();
            var currentHour = now.getHours();
            var currentMinute = now.getMinutes();
            var step = 15;

            if (selectedDate === now.toDateString()) {
                currentMinute = Math.ceil(currentMinute / step) * step;
                if (currentMinute >= 60) {
                    currentHour += 1;
                    currentMinute = 0;
                }
                var minTime = currentHour + ':' + currentMinute;
            } else {
                var minTime = '00:00';
            }

            setTimeout(() => {
			    $('.timepicker').datetimepicker({
			        format: 'H:i',
			        datepicker: false,
			        step: step,
	                autocomplete: 'off',
			        autoclose: true,
	                minTime: minTime,
			    }).on('change', function(event) {
			    	let name = $(this).attr('name');
                if (name == 'start_time')
                    @this.set('start_time', $(this).val());
                if (name == 'end_time')
                    @this.set('end_time', $(this).val());
	                initDatePicker();
	                calculateDuration();
	            }).on('keydown', function(e) {
	                e.preventDefault();
	            }).attr('autocomplete', 'off');
            }, 10);
		}
	</script>

	<script type="text/javascript">
        function initParsley() {
            const form = document.getElementById('my-form-id');
            if (form) {
                $(form).parsley().reset();
                $(form).parsley();
            }
        }
    </script>

	<script type="text/javascript">
	    function initDatePicker() {
            setTimeout(() => {
                $('.fc-datepicker').datepicker({
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    dateFormat: "yy-mm-dd",
                    autoclose: true,
                    minDate: new Date()
                }).on('change', function () {
                    @this.set('booking_date', $(this).val());
                    $('.timepicker').val('').datetimepicker('update');
                    @this.set('start_time', null);
                    @this.set('end_time', null);
                    @this.set('total_hours', null);
                    initTimePicker();
                }).on('keydown', function(e) {
                    e.preventDefault();
                }).attr('autocomplete', 'off');
            }, 4);
        }
	</script>
@endpush