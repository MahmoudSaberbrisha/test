<div class="modal" id="modal-add">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">{{__('Add Client Type')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<form method="POST" action="{{route(auth()->getDefaultDriver().'.client-types.store')}}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
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
                    <div class="row m-2">
                        <div class="col-md-12">
                            <div class="form-group">
                        		<label for="discount_type">{{__('Discount Type')}}</label>
                        		<div class="row">
		                    	@foreach (DISCOUNT_TYPES as $key => $type)
		                    		<div class="col-lg-4 mg-t-20 mg-lg-t-0'">
										<label class="rdiobox"><input name="discount_type" type="radio" value="{{$key}}" {{$loop->first?'checked':''}} required> <span>{{__($type)}}</span></label>
									</div>
		                    	@endforeach
		                    	</div>
							</div>
						</div>
					</div>
                    <div class="row m-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="discount_value">{{__('Discount Value')}}</label>
                                <input type="number" step="0.5" name="discount_value" id="discount_value" class="form-control" required value="0">
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
