<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session()->get('rtl', 1) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .main-body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
        }

        footer {
            margin-top: auto;
        }
    </style>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="Description" content="{{ $settings['site_description']->value }}">
    <meta name="Keywords" content="{{ $settings['site_keywords']->value }}" />
    <meta name="language" content="{{ app()->getLocale() }}">
    <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}">
    @include('admin.partials.head-links')
</head>

<body class="main-body app sidebar-mini">
    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ asset('assets/admin') }}/img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->
    @include('admin.partials.sidebar')
    <!-- main-content -->
    <div class="main-content app-content">
        @include('admin.partials.header')

        <div class="container-fluid">
            @yield('breadcrumb')
            @yield('content')
            @include('admin.partials.modals')
        </div>
    </div>
    <footer>
        @include('admin.partials.footer')
    </footer>
    @include('admin.partials.footer-scripts')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            @php(toastr()->error($error))
        @endforeach
    @endif
</body>

</html>
