@extends('admin.layouts.master')
@section('page_title', __('New Car Task'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Car Management'), __('New Car Task')]])
@endsection

@push('css')
    <link href="{{asset('assets/admin')}}/plugins/select2/css/select2.min.css" rel="stylesheet">
    <link href="{{asset('assets/admin')}}/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css"/>
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
                        <form method="POST" action="{{ route(auth()->getDefaultDriver() . '.car-tasks.store') }}" enctype="multipart/form-data" autocomplete="nop" id="my-form-id" data-parsley-validate>
                            @csrf
                            <div class="modal-body m-2">

                                <livewire:car-management.create-edit-car-task />
                                
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

    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2({
                language: "{{ app()->getLocale() }}",
                dir: "{{ session()->get('rtl', 1) ? 'rtl' : 'ltr' }}",
                placeholder: "{{ __('Select') }}",
            });
        });
    </script>
@endpush
