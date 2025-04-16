<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session()->get('rtl', 1)?'rtl':'ltr' }}">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="{{$settings['site_description']->value}}">
		<meta name="Keywords" content="{{$settings['site_keywords']->value}}"/>
		<meta name="language" content="{{ app()->getLocale() }}">
		<meta http-equiv="Content-Language" content="{{ app()->getLocale() }}">
		@include('admin.partials.head-links')
	</head>
	
	<body class="main-body bg-primary-transparent" style="background-color: #fff;">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{asset('assets/admin')}}/img/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->
		@yield('content')
		
		@include('admin.partials.footer-scripts')
				
		@if ($errors->any())
            @foreach ($errors->all() as $error)
                @php(toastr()->error($error))
            @endforeach
        @endif	
	</body>
</html>