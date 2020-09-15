<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ trans('installer_messages.title') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" href="{{ asset('favicon.png') }}">
    @yield('styles')
    @include('settings.customization')
</head>

<body class="setup">

<div class="container">
    <div class="row setup_container">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <p style="text-align: center;">
                <img src="{{ asset('images/logo-light.png') }}" class="img-responsive img-logo-setup">
            </p>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="row form_container">
        <div class="col-md-2"></div>
        <div class="col-md-8 form_box">
            <h2 class="text-center">@yield('title')</h2>
            <br>
            @yield('container')
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <br><br>
            <p class="text-center copyright_text">&copy; Bookify. {{ date('Y') }}.
                Powered By <a href="https://www.xtreme-webs.com" target="_blank">Xtreme Webs</a>
                . All Rights Reserved.</p>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>