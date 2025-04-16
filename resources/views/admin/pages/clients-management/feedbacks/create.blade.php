@extends('admin.layouts.master')
@section('page_title', __('Add Feedback'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Clients Management'), __('Add Feedback')]])
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route(auth()->getDefaultDriver() . '.feedbacks.store') }}" enctype="multipart/form-data" autocomplete="nop" id="my-form-id" data-parsley-validate>
                            @csrf
                            <div class="modal-body m-2">

                                <livewire:clients-management.create-edit-feedback />
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
