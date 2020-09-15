@extends('layouts.admin', ['title' => __('backend.view_booking')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.booking') }} # {{ $booking->id }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('bookings.index') }}">{{ __('backend.bookings') }}</a></li>
                <li class="active">{{ __('backend.view_booking') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.bookings')
            </div>
			
			
			
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.booking_details') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div id="account_details_view">
                            <div class="row table-row">
                                <div class="col-md-6 bold-font"><strong>{{ __('backend.category') }}:</strong></div>
                                <div class="col-md-6">{{ $booking->package->category->title }}</div>
                            </div>
                            <div class="row table-row">
                                <div class="col-md-6 bold-font"><strong>{{ __('backend.package') }}:</strong></div>
                                <div class="col-md-6">{{ $booking->package->title }}</div>
                            </div>
                            <div class="row table-row">
                                <div class="col-md-6 bold-font"><strong>{{ __('backend.instructions') }}:</strong></div>
                                <div class="col-md-6">{{ $booking->booking_instructions ? $booking->booking_instructions : __('backend.not_provided') }}</div>
                            </div>
                            <div class="row table-row">
                                <div class="col-md-6 bold-font"><strong>{{ __('backend.extra_services') }}:</strong></div>
                                <div class="col-md-6">
                                    @if(count($addons))
                                        @foreach($addons as $addon)
                                            {{ $addon->title }}<br>
                                        @endforeach
                                    @else
                                        {{ __('backend.none') }}
                                    @endif
                                </div>
                            </div>
                            <div class="row table-row">
                                <div class="col-md-6 bold-font"><strong>{{ __('backend.date') }}:</strong></div>
                                <div class="col-md-6">{{ $booking->booking_date }}</div>
                            </div>
                            <div class="row table-row">
                                <div class="col-md-6 bold-font"><strong>{{ __('backend.time') }}:</strong></div>
                                <div class="col-md-6">{{ $booking->booking_time }}</div>
                            </div>
                            <div class="row table-row">
                                <div class="col-md-6 bold-font"><strong>{{ __('backend.status') }}:</strong></div>
                                <div class="col-md-6">{{ $booking->status }}</div>
                            </div>
							
							<!-- 
							
                            <div class="row table-row">
                                <div class="col-md-6 bold-font"><strong>{{ __('backend.invoice_no') }}</strong></div>
                                <div class="col-md-6">{{ $booking->invoice->id }} -
                                    <a href="{{ route('invoice.show', $booking->invoice->id) }}">{{ __('backend.click_to_see') }}</a>
                                </div>
                            </div>
                            <div class="row table-row">
                                <div class="col-md-6 bold-font"><strong>{{ __('backend.payment_details') }}:</strong></div>
                                <div class="col-md-6">{{ $booking->invoice->is_paid ? __('backend.paid') : __('emails.to_be_paid')  }}

                                    @if(config('settings.currency_symbol_position')== __('backend.right'))

                                        {!! number_format( (float) $booking->invoice->amount,
                                            config('settings.decimal_points'),
                                            config('settings.decimal_separator') ,
                                            config('settings.thousand_separator') ). '&nbsp;' .
                                            config('settings.currency_symbol') !!}

                                    @else

                                        {!! config('settings.currency_symbol').
                                            number_format( (float) $booking->invoice->amount,
                                            config('settings.decimal_points'),
                                            config('settings.decimal_separator') ,
                                            config('settings.thousand_separator') ) !!}

                                    @endif

                                    {{ __('backend.via') }} {{ $booking->invoice->payment_method }}
                                </div>
                            </div>
                            LA -->
							
							<div class="row table-row">
                                <div class="col-md-6 bold-font"><strong>{{ __('backend.transaction_no') }}</strong></div>
                                <div class="col-md-6">{{ $booking->invoice->transaction_id }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.customer_details') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('backend.full_name') }}:</strong></div>
                            <div class="col-md-6">{{ $booking->user->first_name }} {{ $booking->user->last_name }}</div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('backend.phone_number') }}:</strong></div>
                            <div class="col-md-6"><a href="tel:{{ $booking->user->phone_number }}">{{ $booking->user->phone_number }}</a></div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('backend.email') }}:</strong></div>
                            <div class="col-md-6"><a href="mailto:{{ $booking->user->email }}">{{ $booking->user->email }}</a></div>
                        </div>
                        <div class="row table-row">
                            <div class="col-md-6 bold-font"><strong>{{ __('backend.address') }}:</strong></div>
                            <div class="col-md-6">{{ $booking->booking_address==NULL ? 'Not Provided' : $booking->booking_address }}</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @if($booking->status != __('backend.cancelled'))
                        <div class="col-md-6 hidden-md hidden-lg">
                            <a class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#status"><i class="fa fa-bell fa-lg"></i> &nbsp; {{ __('backend.change_booking_status') }}</a>
                            <br>
                        </div>
                        <div class="col-md-6 hidden-xs hidden-sm">
                            <a class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#status"><i class="fa fa-bell fa-lg"></i> &nbsp; {{ __('backend.change_booking_status') }}</a>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <a class="btn btn-danger btn-lg btn-block" data-toggle="modal" data-target="#confirm"><i class="fa fa-trash-o fa-lg"></i> &nbsp; {{ __('backend.delete_booking') }}</a>
                    </div>
                </div>

                <div class="row">
                    <br>
                    @if($booking->status != __('backend.cancelled'))
                        <div class="col-md-6 hidden-md hidden-lg">
                            <a class="btn btn-danger btn-lg btn-block" data-toggle="modal" data-target="#cancel"><i class="fa fa-times-circle fa-lg"></i> &nbsp; {{ __('backend.cancel_booking') }}</a>
                            <br>
                        </div>
                        <div class="col-md-6 hidden-xs hidden-sm">
                            <a class="btn btn-danger btn-lg btn-block" data-toggle="modal" data-target="#cancel"><i class="fa fa-times-circle fa-lg"></i> &nbsp; {{ __('backend.cancel_booking') }}</a>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-info btn-lg btn-block" href="{{ route('bookings.edit', $booking->id) }}"><i class="fa fa-clock-o fa-lg"></i> &nbsp; {{ __('backend.change_booking_time') }}</a>
                        </div>
                    @endif
                </div>


                <div class="modal fade" id="status" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false">
                    <div class="modal-dialog">
                        <form method="post" action="{{ route('bookings.update', $booking->id) }}">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">{{ __('backend.change_booking_status') }}</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>{{ __('backend.status') }}</label>
                                        <select class="form-control" name="status" required>
                                            <option></option>
                                            <option>{{ __('backend.processing') }}</option>
                                            <option>{{ __('backend.in_progress') }}</option>
                                            <option>{{ __('backend.completed') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">{{ __('backend.update') }}</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('backend.close') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="confirm" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                            </div>
                            <div class="modal-body">
                                <p>{{ __('backend.delete_booking_message') }}</p>
                            </div>
                            <form method="post" action="{{ route('bookings.destroy', $booking->id) }}">
                                <div class="modal-footer">
                                    {{csrf_field()}}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger">{{ __('backend.delete_btn') }}</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('backend.no') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="cancel" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <form method="post" action="{{ route('cancelBooking', $booking->id) }}">
                            {{ csrf_field() }}
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                </div>
                                <div class="modal-body">
                                    <p>{{ __('backend.cancel_booking_message') }}</p>
                                    <br>
                                    @if($booking->invoice->is_paid)
                                        <div class="form-group">
                                            <label>{{ __('backend.issue_refund') }}</label>
                                            <select class="form-control" name="refund_selection">
                                                <option value="1">{{ __('backend.yes') }}</option>
                                                <option value="0">{{ __('backend.no') }}</option>
                                            </select>
                                        </div>
                                    @else
                                        <input type="hidden" name="refund_selection" value="0">
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">{{ __('backend.cancel_booking') }}</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('backend.no') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        
			
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<div class="account_details_view">
			
				@if(count($booking->bookingplayers))
					@foreach($booking->bookingplayers as $player)
							<div class="row table-row">	

								<div class="col-md-3">
								{{ $player->PlayerRol() }} - {{ $player->PlayerName2() }}
								</div>
								
								<div  class="col-md-2 bold-font {{ $player->isConfirmed()  ? 'label-success' : 'label-danger' }}"> <p align="center" style="color:white;"><strong> {{ $player->PlayerConfirmedStatus() }}</strong></p></div>

								<div class="col-md-3">
								{{ $player->confirmed_at }} 
								</div>								
					
							</div>
					@endforeach
				@else
							<div class="row table-row">	
					{{ __('backend.none') }}
							</div>
				@endif
							
						</div>
				
					</div>
				</div>
			</div>			

		</div>
    </div>

@endsection