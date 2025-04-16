<div>
	<div wire:loading class="text-center mg-b-20 mb-4 mt-2 w-100">
        <div class="spinner-border" role="status">
            <span class="sr-only">{{__('Loading...')}}</span>
        </div>
    </div>
	<div class="col-12">
	    <div class="form-group">
	        <label class="form-label">{{__('Site Name')}} <small class="text-info"> ({{$languageCode}})</small> </label>
	        <input class="form-control" name="site_name" wire:model="name" placeholder="{{__('Enter Name')}}" required type="text">
	    </div>
	</div>

	<div class="col-12">
	    <div class="form-group">
	        <label class="form-label">{{__('Site Description')}} <small class="text-info"> ({{$languageCode}})</small> </label>
	        <textarea rows="6" class="form-control" name="site_description" wire:model="description" placeholder="{{__('Enter Description')}}" required></textarea>
	    </div>
        <input type="hidden" name="locale" value="{{$languageCode}}">
	</div>
</div>
