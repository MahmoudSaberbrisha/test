<div class="col-12 p-0 mb-5" x-data x-init="$nextTick(() => initSelect2Drop());">
    <div class="col-lg-6 mg-t-20 mg-lg-t-0">
        <div class="form-group w-100" wire:ignore>
            <label class="form-label mb-2">{{__('Bookings')}}</label>
            <select name="booking_group_id" data-parsley-errors-container="#select" class="form-control select2 select2-multi" wire:model="booking_group_id" required>
                <option value="">{{ __('Select') }}</option>
                @foreach ($bookingGroups as $book)
                    <option value="{{$book->id}}" {{($book->id == $booking_group_id || $book->id==session()->get('bookingGroupId'))? 'selected' : ''}}>
                        @if (isset($book->booking_groups)) 
                            {{ $book->booking_groups->first()->client->name }} -- {{__(BOOKING_TYPES[$book->booking_type])}} -- ({{$book->booking_date->format('Y-m-d') .' '. $book->start_time->format('H:i')}})
                        @else 
                            {{ $book->client->name }} -- {{__(BOOKING_TYPES[$book->booking->booking_type])}} -- ({{$book->booking->booking_date->format('Y-m-d') .' '. $book->booking->start_time->format('H:i')}})
                        @endif
                    </option>
                @endforeach
            </select>
            <div id="select"></div>
        </div>
    </div>

    @if ($booking)
    <div class="col-12 mt-5 mb-5 table-responsive">
        <table class="table table-bordered mg-b-0 text-md-nowrap">
            <tr>
                <th width="15%">{{__('Branch')}}</th><td>{{$booking->booking->branch->name??'-'}}</td>
                <th width="15%">{{__('Sailing Boat')}}</th><td>{{$booking->booking->sailing_boat->name}}</td>
                <th width="15%">{{__('Booking Type')}}</th><td>{{$booking->booking->type->name}}</td>

                <th width="15%">{{__('Reservation Type')}}</th><td>{{__(BOOKING_TYPES[$booking->booking->booking_type])}}</td>
            </tr>
            <tr>
                <th width="15%">{{__('Booking Date')}}</th><td>{{$booking->booking->booking_date->format('Y-m-d')}}</td>
                <th width="15%">{{__('Start Time')}}</th><td>{{$booking->booking->start_time->format('H:i')}}</td>
                <th width="15%">{{__('End Time')}}</th><td>{{$booking->booking->end_time->format('H:i')}}</td>
                <th width="15%">{{__('Total Hours')}}</th><td>{{$booking->booking->total_hours}}</td>
            </tr>
        </table>
    </div>

    <div class="card">
        <div class="card-body">
        @foreach($services as $serviceIndex => $service)
            @if ($serviceIndex > 0)
            <hr style="border: none; border-top: 2px dashed #000; margin: 20px 0;">
            @endif
            <label class="profile-edit">{{__('Extra Service')}} # {{$serviceIndex+1}}</label>
            <div class="row align-items-center mb-3 p-3 border rounded bg-light">
                <div class="col-md-2">
                    <label>{{__('Count')}}</label>
                    <input type="number" placeholder="{{__('Count')}}" name="services[{{$serviceIndex}}][services_count]" class="form-control" wire:model="services.{{ $serviceIndex }}.count" wire:keyup.debounce.250ms="updateTotalPrice({{ $serviceIndex }})" min="1" data-parsley-min="1" required>
                </div>
                <div class="col-md-3">
                    <label>{{__('Extra Service')}}</label>
                    <select class="form-control" name="services[{{$serviceIndex}}][extra_service_id]" wire:model="services.{{ $serviceIndex }}.extra_service_id" wire:change="checkDoubleService({{$serviceIndex}})" required>
                        <option value="">{{__('Select')}}</option>
                        @foreach($extraServices as $extraService)
                            @if ($extraService->children->count() > 0)
                                @foreach ($extraService->children as $child)
                                    <option value="{{$child->id}}" {{isset($services['extra_service_id'])?($child->id == $services['extra_service_id'] ? 'selected' : ''):''}}>{{$child->name}} ({{$child->parent->name}})</option>
                                @endforeach
                            @else
                                <option value="{{$extraService->id}}" {{isset($services['extra_service_id'])?($extraService->id == $services['extra_service_id'] ? 'selected' : ''):''}}>{{$extraService->name}} </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>{{__('Price')}}</label>
                    <input type="number" name="services[{{$serviceIndex}}][price]" placeholder="{{__('Price')}}" class="form-control" wire:model="services.{{ $serviceIndex }}.price" wire:keyup.debounce.250ms="updateTotalPrice({{ $serviceIndex }})">
                </div>
                <div class="col-md-2">
                    <label>{{__("Total")}}</label>
                    <input type="number" name="services[{{$serviceIndex}}][total]" placeholder="{{__('Total')}}" class="form-control" wire:model="services.{{ $serviceIndex }}.total" readonly>
                </div>
                <div class="col-md-2">
                    <label>{{__('Currency')}}</label>
                    <select name="services[{{$serviceIndex}}][currency_id]" class="form-control" wire:model="services.{{ $serviceIndex }}.currency_id" required>
                        @foreach ($currencies as $currency)
                            <option value="{{$currency->id}}" {{$currency->id==$defaultCurrency->id?'selected':''}}> {{$currency->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="javascript:void(0);" class="remove-from-cart modal-effect mt-4" wire:click="removeService({{ $serviceIndex }})">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </div>

            <div class="border p-3 mb-3">
                <h6>{{__('Payment Methods')}}</h6>
                @foreach($service['payments'] as $paymentIndex => $payment)
                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label>{{__('Payment')}} # {{$paymentIndex+1}}</label>
                            <select name="services[{{$serviceIndex}}][payments][{{ $paymentIndex }}][payment_method_id]" class="form-control" wire:model="services.{{ $serviceIndex }}.payments.{{ $paymentIndex }}.method" wire:change="checkPaymentMethod({{ $serviceIndex }}, {{ $paymentIndex }})" required>
                                <option value="">{{__('Select')}}</option>
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>{{__('Paid')}}</label>
                            <input type="number" name="services[{{$serviceIndex}}][payments][{{ $paymentIndex }}][paid]" {{__('Enter Paid Value')}} class="form-control" wire:model="services.{{ $serviceIndex }}.payments.{{ $paymentIndex }}.amount" wire:keyup.debounce.250ms="updatePaymentAmount({{ $serviceIndex }})" required min="1" data-parsley-min="1">
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0);" class="remove-from-cart modal-effect mt-4" wire:click="removePaymentMethod({{ $serviceIndex }}, {{ $paymentIndex }})">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                @endforeach

                <button type="button" class="btn btn-success btn-sm" wire:click="addPaymentMethod({{ $serviceIndex }})">
                    <i class="fa fa-plus"></i> {{__('Add Payment')}}
                </button>
            </div>
        @endforeach

        <button type="button" class="btn btn-primary" wire:click="addService">
            <i class="fa fa-plus"></i> {{__('Add Extra Service')}}
        </button>
        </div>
    </div>
    @endif
</div>

@push('js')
    <script type="text/javascript">
        function initSelect2Drop() {
            $('.select2-multi').select2({
                language: "{{ app()->getLocale() }}",
	            dir: "{{ session()->get('rtl', 1) ? 'rtl' : 'ltr' }}",
	            placeholder: "{{ __('Search...') }}",
            });
        }
        $('.select2-multi').on('change', function (e) {
            const booking_group_id = e.target.value;
            if (booking_group_id) {
                @this.set('booking_group_id', booking_group_id);
                @this.call('getBookingData');
            }
        });
    </script>
@endpush