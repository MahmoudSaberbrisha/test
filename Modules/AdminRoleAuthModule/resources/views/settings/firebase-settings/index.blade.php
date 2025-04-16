@extends('admin.layouts.master')
@section('page_title', __('Firebase Settings'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Settings'), __('Firebase Settings')]])
@endsection

@section('content')
        <div class="col-xl-12 col-lg-12 col-md-12 mb-3 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form class="row row-sm" method="POST" action="{{route(auth()->getDefaultDriver().'.firebase-settings.update', 0)}}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
                        @csrf
                        @method('PUT')
                        <div class="row mb-20 m-0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="api_key" class="profile-edit">{{__('API Key')}} </label>
                                    <input placeholder="{{__('Enter')}} API Key" required type="text" class="form-control" id="api_key" name="api_key" value="{{$settings->getProcessedValue()['api_key']??''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project_id" class="profile-edit">{{__('Project ID')}} </label>
                                    <input placeholder="{{__('Enter')}} Project ID" required type="text" class="form-control" id="project_id" name="project_id" value="{{$settings->getProcessedValue()['project_id']??''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sender_id" class="profile-edit">{{__('Messaging Sender ID')}} </label>
                                    <input placeholder="{{__('Enter')}} Messaging Sender ID" required type="text" class="form-control" id="sender_id" name="sender_id" value="{{$settings->getProcessedValue()['sender_id']??''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="app_id" class="profile-edit">{{__('App ID')}} </label>
                                    <input placeholder="{{__('Enter')}} App ID" required type="text" class="form-control" id="app_id" name="app_id" value="{{$settings->getProcessedValue()['app_id']??''}}">
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn ripple btn-primary ml-3" type="submit" name="save" value="close">{{__('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
