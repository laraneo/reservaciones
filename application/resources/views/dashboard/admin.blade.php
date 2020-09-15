@extends('layouts.admin', ['title' => __('backend.dashboard')])

@section('styles')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.dashboard') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.dashboard') }}</li>
            </ol>
        </div>
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('database_updated'))
                    <div class="alert alert-success">{{session('database_updated')}}</div>
                @endif
            </div>
            <div class="col-md-3">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ count($customers) }}</p>
                            <span class="info-box-title">{{ __('backend.total_customers') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-users"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ count($bookings) }}</p>
                            <span class="info-box-title">{{ __('backend.total_bookings') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ count($pending_cancel_requests) }}</p>
                            <span class="info-box-title">{{ __('backend.pending_cancel_requests') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-calendar" style="color:red;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ count($bookings_cancelled) }}</p>
                            <span class="info-box-title">{{ __('backend.bookings_cancelled') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-close" style="color:red;"></i>
                        </div>
                    </div>
                </div>
            </div>

<!-- 

            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">

                                @if(config('settings.currency_symbol_position')== __('backend.right'))

                                    {!! number_format( (float) $total_earning,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ). '&nbsp;' .
                                        config('settings.currency_symbol') !!}

                                @else

                                    {!! config('settings.currency_symbol').
                                        number_format( (float) $total_earning,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ) !!}

                                @endif

                            </p>
                            <span class="info-box-title">{{ __('backend.total_earning') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-graph"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">

                                @if(config('settings.currency_symbol_position')== __('backend.right'))

                                    {!! number_format( (float) $total_refunded,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ). '&nbsp;' .
                                        config('settings.currency_symbol') !!}

                                @else

                                    {!! config('settings.currency_symbol').
                                        number_format( (float) $total_refunded,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ) !!}

                                @endif

                            </p>
                            <span class="info-box-title">{{ __('backend.invoices_refunded') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-bar-chart"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">

                                @if(config('settings.currency_symbol_position')==__('backend.right'))

                                    {!! number_format( (float) $total_unpaid,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ). '&nbsp;' .
                                        config('settings.currency_symbol') !!}

                                @else

                                    {!! config('settings.currency_symbol').
                                        number_format( (float) $total_unpaid,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ) !!}

                                @endif

                            </p>
                            <span class="info-box-title">{{ __('backend.unpaid_invoices') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-energy"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
LA -->		

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.weekly_booking_stats') }}</h4>
                    </div>
                    <div class="panel-body">
                        @if($stats_booking!="[]")
                            <div id="bookings_chart"></div>
                        @else
                            <div class="alert alert-warning">{{ __('backend.no_data_found') }}</div>
                        @endif
                    </div>
                </div>
            </div>

<!-- 
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.weekly_earning_stats') }}</h4>
                    </div>
                    <div class="panel-body">
                        @if($stats_booking!="[]")
                            <div id="earning_chart"></div>
                        @else
                            <div class="alert alert-warning">{{ __('backend.no_data_found') }}</div>
                        @endif
                    </div>
                </div>
            </div>
LA -->

        </div>
    </div>

@endsection

@section('scripts')

    @if($stats_booking!="[]")

        <script src="{{ asset('plugins/morris/raphael.min.js') }}"></script>
        <script src="{{ asset('plugins/morris/morris.min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function () {

                Morris.Bar({
                    element: 'bookings_chart',
                    data: <?php echo $stats_booking; ?>,
                    xkey: 'date',
                    ykeys: ['value'],
                    labels: ['{{ __('backend.bookings') }}'],
                    barRatio: 0.4,
                    xLabelAngle: 35,
                    hideHover: 'auto',
                    barColors: ['{{ config('settings.primary_color') ? config('settings.primary_color') : '#007bff' }}'],
                    resize: true
                });

                Morris.Bar({
                    element: 'earning_chart',
                    data: <?php echo $stats_invoices; ?>,
                    xkey: 'date',
                    ykeys: ['value'],
                    labels: ['{{ __('backend.amount') }} {{ __('backend.in') }} {!! config('settings.currency_symbol') !!}'],
                    barRatio: 0.4,
                    xLabelAngle: 35,
                    hideHover: 'auto',
                    barColors: ['{{ config('settings.secondary_color') ? config('settings.secondary_color') : '#4E5E6A' }}'],
                    resize: true
                });

            });
        </script>

    @endif

@endsection