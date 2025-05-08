<!-- main-sidebar -->
<style>
    /* Sidebar font color white */
    .app-sidebar,
    .app-sidebar .side-menu__item,
    .app-sidebar .side-menu__label,
    .app-sidebar .slide-item {
        color: white !important;
    }

    /* Active menu item highlight moon-like background, white text, and subtle shadow */
    .app-sidebar .side-menu__item.active,
    .app-sidebar .slide-item.active,
    .app-sidebar .side-menu__item.active:hover,
    .app-sidebar .slide-item.active:hover {
        background-color: #cbd5e1 !important;
        /* Moon-like pale blue-gray */
        color: #1f2937 !important;
        /* Dark text for contrast */
        box-shadow:
            0 0 3px 1px #e0e7ff,
            0 0 6px 2.5px #c7d2fe,
            0 0 9px 5px #a5b4fc;
        transition: box-shadow 0.3s ease-in-out;
    }

    /* Hover effect for menu items with subtle glowing effect */
    .app-sidebar .side-menu__item:hover,
    .app-sidebar .slide-item:hover {
        background-color: #cbd5e1 !important;
        /* Moon-like pale blue-gray */
        color: #1f2937 !important;
        /* Dark text for contrast */
        box-shadow:
            0 0 3px 1px #e0e7ff,
            0 0 6px 2.5px #c7d2fe,
            0 0 9px 5px #a5b4fc;
        transition: box-shadow 0.3s ease-in-out;
    }

    /* Water floating effect on all side-menu__item and slide-item */
    .app-sidebar .side-menu__item,
    .app-sidebar .slide-item {
        position: relative;
        animation: floatWater 4s ease-in-out infinite;
        transform-origin: center bottom;
    }

    /* Slight delay for nested slide-items for natural effect */
    .app-sidebar .slide-menu .slide-item {
        animation-delay: 0.2s;
    }

    /* Keyframes for floating effect */
    @keyframes floatWater {

        0%,
        100% {
            transform: translateY(0) rotate(0deg);
            filter: drop-shadow(0 0 0 rgba(68, 68, 68, 0));
        }

        25% {
            transform: translateY(-4px) rotate(-1deg);
            filter: drop-shadow(0 2px 2px rgba(68, 68, 68, 0.3));
        }

        50% {
            transform: translateY(-8px) rotate(1deg);
            filter: drop-shadow(0 4px 4px rgba(68, 68, 68, 0.5));
        }

        75% {
            transform: translateY(-4px) rotate(-1deg);
            filter: drop-shadow(0 2px 2px rgba(68, 68, 68, 0.3));
        }
    }

    /* Ensure the sidebar scroll and layout */
    .app-sidebar {
        background-color: #1f2937;
        /* Tailwind slate-800 */
        width: 240px;
        height: 100vh;
        overflow-y: auto;
        direction: rtl;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1100;
        /* Ensure sidebar is above footer */
        opacity: 0.85;
        /* Slightly faded */
    }

    /* Scrollbar styling for better UX */
    .app-sidebar::-webkit-scrollbar {
        width: 8px;
    }

    .app-sidebar::-webkit-scrollbar-thumb {
        background-color: #555555;
        border-radius: 4px;
    }

    .app-sidebar::-webkit-scrollbar-track {
        background-color: #374151;
        /* Tailwind slate-700 */
    }
