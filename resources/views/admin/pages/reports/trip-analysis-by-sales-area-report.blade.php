@extends('admin.layouts.master')
@section('page_title', __("Trip Analysis By Sales Area Report"))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Reports'), __('Trip Analysis By Sales Area Report')]])
@endsection

@section('content')
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">{{__('Trip Analysis By Sales Area Report')}}</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @livewire('reports.trip-analysis-by-sales-area-report')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
