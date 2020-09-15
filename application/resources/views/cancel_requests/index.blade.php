@extends('layouts.admin', ['title' => __('backend.cancel_request_admin_menu')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.admin_cancel_title') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.cancel_request_admin_menu') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.cancelRequest')
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.admin_cancel_title') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <!-- <th>#</th>-->
                                    <th>{{ __('backend.booking') }} #</th>
                                    <th>{{ __('backend.date') }}</th>
                                    <th>{{ __('backend.time') }}</th>
									<th>{{ __('backend.booking_username') }}</th>
                                    <th>{{ __('backend.reason') }}</th>
                                    <th>{{ __('backend.status') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <!-- <th>#</th>-->
                                    <th>{{ __('backend.booking') }} #</th>
                                    <th>{{ __('backend.date') }}</th>
                                    <th>{{ __('backend.time') }}</th>
									<th>{{ __('backend.booking_username') }}</th>
                                    <th>{{ __('backend.reason') }}</th>
                                    <th>{{ __('backend.status') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($cancel_requests as $cancel_request)
                                    <tr>
                                        <!-- <td>{{ $cancel_request->id }}</td>-->
                                        <td>{{ $cancel_request->booking->id }}</td>
                                        <td>{{ $cancel_request->booking->booking_date }}</td>
                                        <td>{{ $cancel_request->booking->booking_time }}</td>
                                        <td>{{ $cancel_request->booking->user->first_name }} {{ $cancel_request->booking->user->last_name }}</td>
                                        <td>{{ $cancel_request->reason }}</td>
										<td><span class="label {{ $cancel_request->status == __('backend.pending') ? 'label-danger' : 'label-success' }}">{{ $cancel_request->status }}</span></td>
                                        <td>{{ $cancel_request->created_at->diffForHumans() }}</td>
                                        <td>{{ $cancel_request->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('bookings.show', $cancel_request->booking->id) }}" 
											class="btn btn-primary btn-sm"><i class="fa fa-search-plus fa-fw"></i> {{ __('backend.view_booking') }}</a>
											
											<!-- class="btn btn-primary btn-sm">{{ __('backend.view_booking') }}</a> -->

                                            <a href="{{ route('invoice.show', $cancel_request->booking->invoice->id) }}" class="btn btn-info btn-sm"><i class="fa fa-money fa-fw"></i> {{ __('backend.view_invoice') }}</a>
											
                                            @if($cancel_request->status != __('backend.completed'))
                                                <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#update_req{{ $cancel_request->id }}"><i class="fa fa-edit fa-fw"></i> {{ __('backend.update') }}</a>
                                            @endif
                                            <a href="" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_req{{ $cancel_request->id }}"><i class="fa fa-trash fa-fw"></i> {{ __('backend.delete_btn') }}</a>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="update_req{{ $cancel_request->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false">
                                        <div class="modal-dialog">
                                            <form method="post" action="{{ route('cancel-requests.update', $cancel_request->id) }}">
                                                @csrf
                                                {{ method_field('PATCH') }}
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">{{ __('backend.update') }}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>{{ __('backend.status') }}</label>
                                                            <select class="form-control" name="status" required>
                                                                <option {{ $cancel_request->status == __('backend.pending') ? 'selected' : '' }}>{{ __('backend.pending') }}</option>
                                                                <option {{ $cancel_request->status == __('backend.rejected') ? 'selected' : '' }}>{{ __('backend.rejected') }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>{{ __('backend.reason_for_cancellation') }}</label>
                                                            <textarea class="form-control" name="reason" required>{{ $cancel_request->reason }}</textarea>
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

                                    <div id="delete_req{{ $cancel_request->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{ __('backend.delete_cancel_request_message') }}</p>
                                                </div>
                                                <form method="post" action="{{ route('cancel-requests.destroy', $cancel_request->id) }}">
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