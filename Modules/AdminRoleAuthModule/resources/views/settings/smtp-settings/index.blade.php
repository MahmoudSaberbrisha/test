@extends('admin.layouts.master')
@section('page_title', __('SMTP Settings'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Settings'), __('SMTP Settings')]])
@endsection

@section('content')
        <div class="col-xl-12 col-lg-12 col-md-12 mb-3 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form class="row row-sm" method="POST" action="{{route(auth()->getDefaultDriver().'.smtp-settings.update', 0)}}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
                        @csrf
                        @method('PUT')
                        <div class="row mb-20 m-0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Mail" class="profile-edit">{{__('Mail Encryption')}} </label>
                                    <input placeholder="{{__('Enter Mail Encryption')}}" required type="text" class="form-control" id="Mail" name="mail_encryption" value="{{$settings->getProcessedValue()['mail_encryption']??''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="SMTP" class="profile-edit">{{__('SMTP Host')}} </label>
                                    <input placeholder="{{__('Enter SMTP Host')}}" required type="text" class="form-control" id="SMTP" name="mail_host" value="{{$settings->getProcessedValue()['mail_host']??''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Port" class="profile-edit">{{__('Mail Port')}} </label>
                                    <input placeholder="{{__('Enter Mail Port')}}" required type="text" class="form-control" id="Port" name="mail_port" value="{{$settings->getProcessedValue()['mail_port']??''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="User" class="profile-edit">{{__('User Email')}} </label>
                                    <input placeholder="{{__('Enter User Email')}}" required type="text" class="form-control" id="User" name="mail_useremail" value="{{$settings->getProcessedValue()['mail_useremail']??''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group main-password">
                                    <label for="password1" class="profile-edit">{{__('Password')}} </label>
                                    <input placeholder="{{__('Enter Password')}}" required type="password" class="form-control" id="password1" name="mail_password" autocomplete="new-password" value="{{$settings->getProcessedValue()['mail_password']!=''?decrypt($settings->getProcessedValue()['mail_password']):''}}">
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn ripple btn-primary ml-3" type="submit" name="save" value="close">{{__('Save')}}</button>
                            </div>
                        </div>
                    </form>

                    <div class="col-12 mt-5">
                        <hr style="width:100%">
                    </div>

                    <div class="col-12 mt-5 mb-30">
                        <h5>{{__('Try SMTP Configuration Settings')}}</h5>
                    </div>
                    <form action="{{route(auth()->getDefaultDriver().'.sendTestEmail', true)}}" method="POST" data-parsley-validate="" novalidate="">
                        @csrf
                        <div class="row mt-4 m-0">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Mail1" class="profile-edit">{{__('Email Address')}} </label>
                                    <input placeholder="{{__('Enter Email Address')}}" required type="email" class="form-control" id="Mail1" name="email">
                                    <small>{{__('Email address to send test email to.')}}</small>
                                </div>
                            </div>

                            <div class="col-md-6 mt-4 pt-1">
                                <button class="btn ripple btn-primary ml-3" type="submit" name="save" value="close">{{__('Send Test Email')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
