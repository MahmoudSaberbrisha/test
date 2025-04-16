@extends('admin.layouts.auth')
@section('page_title', __('Email Sent'))
@section('content')
<div class="container-fluid">
    <div class="row no-gutter">
        <div class="col-md-6 col-lg-6 col-xl-6 bg-white mx-auto">
            <div class="login d-flex align-items-center py-2">
                <!-- Demo content-->
                <div class="container p-0">
                    <div class="row">
                        <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                        <div class="mb-5 d-flex"> <a href="javascript:void(0);"><img src="{{ $settings['site_icon']->getProcessedValue()??'' }}" class="sign-favicon logo-auth" alt="logo"></a><h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">{{$settings['site_name']->value??config('app.name')}}</h1></div>
                            <div class="main-card-signin d-md-flex bg-white">
                                <div class="wd-100p">
                                    <div class="main-signin-header">
                                        <h2 class="h1 mb-4">{{__("Check your inbox")}}</h2>
                                        <p class="fs-h3 text-secondary">
                                            {{__("We've sent you a reset link to")}} <strong>{{$email}}</strong>.<br />
                                            {{__("Please click the link to reset your password.")}}
                                        </p>
                                    </div>
                                    <div class="main-signup-footer mg-t-20">
                                        <p>{{__("Can't see the email? Please check the spam folder.")}}<br />
                                            {{__("Wrong email? Please")}} <a href="{{route('admin.password.request')}}">{{__("re-enter your email address")}}</a>.
                                        </p>
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
@endsection
