@extends('admin.layouts.master')
@section('page_title', __('New Admin'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Admins'), __('New Admin')]])
@endsection

@push('css')
    <link href="{{asset('assets/admin')}}/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{route(auth()->getDefaultDriver().'.admins.store')}}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
                            @csrf
                            <div class="modal-body row m-2">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{__('Image')}}</label>
                                        <input type="file" accept="image/*" name="image" class="dropify" data-default-file="" >
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">{{__('Name')}} <span class="tx-danger">*</span></label>
                                        <input class="form-control" name="name" placeholder="{{__('Enter Name')}}" required type="text" value="{{old('name')}}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">{{__('User Name')}} <span class="tx-danger">*</span></label>
                                        <input class="form-control" name="user_name" placeholder="{{__('Enter User Name')}}" required type="text" value="{{old('user_name')}}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">{{__('Phone')}} <span class="tx-danger">*</span></label>
                                        <input class="form-control" name="phone" placeholder="{{__('Enter Phone')}}" required type="text" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" value="{{old('phone')}}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">{{__('National ID')}}</label>
                                        <input class="form-control" name="national_id" placeholder="{{__('Enter National ID')}}" type="text" value="{{old('national_id')}}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">{{__('Email')}}</label>
                                        <input class="form-control" name="email" placeholder="{{__('Enter Email')}}" type="email" value="{{old('email')}}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">{{__('Roles')}} <span class="tx-danger">*</span></label>
                                        <input type="hidden" name="role_id" id="role_id" value="">
                                        <select class="form-control" name="role" required onchange="$('#role_id').val($(this).find(':selected').attr('data-role-id'))">
                                            <option value="">{{__('Select')}}</option>
                                            @foreach ($roles as $role)
                                                <option data-role-id="{{$role->id}}" value="{{$role->name}}" {{$role->name==old('role')?'selected':''}}>{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">{{__('Password')}} <span class="tx-danger">*</span></label>
                                        <input type="password" class="form-control" value="{{old('password')}}" name="password" placeholder="{{__('New Password')}}" minlength="8" required autocomplete="new-password">
                                        <small>{{__('8 characters minimum')}}</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">{{__('Confirm Password')}} <span class="tx-danger">*</span></label>
                                        <input type="password" placeholder="{{__('Re-Enter Password')}}" class="form-control" value="{{old('password_confirmation')}}" name="password_confirmation" minlength="8" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">{{__('Job')}} </label>
                                        <select class="form-control" name="setting_job_id">
                                            <option value="">{{__('Select')}}</option>
                                            @foreach ($jobs as $job)
                                                <option value="{{$job->id}}">{{$job->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    @if (feature('regions-branches-feature') || feature('branches-feature'))
                                        <livewire:adminroleauthmodule::region-branch />
                                    @endif
                                </div>
                                @include('adminroleauthmodule::includes.save-buttons')
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{asset('assets/admin')}}/plugins/fileuploads/js/{{app()->getLocale()}}/fileupload.js"></script>
    <script src="{{asset('assets/admin')}}/plugins/fileuploads/js/{{app()->getLocale()}}/file-upload.js"></script>
@endpush