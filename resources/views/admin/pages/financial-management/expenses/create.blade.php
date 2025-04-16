@extends('admin.layouts.master')
@section('page_title', __('New Expense'))
@section('breadcrumb')
    @include('admin.partials.breadcrumb', ['breads' => [__('Expenses'), __('New Expense')]])
@endsection

@push('css')
    <link href="{{asset('assets/admin')}}/plugins/fileuploads/css/fileupload.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route(auth()->getDefaultDriver().'.expenses.store') }}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
                            @csrf
                            <div class="modal-body m-2">
                                <div class="col-md-6">
                                    <label for="name">{{__('Date')}} <small class="mr-2 text-info"> {{__("Do not choose date if you want to use current date.")}}</small></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input class="form-control fc-datepicker" placeholder="YYYY-MM-DD" type="text" data-parsley-errors-container="#date" name="expense_date">
                                    </div>
                                    <div id="date"></div>
                                </div>

                                <div class="row m-1 mt-4">
                                    <div class="col-8 row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">{{__('Value')}} <span class="tx-danger">*</span></label>
                                                <input class="form-control" name="value" placeholder="{{__('Enter Expenses Value')}}" required step=".5" type="number" value="{{old('value')}}">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">{{__('Currency')}} <span class="tx-danger">*</span></label>
                                                <select class="form-control" name="currency_id" required>
                                                    <option value="">{{ __('Select') }}</option>
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}" {{ old('currency_id') == $currency->id || $currency->id == $defaultCurrency->id ? 'selected' : '' }}>
                                                            {{ $currency->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">{{ __('Expenses Type') }} <span class="tx-danger">*</span></label>
                                                <select class="form-control" name="expenses_type_id" required>
                                                    <option value="">{{ __('Select') }}</option>
                                                    @foreach ($expensesTypes as $expensesType)
                                                        <option value="{{ $expensesType->id }}" {{ old('expenses_type_id') == $expensesType->id ? 'selected' : '' }}>
                                                            {{ $expensesType->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            @if (feature('regions-branches-feature') || feature('branches-feature'))
                                                <livewire:adminroleauthmodule::region-branch :requiredBranch='true' />
                                            @endif
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">{{__('Note')}}</label>
                                                <textarea class="form-control" name="note" placeholder="{{__('Enter your note')}}" rows="4">{{old('note')}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">{{__('Image')}}</label>
                                            <input type="file" accept="image/*" name="image" class="dropify" data-default-file="">
                                        </div>
                                    </div>
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
	<script src="{{asset('assets/admin')}}/plugins/jquery-ui/ui/widgets/datepicker.js"></script>

	<script type="text/javascript">
		$('.fc-datepicker').datepicker({
			showOtherMonths: true,
			selectOtherMonths: true,
			dateFormat: "yy-mm-dd",
			autoclose: true
		});
	</script>

    <script src="{{asset('assets/admin')}}/plugins/fileuploads/js/{{app()->getLocale()}}/fileupload.js"></script>
    <script src="{{asset('assets/admin')}}/plugins/fileuploads/js/{{app()->getLocale()}}/file-upload.js"></script>
@endpush
