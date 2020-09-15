@extends('layouts.app', ['title' => __('app.step_three_title')])

@section('content')

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.step_three_title') }}</h1>
            <p class="promo-desc text-center">{{ __('app.step_three_subtitle') }}</p>
        </div>
    </div>

    <form method="post" id="booking_step_3" action="{{ route('postStep3') }}">
        <input type="hidden" name="session_email" value="{{ Auth::user()->email }}">
        {{ csrf_field() }}
        <div class="container">
            <div class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mx-lg-5" style="height: 30px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">75%</div>
                        </div>
                    </div>
                </div>

                @if(count($addons))

                    @if(count($session_addons))

                        <div class="row">
                            <div class="col-md-12">
                                <br><br>
                                <h5 class="text-center">{{ __('app.add_service_title') }}</h5>
                                <br><br>
                                <div class="owl-carousel owl-theme owl-loaded owl-drag" id="addons_carousel">
                                    @foreach($addons as $addon)

                                        @if((new App\Http\Controllers\UserBookingController)->checkIfAdded($addon->id,Auth::user()->email))

                                            <div class="package_box">
                                                <div class="responsive-image"><img class="responsive-image" alt="{{ $addon->title }}" src="{{ asset($addon->photo->file) }}"></div>
                                                <div class="package_title">
                                                    <div class="text-container">
                                                        <h4 class="text-center package_title_large paddings">{{ $addon->title }}</h4>
														
														<!--
                                                        <h4 class="text-center package_price">
                                                            @if(config('settings.currency_symbol_position')==__('backend.right'))

                                                                {!! number_format( (float) $addon->price,
                                                                    config('settings.decimal_points'),
                                                                    config('settings.decimal_separator') ,
                                                                    config('settings.thousand_separator') ). '&nbsp;' .
                                                                    config('settings.currency_symbol') !!}

                                                            @else

                                                                {!! config('settings.currency_symbol').
                                                                    number_format( (float) $addon->price,
                                                                    config('settings.decimal_points'),
                                                                    config('settings.decimal_separator') ,
                                                                    config('settings.thousand_separator') ) !!}

                                                            @endif
                                                        </h4>
                                                        LA -->
														<div class="text-center package_descrition">{!! $addon->description !!}</div>
                                                        <div class="package_btn addon_buttons">
                                                            <a class="btn btn-danger btn-lg btn-block btn-addon" data-addon-id="{{ $addon->id }}" data-method="remove" id="{{ $addon->id }}">{{ __('app.remove_service_btn') }}</a>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>

                                        @else

                                            <div class="package_box">
                                                <div class="responsive-image"><img class="responsive-image" alt="{{ $addon->title }}" src="{{ asset($addon->photo->file) }}"></div>
                                                <div class="package_title">
                                                    <div class="text-container">
                                                        <h4 class="text-center package_title_large paddings">{{ $addon->title }}</h4>
														<!--
                                                        <h4 class="text-center package_price">
                                                            @if(config('settings.currency_symbol_position')==__('backend.right'))

                                                                {!! number_format( (float) $addon->price,
                                                                    config('settings.decimal_points'),
                                                                    config('settings.decimal_separator') ,
                                                                    config('settings.thousand_separator') ). '&nbsp;' .
                                                                    config('settings.currency_symbol') !!}

                                                            @else

                                                                {!! config('settings.currency_symbol').
                                                                    number_format( (float) $addon->price,
                                                                    config('settings.decimal_points'),
                                                                    config('settings.decimal_separator') ,
                                                                    config('settings.thousand_separator') ) !!}

                                                            @endif
                                                        </h4>
                                                        LA -->
														<div class="text-center package_descrition">{!! $addon->description !!}</div>
                                                        <div class="package_btn addon_buttons">
                                                            <a class="btn btn-primary btn-lg btn-block btn-addon" data-addon-id="{{ $addon->id }}" data-method="add" id="{{ $addon->id }}">{{ __('app.add_service_btn') }}</a>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>

                                        @endif

                                    @endforeach
                                </div>
                            </div>
                        </div>

                    @else

                        <div class="row">
                            <div class="col-md-12">
                                <br><br>
                                <h5 class="text-center">{{ __('app.add_service_title') }}</h5>
                                <br><br>
                                <div class="owl-carousel owl-theme owl-loaded owl-drag" id="addons_carousel">
                                    @foreach($addons as $addon)

                                        <div class="package_box">
                                            <div class="responsive-image"><img class="responsive-image" alt="{{ $addon->title }}" src="{{ asset($addon->photo->file) }}"></div>
                                            <div class="package_title">
                                                <div class="text-container">
                                                    <h4 class="text-center package_title_large paddings">{{ $addon->title }}</h4>
													
													<!--
                                                    <h4 class="text-center package_price">
													
                                                        @if(config('settings.currency_symbol_position')==__('backend.right'))

                                                            {!! number_format( (float) $addon->price,
                                                                config('settings.decimal_points'),
                                                                config('settings.decimal_separator') ,
                                                                config('settings.thousand_separator') ). '&nbsp;' .
                                                                config('settings.currency_symbol') !!}

                                                        @else

                                                            {!! config('settings.currency_symbol').
                                                                number_format( (float) $addon->price,
                                                                config('settings.decimal_points'),
                                                                config('settings.decimal_separator') ,
                                                                config('settings.thousand_separator') ) !!}

                                                        @endif
                                                    </h4>
                                                    
													LA -->
													<div class="text-center package_descrition">{!! $addon->description !!}</div>
                                                    <div class="package_btn addon_buttons">
                                                        <a class="btn btn-primary btn-lg btn-block btn-addon" data-addon-id="{{ $addon->id }}" data-method="add" id="{{ $addon->id }}">{{ __('app.add_service_btn') }}</a>
                                                    </div>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>

                    @endif

                @else

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <br><br><br>
                            <h1 class="text-center text-danger">{{ __('app.no_extra_services_title') }}</h1>
                            <br><br>
                            <h3 class="text-center">{{ __('app.no_extra_services_subtitle') }}</h3>
                            <br><br><br>
                            <a class="btn btn-primary btn-lg" href="{{ route('loadFinalStep') }}">{{ __('app.step_three_button') }}</a>
                            <br><br><br>
                        </div>
                    </div>

                @endif

            </div>
        </div>

        <br><br>
        <footer class="footer d-none d-sm-none d-md-block d-lg-block d-xl-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-copyrights">
                            {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }} {{ config('settings.business_name', 'Bookify') }}.
                        </span>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('loadFinalStep') }}" class="navbar-btn btn btn-primary btn-lg ml-auto">
                            {{ __('app.step_three_button') }}
                        </a>
                    </div>
                </div>
            </div>
        </footer>

        {{--FOOTER FOR PHONES--}}

        <footer class="footer d-block d-sm-block d-md-none d-lg-none d-xl-none">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="{{ route('loadFinalStep') }}" class="navbar-btn btn btn-primary btn-lg ml-auto">
                            {{ __('app.step_three_button') }}
                        </a>
                    </div>
                </div>
            </div>
        </footer>

    </form>


@endsection

@section('scripts')
    <script>
        $('.addon_buttons').on('click', 'a.btn-addon', function() {

            var method = $(this).attr('data-method');

            if(method === "add") {
                $(this).removeClass('btn-primary').addClass('btn-danger').text('{{ __("app.remove_service_btn") }}');
            }

            else if(method === "remove") {
                $(this).removeClass('btn-danger').addClass('btn-primary').text('{{ __("app.add_service_btn") }}');
            }

        });
    </script>
@endsection