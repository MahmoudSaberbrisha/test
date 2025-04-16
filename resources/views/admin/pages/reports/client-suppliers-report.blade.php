@extends('admin.layouts.master')
@section('page_title', __("Client Suppliers Report"))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Reports'), __('Client Suppliers Report')]])
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        @livewire('reports.client-suppliers-report')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
