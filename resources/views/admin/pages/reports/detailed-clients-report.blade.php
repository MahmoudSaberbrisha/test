@extends('admin.layouts.master')
@section('page_title', __("Detailed Clients Report"))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Reports'), __('Detailed Clients Report')]])
@endsection

@push('css')
    <link href="{{asset('assets/admin')}}/plugins/select2/css/select2.min.css" rel="stylesheet">
    <style type="text/css">
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <livewire:reports.detailed-clients-report />
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
