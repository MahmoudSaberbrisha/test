<div>
    <div wire:loading class="text-center mg-b-20 mb-4 mt-2 w-100">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>
    @if ($languageData)
        <form wire:loading.remove action="{{route(auth()->getDefaultDriver().'.languages.update', $languageData->id)}}" method="POST" enctype="multipart/form-data" class="advanced-form myForm" id="my-form-id" data-parsley-validate x-data x-init="
            $nextTick(() => initializeDropify());
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
                            <label>{{__('Code')}}</label>
                            <input name="code" value="{{$languageData->code}}" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-12" wire:ignore>
                        <div class="form-group">
                            <label>{{__('Image')}}</label>
                            <input type="file" accept="image/*" name="image" class="form-control dropify" data-default-file="{{ $languageData->image }}" data-show-remove="false" {{$languageData->image?'':'required'}}>
                        </div>
                    </div>
                    <div class="col-6 d-flex align-items-center mt-3">
                        <div class="form-group d-flex align-items-center m-0 mr-4">
                            <label class="switch mb-0 ml-2">
                                <input type="hidden" name="default" value="0">
                                <input type="checkbox" name="default" value="1" {{$languageData->default==1?'checked':''}}>
                                <span class="slider round"></span>
                            </label>
                            <span class="ml-3">{{__('Default Language')}}</span>
                        </div>
                    </div>
                    <div class="col-6 d-flex align-items-center mt-3">
                        <div class="form-group d-flex align-items-center m-0 mr-4">
                            <label class="switch mb-0 ml-2">
                                <input type="hidden" name="rtl" value="0">
                                <input type="checkbox" name="rtl" value="1" {{$languageData->rtl==1?'checked':''}}>
                                <span class="slider round"></span>
                            </label>
                            <span class="ml-3">{{__('RTL')}}</span>
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
        function initializeDropify() {
            $('.dropify').dropify();
        }
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
