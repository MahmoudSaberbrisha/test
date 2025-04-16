<div>
	<div wire:loading class="text-center mg-b-20 mb-4 mt-2 w-100">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>
    @if ($modalData)
        <form wire:loading.remove action="{{route(auth()->getDefaultDriver().'.clients.update', $modalData->id)}}" method="POST" enctype="multipart/form-data" class="advanced-form myForm" id="my-form-id" data-parsley-validate x-data x-init="
            $nextTick(() => initializeParsley());
        ">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="row m-2">
                    <div class="col-6">
                        <div class="form-group">
                            <label>{{__('Name')}} <span class="tx-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{$modalData->name}}" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>{{__('Phone')}} <span class="tx-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{$modalData->phone}}" data-parsley-type="digits" data-parsley-maxlength="14" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>{{__('Mobile')}} <span class="tx-danger">*</span></label>
                            <input type="text" name="mobile" class="form-control" value="{{$modalData->mobile}}" data-parsley-type="digits" data-parsley-maxlength="14" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="national_id">{{__('National ID')}}</label>
                            <input type="text" name="national_id" id="national_id" class="form-control" value="{{$modalData->national_id}}" data-parsley-type="digits" data-parsley-maxlength="14">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="passport_number">{{__('Passport Number')}}</label>
                            <input type="text" name="passport_number" id="passport_number" class="form-control" value="{{$modalData->passport_number}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="country">{{__('Country')}} <span class="tx-danger">*</span></label>
                            <input type="text" name="country" id="country" class="form-control" value="{{$modalData->country}}" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="area">{{__('Area')}} <span class="tx-danger">*</span></label>
                            <input type="text" name="area" id="area" class="form-control" value="{{$modalData->area}}" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="city">{{__('City')}}</label>
                            <input type="text" name="city" id="city" class="form-control" value="{{$modalData->city}}">
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
