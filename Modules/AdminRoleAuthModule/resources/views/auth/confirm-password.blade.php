@extends('admin.layouts.auth')
@section('page_title', __('Lock Screen'))
@push('css')
    <link href="{{asset('assets/admin')}}/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css" rel="stylesheet">
@endpush
@section('content')
<div class="container-fluid">
    <div class="row no-gutter">
        <div class="photo" @feature('background-image-feature')style="background-image: url('{{ $settings['site_background_image']->getProcessedValue()??'' }}');"@endfeature>
            <div class="col-md-6 col-lg-6 col-xl-5 bg-white mx-auto">
                <div class="login d-flex align-items-center py-2">
                    <!-- Demo content-->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="mb-5 d-flex"> <a href="javascript:void(0);"><img src="{{ $settings['site_icon']->getProcessedValue()??'' }}" class="sign-favicon logo-auth" alt="logo"></a><h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">{{$settings['site_name']->value??config('app.name')}}</h1></div>
                                <div class="main-card-signin d-md-flex bg-white">
                                    <div class="wd-100p">
                                        <div class="main-signin-header">
                                            <h2 class="mb-4">{{__('Account Locked')}}</h2>
                                            <div class="avatar avatar-xxl avatar-xxl mx-auto text-center mb-2"><img alt="{{auth()->user()->name}}" class="avatar avatar-xxl rounded-circle  mt-2 mb-2 " src="{{auth()->user()->image}}"></div>
                                            <div class="mx-auto text-center mt-4 mg-b-20">
                                                <h5 class="mg-b-10 tx-16">{{auth()->user()->name}}</h5>
                                                <p class="tx-13 text-muted">{{__('Enter Your Password to View your Screen')}}</p>
                                            </div>
                                            <form action="{{ route(auth()->getDefaultDriver().'.password.confirm') }}" method="post" autocomplete="off" data-parsley-validate>
                                                @csrf
                                                <div class="form-group">
                                                    <input name="password" class="form-control" placeholder="{{__('Enter your password')}}" type="password" required>
                                                </div>
                                                <button class="btn btn-main-primary btn-block">{{__('Unlock')}}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->
        </div>
    </div>
</div>
@endsection
