@extends('admin.layouts.auth')
@section('page_title', __('Forget Password'))
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

                                        <livewire:adminroleauthmodule::firebase-forget-password />
                                        
                                        <div class="main-signup-footer mg-t-20">
                                            <p>{{__('Forget it,')}} <a href="{{route('admin.login')}}"> {{__('Send me back')}}</a> {{__('to the sign in screen.')}}</p>
                                        </div>
                                    </div>
                                    <div id="recaptcha-container"></div>
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

@push('js')
    <script>
        var elem = document.getElementById('countdown');
        if (elem) {
            var timeLeft = elem.textContent;
            var timerId = setInterval(countdown, 1000);
        }

        function countdown() {
            if (timeLeft == -1) {
                clearTimeout(timerId);
                document.getElementById('throttle').remove();
            } else {
                elem.innerHTML = timeLeft;
                timeLeft--;
            }
        }
    </script>
@endpush