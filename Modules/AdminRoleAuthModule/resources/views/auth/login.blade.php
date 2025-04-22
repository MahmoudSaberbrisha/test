<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session()->get('rtl', 1) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @section('page_title', __('Dashboard Login'))
    <meta name="Description" content="{{ $settings['site_description']->value }}">
    <meta name="Keywords" content="{{ $settings['site_keywords']->value }}" />
    <meta name="language" content="{{ app()->getLocale() }}">
    <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}">
    {{-- <link rel="stylesheet" href="SignUp_LogIn_Form.css" /> --}}
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets') }}/SignUp_LogIn_Form.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/style.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/shiny_black_background.css" />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.6.4/dat.gui.min.js'></script>
    <script src="{{ asset('assets') }}/script.js"></script>

</head>

<body
    style="display: flex; justify-content: center; align-items: center; min-height: 100vh; position: relative; overflow: hidden;">
    <div class="moon-container">
        <div class="main-moon"></div>
        <div class="orbiting-moon moon1"></div>
        <div class="orbiting-moon moon2"></div>
        <div class="orbiting-moon moon3"></div>
        <div class="orbiting-moon moon4"></div>
        <div class="orbiting-moon moon5"></div>
    </div>
    <div class="stars-container"></div>
    <div class="container">
        <div class="photo" @feature('background-image-feature')
                style="background-image: url('{{ $settings['site_background_image']->getProcessedValue() ?? '' }}');"
            @endfeature>

            <div class="form-box login">

                <form method="POST" action="{{ route('admin.login') }}" autocomplete="off" data-parsley-validate>
                    @csrf
                    @foreach ((array) $errors->get('throttle') as $message)
                        <p class="text-danger" id="throttle">{!! __($message) !!}</p>
                    @endforeach

                    <div class="mb-5 d-flex">
                        <a href="javascript:void(0);">
                            <img src="{{ asset('assets/admin/img/photos/m.jpg') }}" alt="logo">
                        </a>
                        <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">
                            {{ $settings['site_name']->value ?? config('app.name') }}
                        </h1>
                    </div>

                    <div class="input-box">
                        <input value="{{ old('code') }}" autofocus autocomplete="nope" class="form-control"
                            placeholder="{{ __('Enter your code or username') }}" type="text" name="code"
                            required />
                        <i class="bx bxs-user"></i>
                    </div>

                    <div class="input-box">
                        <input value="{{ old('password') }}" class="form-control"
                            placeholder="{{ __('Enter your password') }}" type="password" name="password" required />
                        <i class="bx bxs-lock-alt"></i>
                    </div>
                    <div class="form-group justify-content-end">
                        <label class="ckbox">
                            <input name="remember" type="checkbox" data-checkboxes="mygroup" id="checkbox-2"
                                {{ old('remember') ? 'checked' : '' }}><span
                                class="tx-13">{{ __('Remember me on this device') }}</span>
                        </label>
                    </div>

                    <button type="submit" class="btn">{{ __('Sign In') }}</button>
                    @feature('smtp-feature')
                        <div style="color: black">
                            <p><a href="{{ route('admin.password.request') }}">{{ __('Forgot password?') }}</a></p>
                        </div>
                    @endfeature
                    @feature('firebase-feature')
                        <div style="color: black">
                            <p><a href="{{ route('admin.password.request') }}">{{ __('Forgot password?') }}</a></p>
                        </div>
                    @endfeature
                    {{-- <p>or login with social platforms</p>
                    <div class="social-icons">
                        <a href="#"><i class="bx bxl-google"></i></a>
                        <a href="#"><i class="bx bxl-facebook"></i></a>
                        <a href="#"><i class="bx bxl-github"></i></a>
                        <a href="#"><i class="bx bxl-linkedin"></i></a>
                    </div> --}}
                </form>

                </div>

            </form>


            <div class="form-box register">
                <form action="#">
                    <h1>Registration</h1>
                    <div class="input-box">
                        <input type="text" placeholder="Username" required />
                        <i class="bx bxs-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="email" placeholder="Email" required />
                        <i class="bx bxs-envelope"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Password" required />
                        <i class="bx bxs-lock-alt"></i>
                    </div>
                    <button type="submit" class="btn">Register</button>
                    <p>or register with social platforms</p>
                    <div class="social-icons">
                        <a href="#"><i class="bx bxl-google"></i></a>
                        <a href="#"><i class="bx bxl-facebook"></i></a>
                        <a href="#"><i class="bx bxl-github"></i></a>
                        <a href="#"><i class="bx bxl-linkedin"></i></a>
                    </div>
                </form>
            </div>

            <div class="toggle-box">
                <div class="toggle-panel toggle-left">
                    <h1>Hello, Welcome!</h1>
                    <p>Don't have an account?</p>
                    <button class="btn register-btn">Register</button>
                </div>

                <div class="toggle-panel toggle-right">
                    <h1>Welcome Back!</h1>
                    <p>Already have an account?</p>
                    <button class="btn login-btn">Login</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.querySelector(".container");
        const registerBtn = document.querySelector(".register-btn");
        const loginBtn = document.querySelector(".login-btn");
        registerBtn.addEventListener("click", () => {
            container.classList.add("active");
        });
        loginBtn.addEventListener("click", () => {
            container.classList.remove("active");
        });
    </script>
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
</body>

</html>
