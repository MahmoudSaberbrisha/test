@extends('admin.layouts.master')
@section('page_title', __('General Settings'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Settings'), __('General Settings')]])
@endsection

@push('css')
    <link href="{{asset('assets/admin')}}/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
        <form class="row row-sm" method="POST" action="{{route(auth()->getDefaultDriver().'.general-settings.update', 0)}}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
            @csrf
            @method('PUT')
            <div class="col-xl-8 col-lg-8 col-md-12 mb-3 mb-md-0">
                <div class="card">
                    <div class="card-body">
                        <livewire:adminroleauthmodule::general-settings />
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">{{__('Keywords')}}</label>
                                <input class="form-control" name="site_keywords" placeholder="{{__('Enter Keywords')}}" required type="text" value="{{$settings['site_keywords']->getProcessedValue()}}">
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn ripple btn-primary ml-3" type="submit" name="save" value="close">{{__('Save')}}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">
                            <livewire:adminroleauthmodule::change-language />
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>{{__('Logo')}}</label>
                                <input type="file" accept="image/*" name="site_logo" data-show-remove="false" class="dropify" data-default-file="{{$settings['site_logo']->getProcessedValue()}}" >
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>{{__('Icon')}}</label>
                                <input type="file" accept="image/*" name="site_icon" data-show-remove="false" class="dropify" data-default-file="{{$settings['site_icon']->getProcessedValue()}}" >
                            </div>
                        </div>
                        @feature('background-image-feature')
                        <div class="col-12">
                            <div class="form-group">
                                <label>{{__('Background Image')}}</label>
                                <input type="file" accept="image/*" name="site_background_image" data-show-remove="false" class="dropify" data-default-file="{{$settings['site_background_image']->getProcessedValue()}}" >
                            </div>
                        </div>
                        @endfeature
                    </div>
                </div>    
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script src="{{asset('assets/admin')}}/plugins/fileuploads/js/{{app()->getLocale()}}/fileupload.js"></script>
    <script src="{{asset('assets/admin')}}/plugins/fileuploads/js/{{app()->getLocale()}}/file-upload.js"></script>
@endpush