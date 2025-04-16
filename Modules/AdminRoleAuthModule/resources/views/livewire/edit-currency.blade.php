<div>
	<div wire:loading class="text-center mg-b-20 mb-4 mt-2 w-100">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>
    @if ($modalData)
        <form wire:loading.remove action="{{route(auth()->getDefaultDriver().'.currencies.update', $modalData->id)}}" method="POST" enctype="multipart/form-data" class="advanced-form myForm" id="my-form-id" data-parsley-validate x-data x-init="
            $nextTick(() => initializeColorPicker());
            $nextTick(() => initializeParsley());
        ">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="row m-2">
                    <div class="col-6">
                        <div class="form-group">
                            <label>{{__('Name')}} <small class="text-info"> ({{$languageCode}})</small> </label>
                            <input type="text" name="name" wire:model="name" class="form-control" value="" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="symbol">{{__('Symbol')}} </label>
                            <input type="text" name="symbol" id="symbol" class="form-control" value="{{$modalData->symbol}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code">{{__('Code')}} </label>
                            <input type="text" name="code" id="code" class="form-control" value="{{$modalData->code}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="color">{{__('Color')}}</label>
                            <input class="form-control colorpicker" id="color" type="text" name="color" wire:model="color" value="" required>
                        </div>
                    </div>
                    <div class="col-6 d-flex align-items-center mt-3 p-0">
                        <div class="form-group d-flex align-items-center m-0 mr-3">
                            <span class="ml-3">{{__('Default')}}</span>
                            <label class="switch mb-0 ml-2">
                                <input type="hidden" name="default" value="0">
                                <input type="checkbox" name="default" value="1" {{$modalData->default==1?'checked':''}}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="locale" value="{{$languageCode}}">
                <button class="btn ripple btn-primary" type="submit">{{__('Save')}}</button>
                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('Close')}}</button>
            </div>
        </form>       
    @endif
</div>

@push('js')
    <script type="text/javascript">
        Livewire.on('modalShow',()=>{
            $('#modal-edit').modal('show');
        });
    </script>

    <script type="text/javascript">
        function initializeParsley() {
            const form = document.getElementById('my-form-id');
            if (form) {
                $(form).parsley().reset();
                $(form).parsley();
            }
        }
    </script>

    <script type="text/javascript">
        function initializeColorPicker() {
            const color = document.getElementsByClassName('colorpicker');
            if (color) {
                $(color).spectrum({
                    showButtons: false,
                    preferredFormat: "hex",
                });
            }
        }
    </script>
@endpush
