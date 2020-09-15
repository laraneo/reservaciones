@extends('layouts.app', ['title' => __('app.payment_failed_title')])

@section('content')

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.payment_failed_title') }}</h1>
            <p class="promo-desc text-center">{{ __('app.payment_failed_subtitle') }}</p>
        </div>
    </div>

    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 text-center">
                    <br>
                    <p style="text-align: center;">
                        <img src="{{ asset('images/icon-booking-failed.png') }}">
                    </p>
                    <br>
                    <h1 class="text-dark"><strong>{{ __("app.payment_failed_heading") }}</strong></h1>
                    <br><br>
                    <p class="text-muted">{{ __('app.payment_failed_paragraph') }} {{ config('settings.contact_email') }}
                        {{ __('app.or') }} {{ config('settings.contact_number') }}.</p>
                    <br>

                    <div class="d-sm-none d-none d-md-block d-lg-block">
                        <a href="{{ route('loadFinalStep') }}" class="btn btn-dark btn-lg"><i class="far fa-calendar-alt"></i>&nbsp;&nbsp;{{ __('app.try_again') }}</a>
                        <a href="{{ route('home') }}" class="btn btn-danger btn-lg"><i class="far fa-user"></i>&nbsp;&nbsp;{{ __('app.my_account_link') }}</a>
                    </div>

                    <div class="d-sm-block d-block d-md-none d-lg-none">
                        <a href="{{ route('loadFinalStep') }}" class="btn btn-dark btn-lg btn-block"><i class="far fa-calendar-alt"></i>&nbsp;&nbsp;{{ __('app.try_again') }}</a>
                        <a href="{{ route('home') }}" class="btn btn-danger btn-lg btn-block"><i class="far fa-user"></i>&nbsp;&nbsp;{{ __('app.my_account_link') }}</a>
                    </div>

                    <br><br><br><br><br>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                        <span class="text-copyrights">
                            {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }} {{ config('settings.business_name', 'Bookify') }}.
                        </span>
                </div>
            </div>
        </div>
    </footer>

@endsection