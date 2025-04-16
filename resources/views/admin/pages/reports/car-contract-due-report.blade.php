@extends('admin.layouts.master')
@section('page_title', __("Car Contract Due Amount Report"))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Reports'), __('Car Contract Due Amount Report')]])
@endsection

@section('content')
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">{{__('Car Contract Due Amount Report')}}</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @livewire('reports.car-contract-due-report')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
