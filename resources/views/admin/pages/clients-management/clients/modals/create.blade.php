<div class="modal" id="modal-add">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">{{__('Add Client')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<form method="POST" action="{{route(auth()->getDefaultDriver().'.clients.store')}}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
				@csrf
				<div class="modal-body">
                    <div class="row m-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">{{__('Name')}} <span class="tx-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
	                        <div class="form-group">
	                            <label for="phone">{{__('Phone')}} <span class="tx-danger">*</span></label>
	                            <input type="text" name="phone" id="phone" class="form-control" data-parsley-type="digits" data-parsley-maxlength="14" required>
	                        </div>
	                    </div>
	                    <div class="col-6">
	                        <div class="form-group">
	                            <label for="mobile">{{__('Mobile')}} <span class="tx-danger">*</span></label>
	                            <input type="text" name="mobile" id="mobile" data-parsley-type="digits" data-parsley-maxlength="14" class="form-control" required>
	                        </div>
	                    </div>
	                    <div class="col-6">
	                        <div class="form-group">
	                            <label for="national_id">{{__('National ID')}}</label>
	                            <input type="text" name="national_id" id="national_id" data-parsley-type="digits" data-parsley-maxlength="14" class="form-control">
	                        </div>
	                    </div>
	                    <div class="col-6">
	                        <div class="form-group">
	                            <label for="passport_number">{{__('Passport Number')}}</label>
	                            <input type="text" name="passport_number" id="passport_number" class="form-control">
	                        </div>
	                    </div>
	                    <div class="col-6">
	                        <div class="form-group">
	                            <label for="country">{{__('Country')}} <span class="tx-danger">*</span></label>
	                            <input type="text" name="country" id="country" class="form-control" required>
	                        </div>
	                    </div>
	                    <div class="col-6">
	                        <div class="form-group">
	                            <label for="area">{{__('Area')}} <span class="tx-danger">*</span></label>
	                            <input type="text" name="area" id="area" class="form-control" required>
	                        </div>
	                    </div>
	                    <div class="col-6">
	                        <div class="form-group">
	                            <label for="city">{{__('City')}}</label>
	                            <input type="text" name="city" id="city" class="form-control">
	                        </div>
	                    </div>
                    </div>
                </div>
				<div class="modal-footer">
					<button name="save" value="continue" class="btn ripple btn-success" type="submit">{{__('Save & Booking')}}</button>
					<button name="save" value="close" class="btn ripple btn-primary" type="submit">{{__('Save')}}</button>
					<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('Close')}}</button>
				</div>
			</form>
		</div>
	</div>
</div>
