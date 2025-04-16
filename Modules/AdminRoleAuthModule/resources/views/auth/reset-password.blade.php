@extends('admin.layouts.auth')
@section('page_title', __('Reset Password'))
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
                                <div class="mb-5 d-flex"> 
                                    <a href="javascript:void(0);">
                                        <img src="{{ $settings['site_icon']->getProcessedValue()??'' }}" class="sign-favicon logo-auth" alt="logo">
                                    </a>
                                    <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">{{$settings['site_name']->value??config('app.name')}}</h1>
                                </div>
                                <div class="main-card-signin d-md-flex">
                                    <div class="wd-100p">
                                        <div class="main-signin-header">
                                            <div class="">
                                                <h2>{{__('Welcome back!')}}</h2>
                                                <h4>{{__('Reset Your Password')}}</h4>
                                                <form method="POST" action="{{ route('admin.password.store') }}" autocomplete="off" data-parsley-validate>
                                                    @csrf
                                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                                    <div class="form-group">
                                                        <label>{{__('Email')}}</label>
                                                        <input name="email" value="{{old('email', $request->email)}}" class="form-control" placeholder="{{__('Enter your email')}}" type="email" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{__('New Password')}}</label>
                                                        <input name="password" class="form-control" placeholder="{{__('Enter your password')}}" type="password" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{__('Confirm Password')}}</label>
                                                        <input name="password_confirmation" class="form-control" placeholder="{{__('Re-enter your password')}}" type="password" required>
                                                    </div>
                                                    <button type="submit" class="btn ripple btn-main-primary btn-block">{{__('Reset Password')}}</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="main-signup-footer mg-t-20">
                                            <p>{{__('Already have an account?')}} <a href="{{route('admin.login')}}">{{__('Sign In')}}</a></p>
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