</style>
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="javascript:void(0);"><img
                src="{{ $settings['site_logo']->getProcessedValue() ?? '' }}" class="main-logo" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="javascript:void(0);"><img
                src="{{ $settings['site_icon']->getProcessedValue() ?? '' }}" class="logo-icon" alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="">
                    <img alt="{{ auth()->user()->name }}" class="avatar avatar-xl brround"
                        src="{{ auth()->user()->image }}"><span class="avatar-status profile-status bg-green"></span>
                </div>
                <div class="user-info">
                    <h4 class="font-weight-semibold mt-3 mb-0">{{ auth()->user()->name }}</h4>
                    <span class="mb-0 text-muted">{{ auth()->user()->user_name }}</span>
                </div>
            </div>
        </div>
        <ul class="side-menu">
            <li class="side-item side-item-category">{{ __('Main') }}</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route(auth()->getDefaultDriver() . '.dashboard') }}"><svg
                        xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path fill="" d="M13 9V3h8v6zM3 13V3h8v10zm10 8V11h8v10zM3 21v-6h8v6z" />
                    </svg><span class="side-menu__label">{{ __('Dashboard') }}</span></a>
            </li>
            @if (auth()->user()->can('View Admin Roles') || auth()->user()->can('View Admins'))
                <li class="slide {{ request()->segment(2) == 'users' ? 'is-expanded' : '' }}">
                    <a class="side-menu__item {{ request()->segment(2) == 'users' ? 'active' : '' }}"
                        data-toggle="slide" href="javascript:void(0)"><svg class="side-menu__icon"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill=""
                                d="M10 12c2.21 0 4-1.79 4-4s-1.79-4-4-4s-4 1.79-4 4s1.79 4 4 4m0-6a2 2 0 1 1 0 4c-1.11 0-2-.89-2-2s.9-2 2-2m2 14H2v-3c0-2.67 5.33-4 8-4c1 0 2.38.19 3.71.56c-.3.56-.48 1.18-.5 1.83c-.98-.29-2.1-.49-3.21-.49c-2.97 0-6.1 1.46-6.1 2.1v1.1H12zm8.8-3v-1.5c0-1.4-1.4-2.5-2.8-2.5s-2.8 1.1-2.8 2.5V17c-.6 0-1.2.6-1.2 1.2v3.5c0 .7.6 1.3 1.2 1.3h5.5c.7 0 1.3-.6 1.3-1.2v-3.5c0-.7-.6-1.3-1.2-1.3m-1.3 0h-3v-1.5c0-.8.7-1.3 1.5-1.3s1.5.5 1.5 1.3z" />
                        </svg><span class="side-menu__label">{{ __('Users & Roles') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('View Admin Roles')
                            <li><a class="slide-item {{ request()->segment(3) == 'roles' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.roles.index') }}">{{ __('Roles') }}</a>
                            </li>
                        @endcan
                        @can('View Admins')
                            <li><a class="slide-item {{ request()->segment(3) == 'admins' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.admins.index') }}">{{ __('Admins') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('View Site Settings') ||
                    auth()->user()->can('View Languages') ||
                    auth()->user()->can('View SMTP Settings') ||
                    auth()->user()->can('View File Manager') ||
                    auth()->user()->can('View Regions') ||
                    auth()->user()->can('View Branches') ||
                    auth()->user()->can('View Sales Areas') ||
                    auth()->user()->can('View Currencies') ||
                    auth()->user()->can('View Client Suppliers') ||
                    auth()->user()->can('View Goods') ||
                    auth()->user()->can('View Payment Methods') ||
                    auth()->user()->can('View Client Types') ||
                    auth()->user()->can('View Sailing Boats') ||
                    auth()->user()->can('View Goods Suppliers') ||
                    auth()->user()->can('View Expenses Types') ||
                    auth()->user()->can('View Experience Types'))
                <li class="slide {{ request()->segment(2) == 'settings' ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                            <path fill=""
                                d="M12 15.5A3.5 3.5 0 0 1 8.5 12A3.5 3.5 0 0 1 12 8.5a3.5 3.5 0 0 1 3.5 3.5a3.5 3.5 0 0 1-3.5 3.5m7.43-2.53c.04-.32.07-.64.07-.97s-.03-.66-.07-1l2.11-1.63c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.31-.61-.22l-2.49 1c-.52-.39-1.06-.73-1.69-.98l-.37-2.65A.506.506 0 0 0 14 2h-4c-.25 0-.46.18-.5.42l-.37 2.65c-.63.25-1.17.59-1.69.98l-2.49-1c-.22-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64L4.57 11c-.04.34-.07.67-.07 1s.03.65.07.97l-2.11 1.66c-.19.15-.25.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1.01c.52.4 1.06.74 1.69.99l.37 2.65c.04.24.25.42.5.42h4c.25 0 .46-.18.5-.42l.37-2.65c.63-.26 1.17-.59 1.69-.99l2.49 1.01c.22.08.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64z" />
                        </svg><span class="side-menu__label">{{ __('General Settings') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('View Site Settings')
                            <li><a class="slide-item {{ request()->segment(3) == 'general-settings' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.general-settings.index') }}">{{ __('Site Settings') }}</a>
                            </li>
                        @endcan
                        @feature('languages-feature')
                            @can('View Languages')
                                <li><a class="slide-item {{ request()->segment(3) == 'languages' ? 'active' : '' }}"
                                        href="{{ route(auth()->getDefaultDriver() . '.languages.index') }}">{{ __('Language Settings') }}</a>
                                </li>
                            @endcan
                        @endfeature
                        @feature('smtp-feature')
                            @can('View SMTP Settings')
                                <li><a class="slide-item {{ request()->segment(3) == 'smtp-settings' ? 'active' : '' }}"
                                        href="{{ route(auth()->getDefaultDriver() . '.smtp-settings.index') }}">{{ __('SMTP Settings') }}</a>
                                </li>
                            @endcan
                        @endfeature
                        @feature('firebase-feature')
                            @can('View Firebase Settings')
                                <li><a class="slide-item {{ request()->segment(3) == 'firebase-settings' ? 'active' : '' }}"
                                        href="{{ route(auth()->getDefaultDriver() . '.firebase-settings.index') }}">{{ __('Firebase Settings') }}</a>
                                </li>
                            @endcan
                        @endfeature
                        @feature('regions-branches-feature')
                            @can('View Regions')
                                <li><a class="slide-item {{ request()->segment(3) == 'study-classes' ? 'active' : '' }}"
                                        href="{{ route(auth()->getDefaultDriver() . '.regions.index') }}">{{ __('Regions Settings') }}</a>
                                </li>
                            @endcan
                        @endfeature
                        @if (feature('regions-branches-feature') || feature('branches-feature'))
                            @can('View Branches')
                                <li><a class="slide-item {{ request()->segment(3) == 'departments' ? 'active' : '' }}"
                                        href="{{ route(auth()->getDefaultDriver() . '.branches.index') }}">{{ __('Branches Settings') }}</a>
                                </li>
                            @endcan
                        @endif
                        @can('View Sales Areas')
                            <li><a class="slide-item {{ request()->segment(3) == 'sales-areas' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.sales-areas.index') }}">{{ __('Sales Areas') }}</a>
                            </li>
                        @endcan
                        @feature('currencies-feature')
                            @can('View Currencies')
                                <li><a class="slide-item {{ request()->segment(3) == 'currencies' ? 'active' : '' }}"
                                        href="{{ route(auth()->getDefaultDriver() . '.currencies.index') }}">{{ __('Currencies Settings') }}</a>
                                </li>
                            @endcan
                        @endfeature
                        @can('View Client Suppliers')
                            <li><a class="slide-item {{ request()->segment(3) == 'client-suppliers' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.client-suppliers.index') }}">{{ __('Client Suppliers Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Goods')
                            <li><a class="slide-item {{ request()->segment(3) == 'goods' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.goods.index') }}">{{ __('Goods Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Payment Methods')
                            <li><a class="slide-item {{ request()->segment(3) == 'payment-methods' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.payment-methods.index') }}">{{ __('Payment Methods Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Client Types')
                            <li><a class="slide-item {{ request()->segment(3) == 'client-types' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.client-types.index') }}">{{ __('Client Types Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Sailing Boats')
                            <li><a class="slide-item {{ request()->segment(3) == 'sailing-boats' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.sailing-boats.index') }}">{{ __('Sailing Boats Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Goods Suppliers')
                            <li><a class="slide-item {{ request()->segment(3) == 'goods-suppliers' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.goods-suppliers.index') }}">{{ __('Goods Suppliers') }}</a>
                            </li>
                        @endcan
                        @can('View Expenses Types')
                            <li><a class="slide-item {{ request()->segment(3) == 'expenses-types' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.expenses-types.index') }}">{{ __('Expenses Types') }}</a>
                            </li>
                        @endcan
                        @can('View Experience Types')
                            <li><a class="slide-item {{ request()->segment(3) == 'experience-types' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.experience-types.index') }}">{{ __('Experience Types') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @feature('file-manager-feature')
                @can('View File Manager')
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route(auth()->getDefaultDriver() . '.file-manager.index') }}"><svg
                                xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="24" height="24"
                                viewBox="0 0 24 24">
                                <path fill=""
                                    d="M4 20q-.825 0-1.412-.587T2 18V6q0-.825.588-1.412T4 4h6l2 2h8q.825 0 1.413.588T22 8v10q0 .825-.587 1.413T20 20z" />
                            </svg><span class="side-menu__label">{{ __('File Manager') }}</span></a>
                    </li>
                @endcan
            @endfeature

            @if (auth()->user()->can('View Types'))
                <li class="slide {{ request()->segment(2) == 'services-management' ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)"><svg
                            class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                            viewBox="0 0 32 32">
                            <path fill=""
                                d="M28 22a3.44 3.44 0 0 1-3.051-2.316a1 1 0 0 0-1.896-.005A3.44 3.44 0 0 1 20 22a3.44 3.44 0 0 1-3.051-2.316A1.01 1.01 0 0 0 16 19a.99.99 0 0 0-.947.679A3.44 3.44 0 0 1 12 22a3.44 3.44 0 0 1-3.051-2.316A1.01 1.01 0 0 0 8 19a.97.97 0 0 0-.947.679A3.44 3.44 0 0 1 4 22H2v2h2a4.93 4.93 0 0 0 4-1.987a5.6 5.6 0 0 0 1 .99a7 7 0 0 0 14 0a5.6 5.6 0 0 0 1-.99A4.93 4.93 0 0 0 28 24h2v-2Zm-12 6a5 5 0 0 1-4.907-4.085A5 5 0 0 0 12 24a4.93 4.93 0 0 0 4-1.987A4.93 4.93 0 0 0 20 24a5 5 0 0 0 .908-.085A5 5 0 0 1 16 28" />
                            <path fill="currentColor"
                                d="M20.07 7.835A2.01 2.01 0 0 0 18.077 6H17V2h-2v4h-1.082a1.995 1.995 0 0 0-1.986 1.772L10.28 19h2.022l.734-5h5.921l.735 5h2.021ZM13.33 12l.588-4l4.167.063l.578 3.937Z" />
                        </svg><span class="side-menu__label">{{ __('Services Management') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @feature('types-feature')
                            @can('View Types')
                                <li><a class="slide-item {{ request()->segment(3) == 'types' ? 'active' : '' }}"
                                        href="{{ route(auth()->getDefaultDriver() . '.types.index') }}">{{ __('Types Settings') }}</a>
                                </li>
                            @endcan
                        @endfeature
                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('View Clients') || auth()->user()->can('View FeedBacks'))
                <li class="slide {{ request()->segment(2) == 'clients-management' ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)"><svg
                            class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24">
                            <path fill=""
                                d="M16 17v2H2v-2s0-4 7-4s7 4 7 4m-3.5-9.5A3.5 3.5 0 1 0 9 11a3.5 3.5 0 0 0 3.5-3.5m3.44 5.5A5.32 5.32 0 0 1 18 17v2h4v-2s0-3.63-6.06-4M15 4a3.4 3.4 0 0 0-1.93.59a5 5 0 0 1 0 5.82A3.4 3.4 0 0 0 15 11a3.5 3.5 0 0 0 0-7" />
                        </svg><span class="side-menu__label">{{ __('Clients Management') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('View Clients')
                            <li><a class="slide-item {{ request()->segment(3) == 'clients' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.clients.index') }}">{{ __('Clients') }}</a>
                            </li>
                        @endcan
                        @can('View FeedBacks')
                            <li><a class="slide-item {{ request()->segment(3) == 'feedbacks' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.feedbacks.index') }}">{{ __('Feedbacks') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('View Bookings'))
                <li class="slide {{ request()->segment(2) == 'booking-management' ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)"><svg
                            class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24">
                            <path fill=""
                                d="M6 6h12v3.96L12 8L6 9.96M3.94 19H4c1.6 0 3-.88 4-2c1 1.12 2.4 2 4 2s3-.88 4-2c1 1.12 2.4 2 4 2h.05l1.9-6.69c.08-.25.05-.53-.06-.77c-.13-.24-.34-.42-.6-.5L20 10.62V6a2 2 0 0 0-2-2h-3V1H9v3H6a2 2 0 0 0-2 2v4.62l-1.29.42c-.26.08-.47.26-.6.5c-.11.24-.14.52-.06.77M20 21c-1.39 0-2.78-.47-4-1.33c-2.44 1.71-5.56 1.71-8 0C6.78 20.53 5.39 21 4 21H2v2h2c1.37 0 2.74-.35 4-1c2.5 1.3 5.5 1.3 8 0c1.26.65 2.62 1 4 1h2v-2z" />
                        </svg><span class="side-menu__label">{{ __('Booking Management') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('View Bookings')
                            <li><a class="slide-item {{ request()->segment(3) == 'bookings' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.bookings.index') }}">{{ __('Bookings') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('View Extra Services') || auth()->user()->can('View Booking Extra Services'))
                <li class="slide {{ request()->segment(2) == 'extra-services-management' ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void(0);"><svg
                            class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="512" height="512"
                            viewBox="0 0 512 512">
                            <path fill=""
                                d="M141 35c-13 0-26.9.98-38.6 2.88c-8.3 1.36-15.6 3.39-20.5 5.33c3.4 24.58 4.8 57.69 0 90.09c-4.9 33.5-16.3 66.4-40.9 85.3V294h142v-25h64V139.2c-16-9.8-27.4-25.9-36.9-42.8c-10.4-18.72-18.4-38.91-26.2-54.37l-.7-1.53c-1.4-.74-4.4-1.84-8.4-2.7c-8.4-1.78-20.7-2.8-33.8-2.8m230 0c-13.1 0-25.4 1.02-33.8 2.8c-4 .86-7 1.96-8.4 2.7l-.7 1.53c-7.8 15.46-15.8 35.65-26.2 54.37c-9.5 16.9-20.9 33-36.9 42.8V269h64v25h142v-75.4c-24.6-18.9-36-51.8-40.9-85.3c-4.8-32.4-3.4-65.51 0-90.09c-4.9-1.94-12.1-3.97-20.5-5.33C397.9 35.98 384 35 371 35M201 287v62h110v-62zm23 14h64v18h-64zM41 344v62c0 1.3.3 3.8.8 7h204.6c.4-2.5.6-4.8.6-7v-39h-64v-23zm288 0v23h-64v39c0 2.2.2 4.5.6 7h204.6c.5-3.2.8-5.7.8-7v-62zM45.4 431c1.5 6 3.2 12.3 5.1 18.2c2.9 8.6 6.3 16.6 9.5 21.9c1.5 2.7 3.1 4.6 4.1 5.4c.4.4.4.5.5.5H208c-.5 0 3.6-1.2 8-5.5c4.5-4.3 9.7-10.8 14.4-18.3c4.3-6.8 8.1-14.6 11-22.2zm225.2 0c2.9 7.6 6.7 15.4 11 22.2c4.7 7.5 9.9 14 14.4 18.3c4.4 4.3 8.5 5.5 8 5.5h143.4l.5-.5c1-.8 2.5-2.7 4.1-5.4c3.2-5.3 6.6-13.3 9.5-21.9c1.9-5.9 3.7-12.2 5.1-18.2z" />
                        </svg><span class="side-menu__label">{{ __('Extra Services Management') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('View Extra Services')
                            <li><a class="slide-item {{ request()->segment(3) == 'extra-services' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.extra-services.index') }}">{{ __('Extra Services') }}</a>
                            </li>
                        @endcan
                        @can('View Booking Extra Services')
                            <li><a class="slide-item {{ request()->segment(3) == 'booking-extra-services' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.booking-extra-services.index') }}">{{ __('Booking Extra Services') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('View Account Types') ||
                    auth()->user()->can('View Accounts') ||
                    auth()->user()->can('View Expenses'))
                <li class="slide {{ request()->segment(2) == 'financial-management' ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void(0);"><svg
                            class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            viewBox="0 0 16 16">
                            <path fill=""
                                d="M7 2H5a3.5 3.5 0 1 0 0 7h2v3H2.5v2H7v2h2v-2h2a3.5 3.5 0 1 0 0-7H9V4h4.5V2H9V0H7zm2 7h2a1.5 1.5 0 0 1 0 3H9zM7 7H5a1.5 1.5 0 1 1 0-3h2z" />
                        </svg><span class="side-menu__label">{{ __('Financial Management') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        {{-- @can('View Account Types')
                                                                        <li><a class="slide-item {{request()->segment(3) == 'account-types'?'active':''}}" href="{{ route(auth()->getDefaultDriver().'.account-types.index') }}">{{__('Account Types')}}</a></li>
                                                                        @endcan
                                                                        @can('View Accounts')
                                                                        <li><a class="slide-item {{request()->segment(3) == 'accounts'?'active':''}}" href="{{ route(auth()->getDefaultDriver().'.accounts.index') }}">{{__('Accounts')}}</a></li>
                                                                        @endcan --}}
                        @can('View Expenses')
                            <li><a class="slide-item {{ request()->segment(3) == 'expenses' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.expenses.index') }}">{{ __('Expenses') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('View Employee Types') ||
                    auth()->user()->can('View Employee Nationalities') ||
                    auth()->user()->can('View Employee Religions') ||
                    auth()->user()->can('View Employee Marital Status') ||
                    auth()->user()->can('View Employee Identity Types') ||
                    auth()->user()->can('View Employee Card Issuers') ||
                    auth()->user()->can('View Jobs') ||
                    auth()->user()->can('View Employees'))
                <li class="slide {{ request()->segment(2) == 'employees-management' ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void(0)"><svg
                            class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                            viewBox="0 0 36 36">
                            <circle cx="16.86" cy="9.73" r="6.46" fill="" />
                            <path fill="" d="M21 28h7v1.4h-7z" />
                            <path fill=""
                                d="M15 30v3a1 1 0 0 0 1 1h17a1 1 0 0 0 1-1V23a1 1 0 0 0-1-1h-7v-1.47a1 1 0 0 0-2 0V22h-2v-3.58a32 32 0 0 0-5.14-.42a26 26 0 0 0-11 2.39a3.28 3.28 0 0 0-1.88 3V30Zm17 2H17v-8h7v.42a1 1 0 0 0 2 0V24h6Z" />
                        </svg><span class="side-menu__label">{{ __('Employee Management') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('View Employee Types')
                            <li><a class="slide-item {{ request()->segment(3) == 'employee-types' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.employee-types.index') }}">{{ __('Employee Types Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Employee Nationalities')
                            <li><a class="slide-item {{ request()->segment(3) == 'employee-nationalities' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.employee-nationalities.index') }}">{{ __('Employee Nationalities Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Employee Religions')
                            <li><a class="slide-item {{ request()->segment(3) == 'employee-religions' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.employee-religions.index') }}">{{ __('Employee Religions Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Employee Marital Status')
                            <li><a class="slide-item {{ request()->segment(3) == 'employee-marital-status' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.employee-marital-status.index') }}">{{ __('Employee Marital Status Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Employee Identity Types')
                            <li><a class="slide-item {{ request()->segment(3) == 'employee-identity-types' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.employee-identity-types.index') }}">{{ __('Employee Identity Types Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Employee Card Issuers')
                            <li><a class="slide-item {{ request()->segment(3) == 'employee-card-issuers' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.employee-card-issuers.index') }}">{{ __('Employee Card Issuers Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Jobs')
                            <li><a class="slide-item {{ request()->segment(3) == 'jobs' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.jobs.index') }}">{{ __('Jobs Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Employees')
                            <li><a class="slide-item {{ request()->segment(3) == 'employees' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.employees.index') }}">{{ __('Employees') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('View Car Suppliers') ||
                    auth()->user()->can('View Car Contracts') ||
                    auth()->user()->can('View Car Expenses') ||
                    auth()->user()->can('View Car Tasks'))
                <li class="slide {{ request()->segment(2) == 'cars-management' ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void(0);"><svg
                            class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24">
                            <path fill=""
                                d="M6.5 5c-.66 0-1.22.42-1.42 1L3 12v8a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1h5.3a7 7 0 0 1-.3-2a7 7 0 0 1 3.41-6H5l1.5-4.5h11l1.18 3.53a7 7 0 0 1 1.79.43L18.92 6c-.2-.58-.76-1-1.42-1zM17 12a.26.26 0 0 0-.26.21l-.19 1.32c-.3.13-.59.29-.85.47l-1.24-.5c-.11 0-.24 0-.31.13l-1 1.73c-.06.11-.04.24.06.32l1.06.82a4.2 4.2 0 0 0 0 1l-1.06.82a.26.26 0 0 0-.06.32l1 1.73c.06.13.19.13.31.13l1.24-.5c.26.18.54.35.85.47l.19 1.32c.02.12.12.21.26.21h2c.11 0 .22-.09.24-.21l.19-1.32c.3-.13.57-.29.84-.47l1.23.5c.13 0 .26 0 .33-.13l1-1.73a.26.26 0 0 0-.06-.32l-1.07-.82c.02-.17.04-.33.04-.5s-.01-.33-.04-.5l1.06-.82a.26.26 0 0 0 .06-.32l-1-1.73c-.06-.13-.19-.13-.32-.13l-1.23.5c-.27-.18-.54-.35-.85-.47l-.19-1.32A.236.236 0 0 0 19 12zM6.5 13A1.5 1.5 0 0 1 8 14.5A1.5 1.5 0 0 1 6.5 16A1.5 1.5 0 0 1 5 14.5A1.5 1.5 0 0 1 6.5 13M18 15.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5c-.84 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5" />
                        </svg><span class="side-menu__label">{{ __('Car Management') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('View Car Suppliers')
                            <li><a class="slide-item {{ request()->segment(3) == 'car-suppliers' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.car-suppliers.index') }}">{{ __('Car Suppliers Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Car Expenses')
                            <li><a class="slide-item {{ request()->segment(3) == 'car-expenses' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.car-expenses.index') }}">{{ __('Car Expenses Settings') }}</a>
                            </li>
                        @endcan
                        @can('View Car Contracts')
                            <li><a class="slide-item {{ request()->segment(3) == 'car-contracts' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.car-contracts.index') }}">{{ __('Car Contracts') }}</a>
                            </li>
                        @endcan
                        @can('View Car Tasks')
                            <li><a class="slide-item {{ request()->segment(3) == 'car-tasks' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.car-tasks.index') }}">{{ __('Car Tasks') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @if (auth()->user()->can('View Detailed Clients Report') ||
                    auth()->user()->can('View Clients Report') ||
                    auth()->user()->can('View Client Suppliers Report') ||
                    auth()->user()->can('View Booking Groups Report') ||
                    auth()->user()->can('View Extra Services Report') ||
                    auth()->user()->can('View Credit Sales Bookings Report') ||
                    auth()->user()->can('View Expenses Report') ||
                    auth()->user()->can('View Trip Analysis Report') ||
                    auth()->user()->can('View Trip Analysis By Sales Area Report') ||
                    auth()->user()->can('View Car Expenses Report') ||
                    auth()->user()->can('View Car Income Report') ||
                    auth()->user()->can('View Car Income Expenses Report') ||
                    auth()->user()->can('View Car Contracts Due Amount Report'))
                <li class="slide {{ request()->segment(2) == 'reports' ? 'is-expanded' : '' }}">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void(0);"><svg
                            class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24">
                            <path fill="" stroke="currentColor" stroke-width="1.5"
                                d="M9 21h6m-6 0v-5m0 5H3.6a.6.6 0 0 1-.6-.6v-3.8a.6.6 0 0 1 .6-.6H9m6 5V9m0 12h5.4a.6.6 0 0 0 .6-.6V3.6a.6.6 0 0 0-.6-.6h-4.8a.6.6 0 0 0-.6.6V9m0 0H9.6a.6.6 0 0 0-.6.6V16" />
                        </svg><span class="side-menu__label">{{ __('Reports & Statistics') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('View Detailed Clients Report')
                            <li><a class="slide-item {{ request()->segment(3) == 'detailed-clients-report' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.detailed-clients-report') }}">{{ __('Detailed Clients Report') }}</a>
                            </li>
                        @endcan
                        @can('View Clients Report')
                            <li><a class="slide-item {{ request()->segment(3) == 'clients-report' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.clients-report') }}">{{ __('Clients Report') }}</a>
                            </li>
                        @endcan
                        @can('View Client Suppliers Report')
                            <li><a class="slide-item {{ request()->segment(3) == 'client-suppliers-report' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.client-suppliers-report') }}">{{ __('Client Suppliers Report') }}</a>
                            </li>
                        @endcan
                        @can('View Booking Groups Report')
                            <li><a class="slide-item {{ request()->segment(3) == 'booking-groups-report' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.booking-groups-report') }}">{{ __('Booking Groups Report') }}</a>
                            </li>
                        @endcan
                        @can('View Extra Services Report')
                            <li><a class="slide-item {{ request()->segment(3) == 'extra-services-report' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.extra-services-report') }}">{{ __('Extra Services Report') }}</a>
                            </li>
                        @endcan
                        @can('View Credit Sales Bookings Report')
                            <li><a class="slide-item {{ request()->segment(3) == 'credit-sales-bookings-report' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.credit-sales-bookings-report') }}">{{ __('Credit Sales Bookings Report') }}</a>
                            </li>
                        @endcan
                        @can('View Expenses Report')
                            <li><a class="slide-item {{ request()->segment(3) == 'expenses-report' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.expenses-report') }}">{{ __('Expenses Report') }}</a>
                            </li>
                        @endcan
                        @can('View Trip Analysis Report')
                            <li><a class="slide-item {{ request()->segment(3) == 'trip-analysis-report' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.trip-analysis-report') }}">{{ __('Trip Analysis Report') }}</a>
                            </li>
                        @endcan
                        @can('View Trip Analysis By Sales Area Report')
                            <li><a class="slide-item {{ request()->segment(3) == 'trip-analysis-by-sales-area-report' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.trip-analysis-by-sales-area-report') }}">{{ __('Trip Analysis By Sales Area Report') }}</a>
                            </li>
                        @endcan
                        @can('View Car Expenses Report')
                            <li><a class="slide-item {{ request()->segment(3) == 'car-expenses-report' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.car-expenses-report') }}">{{ __('Car Expenses Report') }}</a>
                            </li>
                        @endcan
                        @can('View Car Income Report')
                            <li><a class="slide-item {{ request()->segment(3) == 'car-income-report' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.car-income-report') }}">{{ __('Car Income Report') }}</a>
                            </li>
                        @endcan
                        @can('View Car Income Expenses Report')
                            <li><a class="slide-item {{ request()->segment(3) == 'car-income-expenses-report' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.car-income-expenses-report') }}">{{ __('Car Income Expenses Report') }}</a>
                            </li>
                        @endcan
                        @can('View Car Contracts Due Amount Report')
                            <li><a class="slide-item {{ request()->segment(3) == 'car-contract-due-report' ? 'active' : '' }}"
                                    href="{{ route(auth()->getDefaultDriver() . '.car-contract-due-report') }}">{{ __('Car Contract Due Amount Report') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('View Account tree') ||
                    auth()->user()->can('View Restrictions') ||
                    auth()->user()->can('View Financial Reports'))
@if (auth()->user()->can('View Account tree') || auth()->user()->can('View Restrictions') || auth()->user()->can('View Financial reports'))
            <li class="slide {{ request()->segment(2) == 'accounting-department' ? 'is-expanded' : '' }}">
                <a class="side-menu__item" data-toggle="slide" href="javascript:void(0);"><svg
                        class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        viewBox="0 0 16 16">
                        <path fill=""
                            d="M7 2H5a3.5 3.5 0 1 0 0 7h2v3H2.5v2H7v2h2v-2h2a3.5 3.5 0 1 0 0-7H9V4h4.5V2H9V0H7zm2 7h2a1.5 1.5 0 0 1 0 3H9zM7 7H5a1.5 1.5 0 1 1 0-3h2z" />
                    </svg><span class="side-menu__label">{{ __('Accounting Department') }}</span><i
                        class="angle fe fe-chevron-down"></i></a>
                <ul class="slide-menu">

                    <li><a class="slide-item {{ request()->segment(3) == 'entries' ? 'active' : '' }}"
                            href="{{ route(auth()->getDefaultDriver() . '.entries.index') }}">{{ __('Entries') }}</a>
                    </li>

                    {{-- <li><a class="slide-item {{ request()->segment(3) == 'chart-of-accounts' ? 'active' : '' }}"
                            href="{{ route(auth()->getDefaultDriver() . '.accounts.chart') }}">{{ __('Accounts Chart') }}</a>
                    </li> --}}

                    <li><a class="slide-item {{ request()->segment(3) == 'accounts' ? 'active' : '' }}"
                            href="{{ route(auth()->getDefaultDriver() . '.accounts.index') }}">{{ __('Accounts') }}</a>
                    </li>
                    <li><a class="slide-item {{ request()->segment(3) == 'accounts' ? 'active' : '' }}"
                            href="{{ route(auth()->getDefaultDriver() . '.master') }}">التقارير المالية
                            والقوائم </a></li>

                </ul>
            </li>
@endif
            @endif

            @if (auth()->user()->can('View Warhouse Management') || auth()->user()->can('View Warehouse Management'))
@if (auth()->user()->can('View Warhouse Management') || auth()->user()->can('View Warehouse Management'))
            <li class="slide {{ request()->segment(2) == 'Warehouse-management' ? 'is-expanded' : '' }}">
                <a class="side-menu__item" data-toggle="slide" href="javascript:void(0);"><svg
                        class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        viewBox="0 0 24 24">
                        <path fill=""
                            d="M12 2L2 7v13a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7L12 2zm0 2.18L19.74 7H4.26L12 4.18zM4 20v-9h16v9H4z" />
                    </svg><span class="side-menu__label">{{ __('Warehouse management') }}</span><i
                        class="angle fe fe-chevron-down"></i></a>
                <ul class="slide-menu">

                    <li><a class="slide-item {{ request()->segment(3) == 'Control area' ? 'active' : '' }}"
                            href="{{ route(auth()->getDefaultDriver() . '.stocks.master') }}">{{ __('Control area') }}</a>
                    </li>





                </ul>
            </li>
@endif
            @endif
        </ul>
    </div>
</aside>
