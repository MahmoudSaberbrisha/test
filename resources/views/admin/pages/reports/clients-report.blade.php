@extends('admin.layouts.master')
@section('page_title', __("Clients Report"))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Reports'), __('Clients Report')]])
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <livewire:reports.clients-report />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
