@extends('admin.layouts.auth')
@section('page_title', __('Lock Screen'))
@push('css')
    <link href="{{asset('assets/admin')}}/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css" rel="stylesheet">
@endpush
@section('content')
<div class="main-error-wrapper  page page-h ">
    <img src="{{asset('assets/admin')}}/img/media/404.png'" class="error-page" alt="error">
    <h2>Oopps. The page you were looking for doesn't exist.</h2>
    <h6>You may have mistyped the address or the page may have moved.</h6><a class="btn btn-outline-danger" href="{{ url('/' . $page='index') }}">Back to Home</a>
</div>
@endsection
