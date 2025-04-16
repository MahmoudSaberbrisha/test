<!-- Title -->
<title>@yield('page_title') | {{$settings['site_name']->value??config('app.name')}}</title>
<!-- Favicon -->
<link rel="shortcut icon" href="{{ $settings['site_icon']->getProcessedValue()??'' }}" type="image/x-icon"/>
<!-- Icons css -->
<link href="{{asset('assets/admin')}}/css/icons.css" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{asset('assets/admin')}}/plugins/mscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet"/>
<!--  Sidebar css -->
<link href="{{asset('assets/admin')}}/plugins/sidebar/sidebar.css" rel="stylesheet">
<!-- Sidemenu css -->
<link rel="stylesheet" href="{{asset('assets/admin')}}/css{{session()->get('rtl', 1)?'-rtl':''}}/sidemenu.css">

@livewireStyles
@stack('css')

<link href="{{asset('assets/admin')}}/plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet"/>
<!--- Style css -->
<link href="{{asset('assets/admin')}}/css{{session()->get('rtl', 1)?'-rtl':''}}/style.css" rel="stylesheet">
<!--- Dark-mode css -->
<link href="{{asset('assets/admin')}}/css{{session()->get('rtl', 1)?'-rtl':''}}/style-dark.css" rel="stylesheet">
<!---Skinmodes css-->
<link href="{{asset('assets/admin')}}/css{{session()->get('rtl', 1)?'-rtl':''}}/skin-modes.css" rel="stylesheet">
