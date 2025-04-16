<div class="modal" id="modal-add">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">{{__('Add Currency')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<form method="POST" action="{{route(auth()->getDefaultDriver().'.currencies.store')}}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
				@csrf
				<div class="modal-body">
                    <div class="row m-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">{{__('Name')}} <small class="text-info"> ({{getDefaultLanguageCode()}})</small></label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="symbol">{{__('Symbol')}} </label>
                                <input type="text" name="symbol" id="symbol" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">{{__('Code')}} </label>
                                <input type="text" name="code" id="code" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="color">{{__('Color')}}</label>
                                <input class="form-control colorpicker" id="color" type="text" name="color" value="#000000" required>
                            </div>
                        </div>
                        <div class="col-6 d-flex align-items-center mt-3 p-0">
                            <div class="form-group d-flex align-items-center m-0 mr-3">
                                <span class="ml-3">{{__('Default')}}</span>
                                <label class="switch mb-0 ml-2">
                                    <input type="hidden" name="default" value="0">
                                    <input type="checkbox" name="default" value="1">
                                    <span class="slider round"></span>
                                </label>
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
