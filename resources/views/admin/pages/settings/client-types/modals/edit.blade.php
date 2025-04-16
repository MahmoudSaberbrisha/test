<div wire:ignore.self class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="modal-title">{{__('Edit Client Type')}}</h6>
                    </div>
                    <div class="col-md-3">
                        <livewire:adminroleauthmodule::change-language />
                    </div>
                    <div class="col-md-3">
                       <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>    
            </div>
        	<livewire:settings.edit-client-type />
        </div>
    </div>
</div>