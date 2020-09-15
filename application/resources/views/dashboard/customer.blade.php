@extends('layouts.customer', ['title' => __('backend.dashboard')])

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
		
		<!--The Bootstrap grid system has four classes: xs (phones), sm (tablets), md (desktops), and lg (larger desktops). The classes can be combined to create more dynamic and flexible layouts.

		Tip: Each class scales up, so if you wish to set the same widths for xs and sm, you only need to specify xs.-->
 <a href="{{ route('index') }}" " >
            <div class="col-xs-12 col-md-3 col-lg-3">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats" style="width: 90%;" >
                            <p class="counter" style="padding: 10px"></p>
                            <span class="info-box-title">{{ __('backend.new_booking') }}</span>
                        </div>
                        <div class="info-box-icon">
                           
                                <i class="icon-plus"></i>
                           
                        </div>
                    </div>
                </div>
            </div>
 </a>
            <div class="col-xs-12 col-md-3 col-lg-3">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats" style="width: 90%;">
                            <p class="counter">{{ $bookings }}</p>
                            <span class="info-box-title">{{ __('backend.bookings') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3 col-lg-3">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats" style="width: 90%;">
                            <p class="counter">{{ count($pending_cancel_requests) }}</p>
                            <span class="info-box-title">{{ __('backend.pending_cancel_requests') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-calendar" style="color:red;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3 col-lg-3">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats" style="width: 90%;">
                            <p class="counter">{{ $bookings_cancelled }}</p>
                            <span class="info-box-title" >{{ __('backend.bookings_cancelled') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-close" style="color:red;"></i>
                        </div>
                    </div>
                </div>
            </div>
			
<!--			
			
            <div class="col-xs-3">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">

                                @if(config('settings.currency_symbol_position')== __('backend.right'))

                                    {!! number_format( (float) $total_paid,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ). '&nbsp;' .
                                        config('settings.currency_symbol') !!}

                                @else

                                    {!! config('settings.currency_symbol').
                                        number_format( (float) $total_paid,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ) !!}

                                @endif

                            </p>
                            <span class="info-box-title">{{ __('backend.invoices_paid') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-graph"></i>
                        </div>
                    </div>
                </div>
            </div>
            
			
			
			<div class="col-xs-3">
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
                            <i class="icon-bar-chart" style="color:red;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
LA -->
		
        <div class="row">
            <div class="col-xs-12">
                @include('alerts.bookings')
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-xs-12">
                            <h4 class="panel-title">{{ __('backend.recent_bookings') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if($bookings)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('backend.category') }}</th>
                                        <th>{{ __('backend.package') }}</th>
                                        <th>{{ __('backend.date') }}</th>
                                        <th>{{ __('backend.time') }}</th>
                                        <th>{{ __('backend.status') }}</th>
                                        <th>{{ __('backend.created') }}</th>
										<th>{{ __('backend.locator') }}</th>
                                        <th>{{ __('backend.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('backend.category') }}</th>
                                        <th>{{ __('backend.package') }}</th>
                                        <th>{{ __('backend.date') }}</th>
                                        <th>{{ __('backend.time') }}</th>
                                        <th>{{ __('backend.status') }}</th>
                                        <th>{{ __('backend.created') }}</th>
										<th>{{ __('backend.locator') }}</th>
                                        <th>{{ __('backend.actions') }}</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($recent_bookings as $booking)
                                        <tr>
                                            <td>{{ $booking->id }}</td>
                                            <td>{{ $booking->package->category->title }}</td>
                                            <td>{{ $booking->package->title }}</td>
                                            <td>{{ $booking->booking_date }}</td>
                                            <td>{{ $booking->booking_time }}</td>
                                            <td><span class="label {{ $booking->status == __('backend.cancelled') ? 'label-danger' : 'label-success' }}">{{ $booking->status }}</span></td>
                                            <td>{{ $booking->created_at->diffForHumans() }}</td>
                                            
											<td>
												{{ $booking->locator }}
											</td>
											
											<td>
                                                <a href="{{ route('showBooking', $booking->id) }}" class="btn btn-primary btn-sm">{{ __('backend.details') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning">{{ __('backend.no_data_found') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection