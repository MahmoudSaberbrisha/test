<div x-data="{ phoneSection: @entangle('phoneSection'), codeSection: @entangle('codeSection'), resetSection: @entangle('resetSection') }">
    <div wire:loading class="text-center mg-b-20 mb-4 mt-2 w-100">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>
    <div class="main-signin-header" x-show="phoneSection">
        <h2>{{__('Forgot Password!')}}</h2>
        <h4>{{__('Please Enter Your Mobile Phone')}}</h4>
        <div class="form-group">
            <label>{{__('Mobile Phone')}}</label> 
            <input wire:model='phone' class="form-control" placeholder="{{__('Enter your phone')}}" id="phone" type="text" required>
        </div>
        <button type="button" wire:click="checkPhoneNumber" id="sign-in-button" class="btn btn-main-primary btn-block">{{__('Send')}}</button>
    </div>

    <div class="main-signin-header" x-show="codeSection">
        <h2>{{__('Forgot Password!')}}</h2>
        <h4>{{__('Please Enter Sending Code')}}</h4>
        <div class="form-group">
            <label>{{__('OTP Code')}}</label> 
            <input wire:model='otp' class="form-control" placeholder="{{__('Enter OTP Code')}}" id="otp" type="text" required>
        </div>
        <button type="button" wire:click="checkOtpCode" id="sign-in-button" class="btn btn-main-primary btn-block">{{__('Send')}}</button>
    </div>

    <div class="main-signin-header" x-show="resetSection">
        <div class="">
            <h2>{{__('Welcome back!')}}</h2>
            <h4>{{__('Reset Your Password')}}</h4>
            <form method="POST" action="{{ route('admin.password.firebase-store') }}" autocomplete="off" data-parsley-validate>
                @csrf
                <div class="form-group">
                    <label>{{__('New Password')}}</label>
                    <input name="password" class="form-control" placeholder="{{__('Enter your password')}}" type="password" required>
                </div>
                <div class="form-group">
                    <label>{{__('Confirm Password')}}</label>
                    <input name="password_confirmation" class="form-control" placeholder="{{__('Re-enter your password')}}" type="password" required>
                </div>
                <input name="phone" value="{{$phone}}" type="hidden">
                <button type="submit" class="btn ripple btn-main-primary btn-block">{{__('Reset Password')}}</button>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script type="text/javascript">
        Livewire.on('alert', (event)=>{
            console.log(event[0].type);
            toastr[event[0].type](event[0].message,
            event[0].title);
        });
    </script>

    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js"></script>

    <script type="text/javascript">
        Livewire.on('sendOTP', (event)=>{
            const firebaseConfig = {
                apiKey: "{{$firebaseSettings['api_key']??''}}",
                authDomain: "{{$firebaseSettings['project_id']??''}}.firebaseapp.com",
                projectId: "{{$firebaseSettings['project_id']??''}}",
                storageBucket: "{{$firebaseSettings['project_id']??''}}.firebasestorage.app",
                messagingSenderId: "{{$firebaseSettings['sender_id']??''}}",
                appId: "{{$firebaseSettings['app_id']??''}}"
            };

            firebase.initializeApp(firebaseConfig);
            firebase.auth().languageCode = 'ar';

            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('sign-in-button', {
                'size': 'invisible',
                'callback': (response) => {
                    sendOTP();
                }
            });
            const phoneNumber = ''+event+'';
            const appVerifier = window.recaptchaVerifier;
            firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
            .then((confirmationResult) => {
                window.confirmationResult = confirmationResult;
                Livewire.dispatch('showCodeForm');
            }).catch((error) => {
                console.error(error);
            });
        });

        Livewire.on('verifyOTP', (data)=>{
            const otp = data[0];
            window.confirmationResult.confirm(otp)
                .then((result) => {
                    Livewire.dispatch('showResetForm');
                })
                .catch((error) => {
                    console.log(error);
                    Livewire.dispatch('alertMessage', {message:'Invalid OTP code.', type:'error', title:'error'});
                });
        });
    </script> 
@endpush