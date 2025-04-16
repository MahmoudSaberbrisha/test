<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ session()->get('rtl', 1) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="Description" content="{{$settings['site_description']->value}}">
    <meta name="Keywords" content="{{$settings['site_keywords']->value}}" />
    <meta name="language" content="{{ app()->getLocale() }}">
    <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    @include('admin.partials.head-links')
    </head>
<style>
    /* Container and layout */
    .h-screen {
        height: 100vh;
    }

    .overflow-y-auto {
        overflow-y: auto;
    }

    .container {
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .p-4 {
        padding: 1rem;
    }

    .mb-4 {
        margin-bottom: 1rem;
    }

    .mt-6 {
        margin-top: 1.5rem;
    }

    .flex {
        display: flex;
    }

    .flex-wrap {
        flex-wrap: wrap;
    }

    .justify-start {
        justify-content: flex-start;
    }

    .justify-between {
        justify-content: space-between;
    }

    .items-center {
        align-items: center;
    }

    .space-x-4>*+* {
        margin-left: 1rem;
    }

    .space-x-reverse>*+* {
        margin-right: 1rem;
        margin-left: 0;
    }

    /* Responsive widths */
    .w-full {
        width: 100%;
    }

    @media (max-width: 639px) {
        .sm\\:w-auto {
            width: 100% !important;
        }

        .sm\\:w-1\\/2 {
            width: 100% !important;
        }

        .flex {
            flex-direction: column;
        }

        .space-x-4>*+* {
            margin-left: 0;
            margin-top: 1rem;
        }

        .space-x-reverse>*+* {
            margin-right: 0;
            margin-top: 1rem;
        }

        button.w-full {
            width: 100% !important;
        }
    }

    @media (min-width: 640px) and (max-width: 1023px) {
        .sm\\:w-auto {
            width: auto !important;
        }

        .sm\\:w-1\\/2 {
            width: 50% !important;
        }

        .flex {
            flex-wrap: wrap;
        }
    }

    @media (min-width: 1024px) {
        .lg\\:w-1\\/4 {
            width: 25%;
        }
    }

    /* Buttons and links */
    .bg-green-600 {
        background-color: #16a34a;
    }

    .bg-yellow-500 {
        background-color: #eab308;
    }

    .bg-green-800 {
        background-color: #166534;
    }

    .bg-white {
        background-color: #ffffff;
    }

    .bg-gray-200 {
        background-color: #e5e7eb;
    }

    .text-white {
        color: #ffffff;
    }

    .text-gray-700 {
        color: #374151;
    }

    .text-black {
        color: #000000;
    }

    .px-4 {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .py-2 {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    .p-2 {
        padding: 0.5rem;
    }

    .rounded {
        border-radius: 0.375rem;
    }

    /* Borders */
    .border {
        border-width: 1px;
        border-style: solid;
        border-color: #d1d5db;
    }

    .border-gray-300 {
        border-color: #d1d5db;
    }

    .border-b {
        border-bottom-width: 1px;
        border-bottom-style: solid;
        border-bottom-color: #d1d5db;
    }

    /* Shadow */
    .shadow {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* Table */
    .min-w-full {
        min-width: 100%;
    }

    /* Scroll containers */
    .overflow-x-auto {
        overflow-x: auto;
    }

    .max-h-96 {
        max-height: 24rem;
    }

    .block {
        display: block;
    }
</style>
<body class="main-body app sidebar-mini">
    <style>
        .main-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 40px;
            background-color: #f8f9fa;
            /* optional: match footer background */
            z-index: 1000;
            box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
        }
    
        .main-content.app-content {
            padding-bottom: 50px;
            /* space for footer */
        }
    </style>
    <!-- Loader -->
    <div id="global-loader">
        <img src="{{asset('assets/admin')}}/img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- /Loader -->
    @include('admin.partials.sidebar')
    <!-- main-content -->
    <di v class="main-content app-content">
        @include('admin.partials.header')

        <div class="container-fluid">
            @yield('breadcrumb')
            @yield('content')
            @include('admin.partials.modals')
            @include('admin.partials.footer')
            @include('admin.partials.footer-scripts')

            @if ($errors->any())
            @foreach ($errors->all() as $error)
            @php(toastr()->error($error))
            @endforeach
            @endif
</body>
</html>
