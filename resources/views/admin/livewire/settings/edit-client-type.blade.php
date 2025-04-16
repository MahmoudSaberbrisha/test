<div>
	<div wire:loading class="text-center mg-b-20 mb-4 mt-2 w-100">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>
    @if ($modalData)
        <form wire:loading.remove action="{{route(auth()->getDefaultDriver().'.client-types.update', $modalData->id)}}" method="POST" enctype="multipart/form-data" class="advanced-form myForm" id="my-form-id" data-parsley-validate x-data x-init="
            $nextTick(() => initializeParsley());
        ">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="row m-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label>{{__('Name')}} <small class="text-info"> ({{$languageCode}})</small> </label>
                            <input type="text" name="name" wire:model="name" class="form-control" value="" required>
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
                                    <label class="rdiobox"><input name="discount_type" type="radio" value="{{$key}}" {{$modalData->discount_type==$key?'checked':''}} required> <span>{{__($type)}}</span></label>
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
                            <input type="number" step="0.5" name="discount_value" id="discount_value" class="form-control" required value="{{$modalData->discount_value}}">
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
@endpush
