@extends('admin.layouts.master')
@section('page_title', __("Extra Services Report"))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Reports'), __('Extra Services Report')]])
@endsection

@section('content')
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">{{__('Extra Services Report')}}</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @livewire('reports.extra-services-report')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
