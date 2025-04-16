<div>
@feature('languages-feature')
	<div class=" mb-3 language-input">
	    @feature('languages-feature')
			<div class="form-group">
		        <select class="form-control" name="code" wire:model.change="selectedLanguageCode">
		            @foreach ($languages as $key => $language)
		                <option value="{{$language->code}}">{{$language->name}}</option>
		            @endforeach
		        </select>
		    </div>
	    @endfeature
	</div>
@endfeature
</div>
