@extends('admin.layouts.master')
@section('page_title', __("Booking Groups Report"))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Reports'), __('Booking Groups Report')]])
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        @livewire('reports.booking-groups-report')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
