<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left ">
            <div class="responsive-logo">
                <a href="javascript:void(0);"><img src="{{ url('seed_images/logo.png')}}" class="logo-1" alt="logo"></a>
                <a href="javascript:void(0);"><img src="{{ url('seed_images/icon.png')}}" class="logo-2" alt="logo"></a>
            </div>
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>
        </div>
        <div class="main-header-right">

            @include('admin.partials.languages')

            <div class="nav nav-item navbar-nav-right ml-auto">
                <div class="nav-link" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-btn">
                                <button type="reset" class="btn btn-default">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="submit" class="btn btn-default nav-link resp-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>

                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
                </div>
                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href=""><img alt="{{auth()->user()->name}}" src="{{auth()->user()->image}}"></a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user"><img alt="{{auth()->user()->name}}" src="{{auth()->user()->image}}" class=""></div>
                                <div class="mr-3 my-auto">
                                    <h6>{{auth()->user()->name}}</h6><span>{{auth()->user()->user_name}}</span>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{route(auth()->getDefaultDriver().'.'.auth()->getDefaultDriver().'s.show', auth()->user()->id)}}"><i class="bx bx-user-circle"></i>{{__('Profile')}}</a>
                        <a class="dropdown-item" href="{{route(auth()->getDefaultDriver().'.password.confirm')}}"><i class="bx bx-lock"></i> {{__('Lockscreen')}}</a>
                        <form method="post" action="{{ route(auth()->getDefaultDriver().'.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="bx bx-log-out"></i> {{__('Sign Out')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /main-header -->
