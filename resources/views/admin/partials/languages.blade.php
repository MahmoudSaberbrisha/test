@feature('languages-feature')
	<ul class="nav">
		<li class="">
			<div class="dropdown nav-itemd-none d-md-flex">
				<a href="#" class="d-flex  nav-item nav-link pl-0 country-flag1" data-toggle="dropdown" aria-expanded="false">
					<span class="avatar country-Flag mr-0 align-self-center bg-transparent"><img style="width: 2.3rem; height: 2.7rem;" src="{{$currentLanguage->image??''}}" alt="{{$currentLanguage->name??""}}"></span>
					<div class="my-auto">
						<strong class="mr-2 ml-2 my-auto">{{$currentLanguage->name??""}}</strong>
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
					@foreach ($languages as $language)
						<a href="{{ route(auth()->getDefaultDriver().'.language-switch', $language->code) }}" class="dropdown-item d-flex" onclick='$("#global-loader").fadeIn()'>
							<span class="avatar ml-3 align-self-center bg-transparent span-right"><img src="{{$language->image}}" alt="{{$language->name}}"></span>
							<div class="d-flex">
								<span class="mt-2">{{$language->name}}</span>
							</div>
						</a>
					@endforeach
				</div>
			</div>
		</li>
	</ul>
@endfeature
