<div class="row col-12 mb-4" x-data="{ booking_type: @entangle($booking_type) }" x-init="$nextTick(() => initParsley());">
    <div class="col-4">
        <div class="form-group">
            <label class="form-label">{{ __('Bookings') }}</label>
            <select class="form-control select2-multi" name="booking_id" required
                data-parsley-errors-container="#booking_id_error" wire:model="booking_id">
                <option value="">{{ __('Select') }}</option>
                @foreach ($bookings as $booking_data)
                    <option value="{{ $booking_data->id }}"
                        {{ ($bookingGroup ? $booking_data->id == $bookingGroup->booking_id : '') || $booking_data->id == session()->get('bookingId') ? 'selected' : '' }}>
                        {{ (optional($booking_data->branch)->name ?? 'N/A') .
                            ' - ' .
                            __(BOOKING_TYPES[$booking_data->booking_type]) .
                            ' - ' .
                            $booking_data->type->name .
                            ' ( ' .
                            $booking_data->booking_date->format('Y-m-d') .
                            ' ' .
                            $booking_data->start_time->format('H:i') .
                            ' )' }}
                    </option>
                @endforeach
            </select>
            <div id="booking_id_error"></div>
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label class="form-label">{{ __('Client') }}</label>
            <select class="form-control select2-multi" name="client_id" required
                data-parsley-errors-container="#client_id_error">
                <option value="">{{ __('Select') }}</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}"
                        {{ ($bookingGroup ? $client->id == $bookingGroup->client_id : '') || $client->id == session()->get('client_id') ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
            <div id="client_id_error"></div>
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label class="form-label">{{ __('Sales Area') }}</label>
            <select class="form-control" name="sales_area_id" required>
                <option value="">{{ __('Select') }}</option>
                @foreach ($salesAreas as $salesArea)
                    <option value="{{ $salesArea->id }}"
                        {{ ($bookingGroup ? $salesArea->id == $bookingGroup->sales_area_id : '') || $salesArea->id == session()->get('sales_area_id') ? 'selected' : '' }}>
                        {{ $salesArea->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label class="form-label mb-3">{{ __('Client Supplier Type') }}</label>
            <div class="row mg-t-12">
                <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                    <label class="rdiobox"><input required name="supplier_type" type="radio"
                            value="App\Models\EmployeeManagement\Employee" wire:model='supplier_type'
                            wire:change="changeSupplierType"> <span>{{ __('Employee') }}</span></label>
                </div>
                <div class="col-lg-6 mg-t-20 mg-lg-t-0">
                    <label class="rdiobox"><input required name="supplier_type" type="radio"
                            value="App\Models\ClientSupplier" wire:model='supplier_type'
                            wire:change="changeSupplierType"> <span>{{ __('Supplier') }}</span></label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label class="form-label">{{ __('Client Supplier') }}</label>
            <select class="form-control" name="client_supplier_id" required>
                <option value="">{{ __('Select') }}</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}"
                        {{ $bookingGroup ? ($bookingGroup->client_supplier_id == $supplier->id ? 'selected' : '') : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label class="form-label">{{ __('Notes') }}</label>
            <textarea class="form-control" name="notes" rows="3">{{ $bookingGroup ? $bookingGroup->notes : '' }}</textarea>
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label class="form-label">{{ __('Description') }}</label>
            <textarea class="form-control" name="description" rows="3">{{ $bookingGroup ? $bookingGroup->description : '' }}</textarea>
        </div>
    </div>

    <div class="col-4 d-flex align-items-center mt-3">
        <div class="form-group d-flex align-items-center m-0 mr-4">
            <label class="switch mb-0 ml-2">
                <input type="hidden" name="is_taxed" value="0">
                <input id="is_taxed" type="checkbox" wire:change="changeIsTaxed($event.target.checked)"
                    wire:model="is_taxed" name="is_taxed" value="1"
                    {{ $bookingGroup ? ($bookingGroup->is_taxed == 1 ? 'checked' : '') : '' }}>
                <span class="slider round"></span>
            </label>
            <span class="ml-3">{{ __('Is Taxed') }}</span>
        </div>
    </div>

    <div class="col-4 d-flex align-items-center mt-3">
        <div class="form-group d-flex align-items-center m-0 mr-4">
            <label class="switch mb-0 ml-2">
                <input type="hidden" name="out_marina" value="0">
                <input id="out_marina" type="checkbox" name="out_marina" value="1"
                    {{ $bookingGroup ? ($bookingGroup->out_marina == 1 ? 'checked' : '') : '' }}>
                <span class="slider round"></span>
            </label>
            <span class="ml-3">{{ __('Out Marina') }}</span>
        </div>
    </div>

    <div class="col-4 d-flex align-items-center mt-3" x-data>
        <div class="form-group d-flex align-items-center m-0 mr-4">
            <label class="switch mb-0 ml-2">
                <input type="hidden" name="credit_sales" value="0">
                <input id="credit_sales" type="checkbox" name="credit_sales" x-model="$wire.credit_sales"
                    value="1" {{ $bookingGroup ? ($bookingGroup->credit_sales == 1 ? 'checked' : '') : '' }}>
                <span class="slider round"></span>
            </label>
            <span class="ml-3">{{ __('Credit Sales') }}</span>
        </div>
    </div>

    @if ($booking)
        <div class="col-12 mt-5 table-responsive">
            <table class="table table-bordered mg-b-0 text-md-nowrap">
                <tr>
                    <th width="15%">{{ __('Branch') }}</th>
                    <td>{{ $booking->branch->name ?? '-' }}</td>
                    <th width="15%">{{ __('Sailing Boat') }}</th>
                    <td>{{ $booking->sailing_boat->name }}</td>
                    <th width="15%">{{ __('Booking Type') }}</th>
                    <td>{{ $booking->type->name }}</td>

                    <th width="15%">{{ __('Reservation Type') }}</th>
                    <td>{{ __(BOOKING_TYPES[$booking->booking_type]) }}</td>
                </tr>
                <tr>
                    <th width="15%">{{ __('Booking Date') }}</th>
                    <td>{{ $booking->booking_date->format('Y-m-d') }}</td>
                    <th width="15%">{{ __('Start Time') }}</th>
                    <td>{{ $booking->start_time->format('H:i') }}</td>
                    <th width="15%">{{ __('End Time') }}</th>
                    <td>{{ $booking->end_time->format('H:i') }}</td>
                    <th width="15%">{{ __('Total Hours') }}</th>
                    <td>{{ $booking->total_hours }}</td>
                </tr>
            </table>
        </div>
    @endif

    <fieldset class="w-100 mt-5" x-show="$wire.booking_type === 'group'"
        :disabled="$wire.booking_type === 'private'">
        <div class="col-12 p-0 row pr-2">
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">{{ __('Price/Member') }}</label>
                    <input class="form-control" type="number" name="hour_member_price"
                        wire:model="hour_member_price" data-parsley-min="1" step="any"
                        wire:keyup.debounce.250ms="updateHourPrice">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label class="form-label">{{ __('Currency') }}</label>
                    <select class="form-control" name="currency_id" required>
                        <option value="">{{ __('Select') }}</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}"
                                {{ $bookingGroup ? ($bookingGroup->currency_id == $currency->id ? 'selected' : '') : ($defaultCurrency ? ($defaultCurrency->id == $currency->id ? 'selected' : '') : '') }}>
                                {{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12 row mt-4 mr-1">
                <a href="javascript:void(0);" wire:click="addInput"
                    class="btn btn-success mg-b-20">{{ __('Add Members') }} <i class="typcn typcn-plus"></i></a>
                <div class="col-3">
                    <div class="form-group">
                        <select class="form-control" wire:model="client_type_id">
                            <option value="">{{ __('Select') }}</option>
                            @foreach ($clientTypes as $clientType)
                                <option value="{{ $clientType->id }}">{{ $clientType->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="price" wire:model="price" class="form-control"
                            value="{{ $price }}">
                    </div>
                </div>
            </div>

            @if (!empty($inputs))
                @foreach ($inputs as $key => $input)
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Members Count') }}</label>
                                        <input wire:keyup.debounce.250ms="updateTotalPrice({{ $key }})"
                                            wire:model.defer="inputs.{{ $key }}.members_count"
                                            type="number" step="any" name="members_count[]"
                                            class="form-control" placeholder="{{ __('Members Count') }}"
                                            min="1" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Client Type') }}</label>
                                        <select wire:model.defer="inputs.{{ $key }}.client_type_id"
                                            class="form-control" name="client_type_id[]"
                                            wire:change="changeClientType({{ $key }})" required>
                                            @foreach ($clientTypes as $clientType)
                                                <option value="{{ $clientType->id }}">{{ $clientType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Member Price') }}</label>
                                        <input wire:keyup.debounce.250ms="updateTotalPrice({{ $key }})"
                                            wire:model.defer="inputs.{{ $key }}.member_price" type="number"
                                            step="any" name="member_price[]" class="form-control"
                                            placeholder="{{ __('Member Price') }}" required readonly>
                                        <input type="hidden" name="discount_type[]"
                                            wire:model="inputs.{{ $key }}.discount_type"
                                            value="{{ $inputs[$key]['discount_type'] }}">
                                        <input type="hidden" name="discount_value[]"
                                            wire:model="inputs.{{ $key }}.discount_value"
                                            value="{{ $inputs[$key]['discount_value'] }}">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Member Total Price') }}</label>
                                        <input wire:model.defer="inputs.{{ $key }}.member_total_price"
                                            type="number" step="any" name="member_total_price[]"
                                            class="form-control" placeholder="{{ __('Member Total Price') }}"
                                            required readonly>
                                    </div>
                                </div>
                                <div class="col-1 mt-4">
                                    <a wire:click="removeInput({{ $key }})"
                                        class="remove-from-cart modal-effect mt-2" href="javascript:void(0);"><i
                                            class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-12 row">
                    <div class="col-3">
                        <label class="form-label">{{ __('Total Members') }}</label>
                        <input type="number" step="any" min="0" name="total_members"
                            class="form-control" wire:model="total_members" readonly>
                    </div>
                    <div class="col-3">
                        <label class="form-label">{{ __('Discounted') }}</label>
                        <input type="number" step="any" wire:keyup.debounce.250ms="updateTotals" min="0"
                            name="discounted" class="form-control" wire:model="discounted">
                        <input type="hidden" name="total_after_discount" wire:model="total_after_discount"
                            value="{{ $total_after_discount }}">
                    </div>
                    <div class="col-2">
                        <label class="form-label">{{ __('Total') }}</label>
                        <input type="number" step="any" min="0" name="total" class="form-control"
                            wire:model="total" required readonly value="{{ $total }}">
                    </div>
                    @if ($is_taxed)
                        <div class="col-2">
                            <label class="form-label">{{ __('Tax 14%') }}</label>
                            <input type="number" step="any" min="0" name="tax" class="form-control"
                                wire:model="tax" required readonly>
                        </div>
                    @endif
                    <div class="col-2">
                        <label class="form-label">{{ __('Final Total') }}</label>
                        <input type="number" step="any" min="0" name="final_total" class="form-control"
                            wire:model="final_total" required readonly>
                    </div>
                </div>

                <div class="w-100 mt-5" x-show="!$wire.credit_sales" x-transition>
                    <div class="col-md-12">
                        <button type="button" wire:click="addPaymentInput" class="btn btn-success mg-b-20"
                            {{ $remain <= 0 ? 'disabled' : '' }}>{{ __('Add Payment') }} <i
                                class="typcn typcn-plus"></i></button>
                    </div>
                    @foreach ($paymentInputs as $paymentKey => $paymentInput)
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="contact_{{ $paymentKey }}_input"
                                    class="profile-edit">{{ __('Payment') }} # {{ $paymentKey + 1 }}</label>
                                <div class="row">
                                    <div class="col-3">
                                        <select class="form-control"
                                            x-bind:name="!$wire.credit_sales ? 'payment_method_id[]' : null"
                                            wire:model.defer="paymentInputs.{{ $paymentKey }}.payment_method_id"
                                            wire:change="checkPaymentMethod({{ $paymentKey }})"
                                            x-bind:required="!$wire.credit_sales">
                                            <option value="">{{ __('Select') }}</option>
                                            @foreach ($paymentMethods as $paymentMethod)
                                                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <input placeholder ="{{ __('Enter Paid Value') }}"
                                            wire:model.defer="paymentInputs.{{ $paymentKey }}.paid" type="number"
                                            step="any" class="form-control"
                                            x-bind:name="!$wire.credit_sales ? 'paid[]' : null"
                                            wire:keyup.debounce.250ms="updateRemain({{ $paymentKey }})"
                                            x-bind:min="!$wire.credit_sales ? 1 : 0"
                                            x-bind:data-parsley-min="!$wire.credit_sales ? 1 : 0"
                                            x-bind:required="!$wire.credit_sales">
                                    </div>
                                    @if (count($paymentInputs) > 1)
                                        <div class="col-1">
                                            <a wire:click="removePaymentInput({{ $paymentKey }})"
                                                class="remove-from-cart modal-effect mt-2"
                                                href="javascript:void(0);"><i class="fa fa-trash"></i></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <label class="mt-5 form-label pr-2">{{ __('Remain') }}: {{ $remain }}</label>
            @endif
        </div>
    </fieldset>

    <fieldset class="w-100 mt-5" x-show="$wire.booking_type === 'private'"
        :disabled="$wire.booking_type === 'group'">
        <div class="col-12 p-0 row pr-2">
            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">{{ __('Price/Hour') }}</label>
                    <input class="form-control" type="number" name="hour_member_price"
                        wire:model="hour_member_price" wire:keyup="updateHourPrice" data-parsley-min="1"
                        step="any">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">{{ __('Currency') }}</label>
                    <select class="form-control" name="currency_id" required>
                        <option value="">{{ __('Select') }}</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}"
                                {{ $bookingGroup ? ($bookingGroup->currency_id == $currency->id ? 'selected' : '') : ($defaultCurrency ? ($defaultCurrency->id == $currency->id ? 'selected' : '') : '') }}>
                                {{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label class="form-label">{{ __('Price') }}</label>
                    <input type="number" step="0.5" name="price" wire:model="price" class="form-control"
                        value="{{ $price }}" required readonly
                        {{ $booking_type == 'private' ? 'data-parsley-min=1' : '' }}>
                </div>
            </div>

            <div class="col-md-12 row mt-4 mr-1">
                <a href="javascript:void(0);" wire:click="addInput"
                    class="btn btn-success mg-b-20">{{ __('Add Members') }} <i class="typcn typcn-plus"></i></a>
                <div class="col-3">
                    <div class="form-group">
                        <select class="form-control" wire:model="client_type_id">
                            <option value="">{{ __('Select') }}</option>
                            @foreach ($clientTypes as $clientType)
                                <option value="{{ $clientType->id }}">{{ $clientType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            @if (!empty($inputs))
                @foreach ($inputs as $key => $input)
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Members Count') }}</label>
                                        <input wire:keyup.debounce.250ms="updateTotalPrice({{ $key }})"
                                            wire:model.defer="inputs.{{ $key }}.members_count"
                                            type="number" step="1" name="members_count[]"
                                            class="form-control" placeholder="{{ __('Members Count') }}"
                                            min="1" required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Client Type') }}</label>
                                        <select wire:model.defer="inputs.{{ $key }}.client_type_id"
                                            class="form-control" name="client_type_id[]"
                                            wire:change.debounce.250ms="changeClientType({{ $key }})"
                                            required>
                                            @foreach ($clientTypes as $clientType)
                                                <option value="{{ $clientType->id }}">{{ $clientType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1 mt-4">
                                    <a wire:click="removeInput({{ $key }})"
                                        class="remove-from-cart modal-effect mt-2" href="javascript:void(0);"><i
                                            class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-12 row">
                    <div class="col-3">
                        <label class="form-label">{{ __('Total Members') }}</label>
                        <input type="number" min="0" name="total_members" class="form-control"
                            wire:model="total_members" readonly>
                    </div>
                    <div class="col-3">
                        <label class="form-label">{{ __('Discounted') }}</label>
                        <input type="number" wire:keyup="updateTotals" min="0" name="discounted"
                            class="form-control" wire:model="discounted">
                        <input type="hidden" name="total_after_discount" wire:model="total_after_discount"
                            value="{{ $total_after_discount }}">
                    </div>
                    <div class="col-2">
                        <label class="form-label">{{ __('Total') }}</label>
                        <input type="number" step="any" min="0" name="total" class="form-control"
                            wire:model="total" required readonly>
                    </div>
                    @if ($is_taxed)
                        <div class="col-2">
                            <label class="form-label">{{ __('Tax 14%') }}</label>
                            <input type="number" min="0" name="tax" class="form-control"
                                wire:model="tax" required readonly>
                        </div>
                    @endif
                    <div class="col-2">
                        <label class="form-label">{{ __('Final Total') }}</label>
                        <input type="number" step="any" min="0" name="final_total" class="form-control"
                            wire:model="final_total" required readonly>
                    </div>
                </div>

                <div class="w-100 mt-5" x-show="!$wire.credit_sales" x-transition>
                    <div class="col-md-12">
                        <button type="button" wire:click="addPaymentInput" class="btn btn-success mg-b-20"
                            {{ $remain <= 0 ? 'disabled' : '' }}>{{ __('Add Payment') }} <i
                                class="typcn typcn-plus"></i></button>
                    </div>
                    @foreach ($paymentInputs as $paymentKey => $paymentInput)
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="contact_{{ $paymentKey }}_input"
                                    class="profile-edit">{{ __('Payment') }} # {{ $paymentKey + 1 }}</label>
                                <div class="row">
                                    <div class="col-3">
                                        <select class="form-control"
                                            x-bind:name="!$wire.credit_sales ? 'payment_method_id[]' : null"
                                            wire:model.defer="paymentInputs.{{ $paymentKey }}.payment_method_id"
                                            wire:change="checkPaymentMethod({{ $paymentKey }})"
                                            x-bind:required="!$wire.credit_sales">
                                            <option value="">{{ __('Select') }}</option>
                                            @foreach ($paymentMethods as $paymentMethod)
                                                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <input placeholder ="{{ __('Enter Paid Value') }}"
                                            wire:model.defer="paymentInputs.{{ $paymentKey }}.paid" type="number"
                                            step="any" class="form-control"
                                            x-bind:name="!$wire.credit_sales ? 'paid[]' : null"
                                            wire:keyup.debounce.250ms="updateRemain({{ $paymentKey }})"
                                            x-bind:min="!$wire.credit_sales ? 1 : 0"
                                            x-bind:data-parsley-min="!$wire.credit_sales ? 1 : 0"
                                            x-bind:required="!$wire.credit_sales">
                                    </div>
                                    @if (count($paymentInputs) > 1)
                                        <div class="col-1">
                                            <a wire:click="removePaymentInput({{ $paymentKey }})"
                                                class="remove-from-cart modal-effect mt-2"
                                                href="javascript:void(0);"><i class="fa fa-trash"></i></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <label class="mt-5 form-label pr-2">{{ __('Remain') }}: {{ $remain }}</label>
            @endif
        </div>
    </fieldset>
</div>

@push('js')
    <script type="text/javascript">
        function initParsley() {
            const form = document.getElementById('my-form-id');
            if (form) {
                $(form).parsley().reset();
                $(form).parsley();
            }
        }
    </script>

    <script>
        Livewire.on('initSelect2Drop', () => {
            initSelect2Drop();
        });

        function initSelect2Drop() {
            setTimeout(() => {
                $('.select2-multi').select2({
                    language: "{{ app()->getLocale() }}",
                    dir: "{{ session()->get('rtl', 1) ? 'rtl' : 'ltr' }}",
                    placeholder: "{{ __('Search...') }}",
                }).on('change', function(e) {
                    let selectName = $(this).attr('name');
                    const value = e.target.value;
                    if (selectName === 'booking_id') {
                        @this.set('booking_id', value);
                        @this.call('getBookingData');
                        @this.call('getClients');
                    } else if (selectName === 'client_id') {
                        @this.set('client_id', value);
                    }
                    @this.call('checkClientValidation');
                });
            }, 1);
        }

        Livewire.on('clearClientSelect2', () => {
            setTimeout(() => {
                $('select[name="client_id"]').val(null).trigger('change');
            }, 3);
        });
    </script>
@endpush
