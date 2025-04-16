@extends('admin.layouts.master')
@section('page_title', __('Edit Booking Group'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Bookings Management'), __('Edit Booking Group')]])
@endsection

@push('css')
<link href="{{asset('assets/admin')}}/plugins/select2/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/admin')}}/plugins/timepicker/jquery.datetimepicker.min.css">

<style>
    input[type="number"] {
        -moz-appearance: textfield; 
        appearance: textfield; 
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endpush

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route(auth()->getDefaultDriver() . '.booking-groups.update', $id) }}" enctype="multipart/form-data" autocomplete="nop" id="my-form-id" data-parsley-validate>
                            @csrf
                            @method('PUT')
                            <div class="modal-body m-2">

                                <livewire:booking-management.create-edit-booking-group :booking_group_id='$id' />

                                <div class="col-12 row pr-4">
                                    <button class="btn ripple btn-primary ml-3" type="submit" name="save" value="close">{{__('Save & Exit')}}</button>
                                    <button class="btn ripple btn-success ml-3" type="submit" name="save" value="continue">{{__('Save & Continue')}}</button>
                                    <button class="btn ripple btn-dark ml-3" type="submit" name="save" value="new">{{__('Save & New')}}</button>
                                    <button class="btn ripple btn-warning ml-3" type="submit" name="save" value="book">{{__('Save & Book Extra Service')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{asset('assets/admin')}}/plugins/select2/js/select2.full.min.js"></script>
<script src="{{asset('assets/admin')}}/plugins/select2/js/i18n/{{ app()->getLocale() }}.js"></script>
<script src="{{asset('assets/admin')}}/plugins/timepicker/jquery.datetimepicker.full.min.js"></script>
<script src="{{asset('assets/admin')}}/plugins/jquery-ui/ui/widgets/datepicker.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.select2-multi').select2({
            language: "{{ app()->getLocale() }}",
            dir: "{{ session()->get('rtl', 1) ? 'rtl' : 'ltr' }}",
            placeholder: "{{ __('Search...') }}",
        });
    });
</script>

<script>
    /*document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('form').addEventListener('submit', function (e) {
            document.querySelectorAll('fieldset:disabled input, fieldset:disabled select, fieldset:disabled textarea').forEach(el => {
                el.disabled = true;
            });
        });
    });*/
</script>
@endpush