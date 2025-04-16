@extends('admin.layouts.master')
@section('page_title', __('Edit Car Task'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Car Management'), __('Edit Car Task')]])
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route(auth()->getDefaultDriver() . '.car-tasks.update', $carTask) }}" enctype="multipart/form-data" autocomplete="nop" id="my-form-id" data-parsley-validate>
                            @csrf
                            @method('PUT')
                            <div class="modal-body m-2">

                                <livewire:car-management.create-edit-car-task :carTaskId="$carTask->id" />

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
@endpush