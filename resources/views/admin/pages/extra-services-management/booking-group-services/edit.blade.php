@extends('admin.layouts.master')
@section('page_title', __('Booking Extra Services'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Extra Services Management'), __('Booking Extra Services')]])
@endsection

@push('css')
<link href="{{asset('assets/admin')}}/plugins/select2/css/select2.min.css" rel="stylesheet">

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
                        <form method="POST" action="{{ route(auth()->getDefaultDriver() . '.booking-extra-services.update', $booking_group_id) }}" enctype="multipart/form-data" autocomplete="nop" id="my-form-id" data-parsley-validate>
                            @csrf
                            @method('PUT')
                            <div class="modal-body row m-2">
                                <livewire:extra-services.booking-group-services :booking_group_id='$booking_group_id' />
                            </div>
                            @include('adminroleauthmodule::includes.save-buttons')
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
@endpush