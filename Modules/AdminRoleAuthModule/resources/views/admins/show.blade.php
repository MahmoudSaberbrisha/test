@extends('admin.layouts.master')
@section('page_title', __('Profile'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Profile'), __("Update Your Profile")]])
@endsection

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                            <div class="tabs-menu ">
                                <!-- Tabs -->
                                <ul class="nav nav-tabs profile navtab-custom panel-tabs">
                                    <li class="">
                                        <a href="#user-info" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span class="hidden-xs">{{__('User Info')}}</span> </a>
                                    </li>
                                    <li class="">
                                        <a href="#user-password" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-key tx-16 mr-1"></i></span> <span class="hidden-xs">{{__('User Password')}}</span> </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content border-left border-bottom border-right border-top-0 p-4">
                                <div class="tab-pane" id="user-info">
                                    <form method="POST" action="{{route(auth()->getDefaultDriver().'.update-account')}}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
                                        @csrf
                                        <div class="main-content-body main-content-body-contacts custom-card">
                                            <div class="main-contact-info-header pt-3">
                                                <div class="media">
                                                    <div class="main-img-user">
                                                        <img alt="avatar" id="imagePreview" src="{{auth()->guard('admin')->user()->image}}"> <a href="javascript:void(0)"><input type="file" style="position: absolute; z-index: 1; opacity: 0; cursor: pointer;" id="imageUpload" name="image" accept="image/*"><i class="fe fe-camera"></i></a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5>{{auth()->guard('admin')->user()->name}}</h5>
                                                        <p>{{auth()->guard('admin')->user()->user_name}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="main-contact-info-body p-4 row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('Name')}} <span class="tx-danger">*</span></label>
                                                        <input class="form-control" name="name" placeholder="{{__('Enter Name')}}" required type="text" value="{{auth()->guard('admin')->user()->name}}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('User Name')}} <span class="tx-danger">*</span></label>
                                                        <input class="form-control" name="user_name" placeholder="{{__('Enter User Name')}}" required type="text" value="{{auth()->guard('admin')->user()->user_name}}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('Phone')}} <span class="tx-danger">*</span></label>
                                                        <input class="form-control" name="phone" placeholder="{{__('Enter Phone')}}" required type="text" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" value="{{auth()->guard('admin')->user()->phone}}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('National ID')}}</label>
                                                        <input class="form-control" name="national_id" placeholder="{{__('Enter National ID')}}" type="text" value="{{auth()->guard('admin')->user()->national_id}}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('Email')}}</label>
                                                        <input class="form-control" name="email" placeholder="{{__('Enter Email')}}" type="email" value="{{auth()->guard('admin')->user()->email}}">
                                                    </div>
                                                </div>
                                                <div class="col-12 row pr-4 pt-3">
                                                    <button class="btn ripple btn-primary ml-3" type="submit" name="save" value="close">{{__('Save')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane" id="user-password">
                                    <form method="POST" action="{{route(auth()->getDefaultDriver().'.update-password')}}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
                                        @csrf
                                        <div class="row mb-20 m-0">
                                            <div class="col-md-6">
                                                <div class="form-group main-password">
                                                    <label for="oldPassword" class="profile-edit">{{__('Old Password')}} </label>
                                                    <input placeholder="{{__('Old Password')}}" type="password" id="oldPassword" name="oldpassword" class="form-control input-password" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group main-password">
                                                    <label for="newPassword" class="profile-edit">{{__('New Password')}} </label>
                                                    <input placeholder="{{__('New Password')}}" type="password" id="newPassword" name="password" class="form-control input-password" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group main-password">
                                                    <label for="retypePassword" class="profile-edit">{{__('Confirm Password')}} </label>
                                                    <input placeholder="{{__('Re-Enter Password')}}" type="password" id="retypePassword" name="password_confirmation" class="form-control input-password" required>
                                                </div>
                                            </div>
                                            <div class="col-12 row pr-4 pt-3">
                                                <button class="btn ripple btn-primary ml-3" type="submit" name="save" value="close">{{__('Save')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imagePreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function () {
            readURL(this);
        });
    </script>

    <script type="text/javascript">
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });

        var activeTab = localStorage.getItem('activeTab')??'user-info';
        if(activeTab){
            if ( $('a[href="' + activeTab + '"]').length > 0) {
                $('.panel-tabs a[href="' + activeTab + '"]').tab('show');
            } else {
                activeTab = "#user-info";
                $('.panel-tabs a[href="' + activeTab + '"]').tab('show');
            }
            var element = $('.panel-tabs a[href="' + activeTab + '"]');
            handleIndicator(element[0]);
        }
    </script>
@endpush