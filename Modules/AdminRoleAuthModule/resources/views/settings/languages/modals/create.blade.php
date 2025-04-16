<div class="modal" id="modal-add">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">{{__('Add Language')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<form method="POST" action="{{route(auth()->getDefaultDriver().'.languages.store')}}" enctype="multipart/form-data" autocomplete="nop" data-parsley-validate>
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
                                <label for="code">{{__('Code')}}</label>
                                <input name="code" id="code" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image">{{__('Image')}}</label>
                                <input type="file" accept="image/*" name="image" id="image" class="form-control dropify" required>
                            </div>
                        </div>
                        <div class="col-6 d-flex align-items-center mt-3">
                            <div class="form-group d-flex align-items-center m-0 mr-4">
                                <label class="switch mb-0 ml-2">
                                    <input type="hidden" name="default" value="0">
                                    <input type="checkbox" name="default" value="1">
                                    <span class="slider round"></span>
                                </label>
                                <span class="ml-3">{{__('Default Language')}}</span>
                            </div>
                        </div>
                        <div class="col-6 d-flex align-items-center mt-3">
                            <div class="form-group d-flex align-items-center m-0 mr-4">
                                <label class="switch mb-0 ml-2">
                                    <input type="hidden" name="rtl" value="0">
                                    <input type="checkbox" name="rtl" value="1">
                                    <span class="slider round"></span>
                                </label>
                                <span class="ml-3">{{__('RTL')}}</span>
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
