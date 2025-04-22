<html dir="{!! session()->get('rtl', 1) ? 'rtl' : 'ltr' !!}" lang="{!! app()->getLocale() !!}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, user-scalable=0" name="viewport" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="{{ csrf_token() }}" name="csrf-token" />
    <meta content="{!! $settings['site_description']->value !!}" name="Description" />
    <meta content="{!! $settings['site_keywords']->value !!}" name="Keywords">
    <meta content="{!! app()->getLocale() !!}" name="language" />
    <meta content="{!! app()->getLocale() !!}" http-equiv="Content-Language" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    @include('admin.partials.head-links')
    <link rel="stylesheet" href="{{ asset('assets/global_button_styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/navbar_transparent.css') }}" />
    </meta>
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

    /* Added CSS to replace Tailwind CDN */

    /* Positioning */
    .fixed {
        position: fixed;
    }

    /* Ensure gallery panel is above all */
    #galleryPanel {
        z-index: 9999 !important;
    }

    .top-1\/2 {
        top: 50%;
    }

    .left-0 {
        left: 0;
    }

    .right-0 {
        right: 0;
    }

    /* Transform utilities */
    .transform {
        transition-property: transform;
        transition-duration: 0.3s;
        transition-timing-function: ease;
    }

    .-translate-y-1\/2 {
        transform: translateY(-50%);
    }

    /* Hover states */
    .hover\:bg-green-700:hover {
        background-color: #15803d;
    }

    .hover\:text-gray-900:hover {
        color: #111827;
    }

    .hover\:ring-4:hover {
        box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.5);
    }

    .hover\:ring-green-600:hover {
        box-shadow: 0 0 0 4px #16a34a;
    }

    /* Focus states */
    .focus\:outline-none:focus {
        outline: none;
    }

    .focus\:ring-2:focus {
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.5);
    }

    .focus\:ring-green-400:focus {
        box-shadow: 0 0 0 2px #4ade80;
    }

    /* Grid layout */
    .grid {
        display: grid;
    }

    .grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .gap-4 {
        gap: 1rem;
    }

    /* Cursor */
    .cursor-pointer {
        cursor: pointer;
    }

    /* Transition */
    .transition {
        transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
        transition-duration: 150ms;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Typography */
    .text-lg {
        font-size: 1.125rem;
        line-height: 1.75rem;
    }

    .font-semibold {
        font-weight: 600;
    }

    .text-gray-800 {
        color: #1f2937;
    }
</style>

<body class="main-body app sidebar-mini relative" id="appBody" style="transition: background-color 0.3s ease;">
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
        <img alt="Loader" class="loader-img" src="{{ asset('assets/admin') }}/img/loader.svg" />
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
            @include('admin.partials.footer')
            @include('admin.partials.footer-scripts')

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    @php(toastr()->error($error))
                @endforeach
            @endif
        </div>
    </div>
    <!-- Button on the side center -->
    <button type="button" aria-label="Open background image gallery"
        class="fixed top-1/2 {{ session()->get('rtl', 1) ? 'left-0' : 'right-0' }} transform -translate-y-1/2 bg-green-600 hover:bg-green-700 text-white p-3 rounded-l shadow z-50 focus:outline-none focus:ring-2 focus:ring-green-400"
        id="openGalleryBtn">
        <i class="fas fa-images fa-lg">
        </i>
    </button>
    <!-- Gallery panel -->
    <div class="fixed top-0 {{ session()->get('rtl', 1) ? 'left-0' : 'right-0' }} h-full w-64 bg-white shadow-lg transform {{ session()->get('rtl', 1) ? '-translate-x-full' : 'translate-x-full' }} transition-transform duration-300 ease-in-out z-50 overflow-y-auto"
        id="galleryPanel" style="display: none;">
        <div class="p-4 border-b border-gray-300 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">
                اختر الخلفية
            </h2>
            <button aria-label="Close background image gallery"
                class="text-gray-600 hover:text-gray-900 focus:outline-none" id="closeGalleryBtn">
                <i class="fas fa-times fa-lg">
                </i>
            </button>
        </div>
        <div class="p-4 grid grid-cols-2 gap-4">
            <img alt="صورة خلفية رقم 1: خلفية ثلاثية الأبعاد مزيج ألوان"
                class="cursor-pointer rounded shadow hover:ring-4 hover:ring-green-600 transition" height="150"
                src="{{asset('assets/bg-themes/1.png')}}"
                tabindex="0" width="200" />
            <img alt="صورة خلفية رقم 2: خلفية ثلاثية الأبعاد مزيج ألوان"
                class="cursor-pointer rounded shadow hover:ring-4 hover:ring-green-600 transition" height="150"
                src="{{asset('assets/bg-themes/2.png')}}"
                tabindex="0" width="200" />
            <img alt="صورة خلفية رقم 3: خلفية ثلاثية الأبعاد مزيج ألوان"
                class="cursor-pointer rounded shadow hover:ring-4 hover:ring-green-600 transition" height="150"
                src="{{asset('assets/bg-themes/3.png')}}"
                tabindex="0" width="200" />
            <img alt="صورة خلفية رقم 4: خلفية ثلاثية الأبعاد مزيج ألوان"
                class="cursor-pointer rounded shadow hover:ring-4 hover:ring-green-600 transition" height="150"
                src="{{asset('assets/bg-themes/4.png')}}"
                tabindex="0" width="200" />
            <img alt="صورة خلفية رقم 5: خلفية ثلاثية الأبعاد مزيج ألوان"
                class="cursor-pointer rounded shadow hover:ring-4 hover:ring-green-600 transition" height="150"
                src="{{asset('assets/bg-themes/5.png')}}"
                tabindex="0" width="200" />
            <img alt="صورة خلفية رقم 6: خلفية ثلاثية الأبعاد مزيج ألوان"
                class="cursor-pointer rounded shadow hover:ring-4 hover:ring-green-600 transition" height="150"
                src="{{asset('assets/bg-themes/6.png')}}"
                tabindex="0" width="200" />

        </div>
    </div>
    <script>
        const openBtn = document.getElementById('openGalleryBtn');
        const closeBtn = document.getElementById('closeGalleryBtn');
        const galleryPanel = document.getElementById('galleryPanel');
        const appBody = document.getElementById('appBody');
        const images = galleryPanel.querySelectorAll('img.cursor-pointer');
        const isRtl = {!! json_encode(session()->get('rtl', 1)) !!} === 1;

        // Open gallery panel
        openBtn.addEventListener('click', () => {
            galleryPanel.style.display = 'block';
            if ({!! json_encode(session()->get('rtl', 1)) !!} === 1) {
                galleryPanel.style.transform = 'translateX(0)';
            } else {
                galleryPanel.style.transform = 'translateX(0)';
            }
            openBtn.setAttribute('aria-expanded', 'true');
        });

        // Close gallery panel
        closeBtn.addEventListener('click', () => {
            if ({!! json_encode(session()->get('rtl', 1)) !!} === 1) {
                galleryPanel.style.transform = 'translateX(-100%)';
            } else {
                galleryPanel.style.transform = 'translateX(100%)';
            }
            setTimeout(() => {
                galleryPanel.style.display = 'none';
            }, 300);
            openBtn.setAttribute('aria-expanded', 'false');
        });

        // On page load, apply saved background if any
        const savedBackground = localStorage.getItem('selectedBackground');
        if (savedBackground) {
            appBody.style.backgroundImage = `url('${savedBackground}')`;
            appBody.style.backgroundRepeat = 'no-repeat';
            appBody.style.backgroundSize = 'cover';
            appBody.style.backgroundPosition = 'center center';
        }

        // Change background on image click and save selection
        images.forEach(img => {
            img.addEventListener('click', () => {
                // Set the body background to the clicked image's src
                appBody.style.backgroundImage = `url('${img.src}')`;
                appBody.style.backgroundRepeat = 'no-repeat';
                appBody.style.backgroundSize = 'cover';
                appBody.style.backgroundPosition = 'center center';
                // Save selected background to localStorage
                localStorage.setItem('selectedBackground', img.src);
            });
            // Also allow keyboard selection (Enter or Space)
            img.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    img.click();
                }
            });
        });
    </script>
</body>

</html>
