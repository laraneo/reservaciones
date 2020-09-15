@extends('layouts.customer', ['title' => __('backend.bookings')])

@section('content')
xx
    <div class="page-title">
        <h3>{{ __('backend.bookings') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.bookings') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.bookings')
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.bookings') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.category') }}</th>
                                    <th>{{ __('backend.package') }}</th>
                                    <th>{{ __('backend.date') }}</th>
                                    <th>{{ __('backend.time') }}</th>
                                    <th>{{ __('backend.status') }}</th>
                                    <th>{{ __('backend.booked') }}</th>
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
                                    <th>{{ __('backend.booked') }}</th>
									<th>{{ __('backend.locator') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->package->category->title }}</td>
                                        <td>{{ $booking->package->title }}</td>
                                        <td>{{ $booking->booking_date }}</td>
                                        <td>{{ $booking->booking_time }}</td>
                                        <td><span class="label {{ $booking->status == __('backend.cancelled') ? 'label-danger' : 'label-success' }}">{{ $booking->status }}  
										
										 @if ($booking->booking_address != '' )
										 - Falto Confirmacion
										 @endif
										 
										
										</span></td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection