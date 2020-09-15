@extends('layouts.admin', ['title' => __('backend.booking_times')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.adjust_booking_times') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.booking_times') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.bookingTimes')
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.booking_times') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.day') }}</th>
                                    <th>{{ __('backend.opening_time') }}</th>
                                    <th>{{ __('backend.closing_time') }}</th>
                                    <th>{{ __('backend.is_off_day') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.day') }}</th>
                                    <th>{{ __('backend.opening_time') }}</th>
                                    <th>{{ __('backend.closing_time') }}</th>
                                    <th>{{ __('backend.is_off_day') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($booking_times as $booking_time)
                                        <tr>
                                            <td>{{ $booking_time->id }}</td>
                                            <td>{{ $booking_time->day }}</td>
                                            <td>{{ $booking_time->opening_time }}</td>
                                            <td>{{ $booking_time->closing_time }}</td>
                                            <td><span class="label {{ $booking_time->is_off_day  ? 'label-danger' : 'label-success' }}">{{ $booking_time->is_off_day ? __('backend.yes') : __('backend.no') }}</span></td>
                                            <td>{{ $booking_time->updated_at->diffForHumans() }}</td>
                                            <td><a class="btn btn-primary" data-toggle="modal" data-target="#update_{{ $booking_time->id }}">{{ __('backend.edit') }}</a></td>
                                        </tr>
                                        <div class="modal fade" id="update_{{ $booking_time->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false">
                                            <div class="modal-dialog">
                                                <form method="post" action="{{ route('booking-times.update', $booking_time->id) }}">
                                                    @csrf
                                                    {{ method_field('PATCH') }}
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">{{ __('backend.update_booking_time', ['day' => $booking_time->day]) }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label><strong>{{ __('backend.opening_time') }}</strong></label>
                                                                <select class="form-control" name="opening_time">
                                                                    <option value="12:00 AM"{{ $booking_time->opening_time=='12:00 AM' ? ' selected' : '' }}>12:00 AM</option>
                                                                    <option value="01:00 AM"{{ $booking_time->opening_time=='01:00 AM' ? ' selected' : '' }}>01:00 AM</option>
                                                                    <option value="02:00 AM"{{ $booking_time->opening_time=='02:00 AM' ? ' selected' : '' }}>02:00 AM</option>
                                                                    <option value="03:00 AM"{{ $booking_time->opening_time=='03:00 AM' ? ' selected' : '' }}>03:00 AM</option>
                                                                    <option value="04:00 AM"{{ $booking_time->opening_time=='04:00 AM' ? ' selected' : '' }}>04:00 AM</option>
                                                                    <option value="05:00 AM"{{ $booking_time->opening_time=='05:00 AM' ? ' selected' : '' }}>05:00 AM</option>
                                                                    <option value="06:00 AM"{{ $booking_time->opening_time=='06:00 AM' ? ' selected' : '' }}>06:00 AM</option>
                                                                    <option value="07:00 AM"{{ $booking_time->opening_time=='07:00 AM' ? ' selected' : '' }}>07:00 AM</option>
                                                                    <option value="08:00 AM"{{ $booking_time->opening_time=='08:00 AM' ? ' selected' : '' }}>08:00 AM</option>
                                                                    <option value="09:00 AM"{{ $booking_time->opening_time=='09:00 AM' ? ' selected' : '' }}>09:00 AM</option>
                                                                    <option value="10:00 AM"{{ $booking_time->opening_time=='10:00 AM' ? ' selected' : '' }}>10:00 AM</option>
                                                                    <option value="11:00 AM"{{ $booking_time->opening_time=='11:00 AM' ? ' selected' : '' }}>11:00 AM</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><strong>{{ __('backend.closing_time') }}</strong></label>
                                                                <select class="form-control" name="closing_time">
                                                                    <option value="12:00 PM"{{ $booking_time->closing_time=='12:00 PM' ? ' selected' : '' }}>12:00 PM</option>
                                                                    <option value="01:00 PM"{{ $booking_time->closing_time=='01:00 PM' ? ' selected' : '' }}>01:00 PM</option>
                                                                    <option value="02:00 PM"{{ $booking_time->closing_time=='02:00 PM' ? ' selected' : '' }}>02:00 PM</option>
                                                                    <option value="03:00 PM"{{ $booking_time->closing_time=='03:00 PM' ? ' selected' : '' }}>03:00 PM</option>
                                                                    <option value="04:00 PM"{{ $booking_time->closing_time=='04:00 PM' ? ' selected' : '' }}>04:00 PM</option>
                                                                    <option value="05:00 PM"{{ $booking_time->closing_time=='05:00 PM' ? ' selected' : '' }}>05:00 PM</option>
                                                                    <option value="06:00 PM"{{ $booking_time->closing_time=='06:00 PM' ? ' selected' : '' }}>06:00 PM</option>
                                                                    <option value="07:00 PM"{{ $booking_time->closing_time=='07:00 PM' ? ' selected' : '' }}>07:00 PM</option>
                                                                    <option value="08:00 PM"{{ $booking_time->closing_time=='08:00 PM' ? ' selected' : '' }}>08:00 PM</option>
                                                                    <option value="09:00 PM"{{ $booking_time->closing_time=='09:00 PM' ? ' selected' : '' }}>09:00 PM</option>
                                                                    <option value="10:00 PM"{{ $booking_time->closing_time=='10:00 PM' ? ' selected' : '' }}>10:00 PM</option>
                                                                    <option value="11:00 PM"{{ $booking_time->closing_time=='11:00 PM' ? ' selected' : '' }}>11:00 PM</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><strong>{{ __('backend.is_off_day') }}</strong></label>
                                                                <br>
                                                                @if($booking_time->is_off_day)

                                                                    <input type="radio" id="is_off_day" name="is_off_day" value="1" checked>&nbsp;{{ __('backend.yes') }}
                                                                    &nbsp;&nbsp;
                                                                    <input type="radio" id="is_off_day" name="is_off_day" value="0">&nbsp;{{ __('backend.no') }}

                                                                @else

                                                                    <input type="radio" id="is_off_day" name="is_off_day" value="1">&nbsp;{{ __('backend.yes') }}
                                                                    &nbsp;&nbsp;
                                                                    <input type="radio" id="is_off_day" name="is_off_day" value="0" checked>&nbsp;{{ __('backend.no') }}

                                                                @endif
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