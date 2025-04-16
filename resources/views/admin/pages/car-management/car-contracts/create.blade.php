@extends('admin.layouts.master')
@section('page_title', __('New Car Contract'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Car Management'), __('New Car Contract')]])
@endsection

@push('css')
    <link href="{{asset('assets/admin')}}/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/admin')}}/plugins/select2/css/select2.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route(auth()->getDefaultDriver() . '.car-contracts.store') }}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
                        @csrf
                        <div class="modal-body row">
                            <div class="col-8 row">
                                <div class="col-4">
                                    <div class="form-group" wire:ignore>
                                        <label class="form-label">{{ __('Car Supplier') }} <span class="tx-danger">*</span></label>
                                        <select class="form-control select2" name="car_supplier_id" required data-parsley-errors-container="#car_supplier_id_error">
                                            <option value="">{{ __('Select') }}</option>
                                            @foreach ($carSuppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ old('car_supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">{{__('Car Type')}} <span class="tx-danger">*</span></label>
                                        <input class="form-control" name="car_type" placeholder="{{__('Enter Car Type')}}" required type="text" value="{{ old('car_type') }}">
                                    </div>
                                </div>

                                <div class="col-4">
                                    @if (feature('regions-branches-feature') || feature('branches-feature'))
                                        <livewire:adminroleauthmodule::region-branch :requiredBranch='true' />
                                    @endif
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">{{__('Currency')}} <span class="tx-danger">*</span></label>
                                        <select class="form-control" name="currency_id" required>
                                            <option value="">{{ __('Select') }}</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}" {{ old('currency_id') == $currency->id || $currency->id == $defaultCurrency->id ? 'selected' : '' }}>
                                                    {{ $currency->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Passenger Number') }} <span class="tx-danger">*</span></label>
                                        <input class="form-control" name="passengers_num" placeholder="{{ __('Enter Passenger Number') }}" required type="number" value="{{ old('passengers_num') }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="license_expiration_date">{{__('License Expiration Date')}} <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="date" name="license_expiration_date" required data-parsley-errors-container="#license_expiration_date" value="{{ old('license_expiration_date') }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="contract_start_date">{{__('Contract Start Date')}} <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="date" name="contract_start_date" required data-parsley-errors-container="#contract_start_date" value="{{ old('contract_start_date') }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="contract_end_date">{{__('Contract End Date')}} <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="date" name="contract_end_date" required data-parsley-errors-container="#contract_end_date" value="{{ old('contract_end_date') }}">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Total') }} <span class="tx-danger">*</span></label>
                                        <input class="form-control" id="total" name="total" placeholder="{{ __('Enter Total') }}" step=".5" required type="number" value="{{ old('total') }}">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Paid') }} <span class="tx-danger">*</span></label>
                                        <input class="form-control" id="paid" name="paid" placeholder="{{ __('Enter Paid Value') }}" step=".5" required type="number" value="{{ old('paid') }}">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('Remain') }} <span class="tx-danger">*</span></label>
                                        <input class="form-control" id="remain" name="remain" placeholder="{{ __('Remain') }}" type="number" value="{{ old('remain', 0) }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">{{__('Image')}}</label>
                                        <input type="file" accept="image/*" name="image" class="dropify" data-default-file="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">{{__('Notes')}} </label>
                                    <textarea rows="4" placeholder="{{__('Notes')}}" class="form-control" name="notes">{{ old('notes') }}</textarea>
                                </div>
                            </div>

                            @include('adminroleauthmodule::includes.save-buttons')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/admin')}}/plugins/fileuploads/js/{{app()->getLocale()}}/fileupload.js"></script>
    <script src="{{asset('assets/admin')}}/plugins/fileuploads/js/{{app()->getLocale()}}/file-upload.js"></script>

    <script src="{{asset('assets/admin')}}/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{asset('assets/admin')}}/plugins/select2/js/i18n/{{ app()->getLocale() }}.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2({
                language: "{{ app()->getLocale() }}",
                dir: "{{ session()->get('rtl', 1) ? 'rtl' : 'ltr' }}",
                placeholder: "{{ __('Select') }}",
            });

            function calculateRemain() {
                const total = parseFloat($('#total').val()) || 0;
                const paid = parseFloat($('#paid').val()) || 0;

                if (paid > total) {
                    $('#paid').val(total);
                    $('#remain').val(0);
                } else {
                    const remain = total - paid;
                    $('#remain').val(remain.toFixed(2));
                }
            }
            $('#total, #paid').on('input', calculateRemain);
            calculateRemain();
        });
    </script>
@endpush