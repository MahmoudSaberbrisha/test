@extends('admin.layouts.auth')
@section('page_title', __('Dashboard Login'))
@push('css')
<link href="{{asset('assets/admin')}}/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css" rel="stylesheet">
@endpush
@section('content')
<div class="container-fluid ">
    <div class="row no-gutter">
        <div class="photo" @feature('background-image-feature')style="background-image: url('{{ $settings['site_background_image']->getProcessedValue()??'' }}');"@endfeature>
            <div class="col-md-6 col-lg-6 col-xl-6 bg-white mx-auto">
                <div class="login d-flex align-items-center py-2">
                    <!-- Demo content-->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="card-sigin">
                                    <div class="mb-5 d-flex">
                                        <a href="javascript:void(0);">
                                            <img src="{{asset('assets/admin/img/photos/m.jpg')}}" alt="logo">
                                        </a>
                                        {{-- <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">{{$settings['site_name']->value??config('app.name')}}</h1> --}}
                                    </div>
                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            <h2>{{__('Welcome back!')}}</h2>
                                            <h5 class="font-weight-semibold mb-4">{{__('Please sign in to continue.')}}</h5>
                                            <form method="POST" action="{{ route('admin.login') }}" autocomplete="off" data-parsley-validate>
                                                @csrf
                                                @foreach ((array) $errors->get('throttle') as $message)
                                                    <p class="text-danger" id="throttle">{!! __($message) !!}</p>
                                                @endforeach
                                                <div class="form-group">
                                                    <label>{{__('UserName or Code')}}</label>
                                                    <input value="{{old('code')}}" autofocus autocomplete="nope" class="form-control" placeholder="{{__('Enter your code or username')}}" type="text" name="code" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__('Password')}}</label>
                                                    <input value="{{old('password')}}" class="form-control" placeholder="{{__('Enter your password')}}" type="password" name="password" required>
                                                </div>
                                                <div class="form-group justify-content-end">
                                                    <label class="ckbox">
                                                        <input name="remember" type="checkbox" data-checkboxes="mygroup"  id="checkbox-2" {{old('remember')?'checked':''}}><span class="tx-13">{{__('Remember me on this device')}}</span>
                                                    </label>
                                                </div>
                                                <button class="btn btn-main-primary btn-block" type="submit">{{__('Sign In')}}</button>
                                            </form>
                                            @feature('smtp-feature')
                                                <div class="main-signin-footer mt-5">
                                                    <p><a href="{{ route('admin.password.request') }}">{{__('Forgot password?')}}</a></p>
                                                </div>
                                            @endfeature
                                            @feature('firebase-feature')
                                                <div class="main-signin-footer mt-5">
                                                    <p><a href="{{ route('admin.password.request') }}">{{__('Forgot password?')}}</a></p>
                                                </div>
                                            @endfeature
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
