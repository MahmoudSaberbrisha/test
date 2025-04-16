<div class="modal" id="modal-add">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">{{__('Add Employee Card Issuer')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<form method="POST" action="{{route(auth()->getDefaultDriver().'.employee-card-issuers.store')}}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
				@csrf
				<div class="modal-body">
                    <div class="row m-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">{{__('Name')}} <small class="text-info"> ({{getDefaultLanguageCode()}})</small></label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="modal-footer">
					<button class="btn ripple btn-primary" type="submit">{{__('Save')}}</button>
					<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('Close')}}</button>
				</div>
			</form>
		</div>
	</div>
</div>
