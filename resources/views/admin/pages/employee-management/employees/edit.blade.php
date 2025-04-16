@extends('admin.layouts.master')
@section('page_title', __('Edit Employee'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Employees'), __('Edit Employee')]])
@endsection

@push('css')
    <link href="{{ asset('assets/admin') }}/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route(auth()->getDefaultDriver() . '.employees.update', $employee->id) }}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
                        @csrf
                        @method('PUT')
                        <div class="modal-body row m-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{ __('Image') }}</label>
                                    <input type="file" accept="image/*" name="image" class="dropify" data-default-file="{{ $employee->image }}" data-show-remove="false">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Name') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="name" placeholder="{{ __('Enter Name') }}" required type="text" value="{{ old('name', $employee->name) }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Employee Type') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="employee_type_id" required>
                                        <option value="">{{ __('Select') }}</option>
                                        @foreach ($employeeTypes as $employeeType)
                                            <option value="{{ $employeeType->id }}" {{ old('employee_type_id', $employee->employee_type_id) == $employeeType->id ? 'selected' : '' }}>{{ $employeeType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                @if (feature('regions-branches-feature') || feature('branches-feature'))
                                    <livewire:adminroleauthmodule::region-branch :region_id="$employee->region_id" :branch_id="$employee->branch_id" :requiredBranch='true' />
                                @endif
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Birthdate') }} <span class="tx-danger">*</span></label>
                                    <input type="date" name="birthdate" id="birthdate" class="form-control" value="{{ old('birthdate', $employee->birthdate) }}" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Phone') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="phone" placeholder="{{ __('Enter Phone') }}" required type="text" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" value="{{ old('phone', $employee->phone) }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="mobile">{{ __('Mobile') }}</label>
                                    <input type="text" name="mobile" id="mobile" data-parsley-type="digits" data-parsley-maxlength="14" class="form-control" value="{{ old('mobile', $employee->mobile) }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Nationality') }} </label>
                                    <select class="form-control" name="employee_nationality_id">
                                        <option value="">{{ __('Select') }}</option>
                                        @foreach ($employeeNationalities as $employeeNationality)
                                            <option value="{{ $employeeNationality->id }}" {{ old('employee_nationality_id', $employee->employee_nationality_id) == $employeeNationality->id ? 'selected' : '' }}>{{ $employeeNationality->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Religion') }}</label>
                                    <select class="form-control" name="employee_religion_id" >
                                        <option value="">{{ __('Select') }}</option>
                                        @foreach ($employeeReligions as $employeeReligion)
                                            <option value="{{ $employeeReligion->id }}" {{ old('employee_religion_id', $employee->employee_religion_id) == $employeeReligion->id ? 'selected' : '' }}>{{ $employeeReligion->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Marital Status') }}</label>
                                    <select class="form-control" name="employee_marital_status_id">
                                        <option value="">{{ __('Select') }}</option>
                                        @foreach ($maritalStatus as $status)
                                            <option value="{{ $status->id }}" {{ old('employee_marital_status_id', $employee->employee_marital_status_id) == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Identity Type') }} <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="employee_identity_type_id" required>
                                        <option value="">{{ __('Select') }}</option>
                                        @foreach ($identityTypes as $identityType)
                                            <option value="{{ $identityType->id }}" {{ old('employee_identity_type_id', $employee->employee_identity_type_id) == $identityType->id ? 'selected' : '' }}>{{ $identityType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Identity Number') }} <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="identity_num" placeholder="{{ __('Enter Identity Number') }}" required type="text" value="{{ old('identity_num', $employee->identity_num) }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Card Issuer') }} </label>
                                    <select class="form-control" name="employee_card_issuer_id">
                                        <option value="">{{ __('Select') }}</option>
                                        @foreach ($cardIssuers as $cardIssuer)
                                            <option value="{{ $cardIssuer->id }}" {{ old('employee_card_issuer_id', $employee->employee_card_issuer_id) == $cardIssuer->id ? 'selected' : '' }}>{{ $cardIssuer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Release Date') }}</label>
                                    <input type="date" name="release_date" id="release_date" class="form-control" value="{{ old('release_date', $employee->release_date) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Expiry Date') }}</label>
                                    <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ old('expiry_date', $employee->expiry_date) }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">{{__('Job')}} <span class="tx-danger">*</span></label>
                                    <select class="form-control" name="setting_job_id" required>
                                        <option value="">{{__('Select')}}</option>
                                        @foreach ($jobs as $job)
                                            <option value="{{$job->id}}" {{$employee->setting_job_id==$job->id?'selected':''}}>{{$job->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Salary') }} <span class="tx-danger">*</span></label>
                                    <input type="number" step="1" class="form-control" name="salary" placeholder="{{ __('Enter Salary') }}" required value="{{ old('salary', $employee->salary) }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Commission Rate') }}</label>
                                    <input type="number" step="0.5" class="form-control" name="commission_rate" placeholder="{{ __('Enter Commission Rate') }}" value="{{ old('commission_rate', $employee->commission_rate) }}">
                                </div>
                            </div>
                            @include('adminroleauthmodule::includes.save-buttons')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin') }}/plugins/fileuploads/js/{{ app()->getLocale() }}/fileupload.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/fileuploads/js/{{ app()->getLocale() }}/file-upload.js"></script>
@endpush