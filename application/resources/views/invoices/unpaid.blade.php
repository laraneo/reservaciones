@extends('layouts.admin', ['title' => __('backend.unpaid_invoices')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.unpaid_invoices') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.unpaid_invoices') }}</li>
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
                            <h4 class="panel-title">{{ __('backend.unpaid_invoices') }}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.booking') }}#</th>
                                    <th>{{ __('backend.amount') }}</th>
                                    <th>{{ __('backend.payment_method') }}</th>
                                    <th>{{ __('backend.status') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.booking') }}#</th>
                                    <th>{{ __('backend.amount') }}</th>
                                    <th>{{ __('backend.payment_method') }}</th>
                                    <th>{{ __('backend.status') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($invoices as $invoice)
                                    @if(!$invoice->is_paid)
                                        <tr>
                                            <td>{{ $invoice->id }}</td>
                                            <td>{{ $invoice->booking_id }}</td>
                                            <td>

                                                @if(config('settings.currency_symbol_position')=="__('backend.__('backend.right')')")

                                                    {!! number_format( (float) $invoice->amount,
                                                        config('settings.decimal_points'),
                                                        config('settings.decimal_separator') ,
                                                        config('settings.thousand_separator') ). '&nbsp;' .
                                                        config('settings.currency_symbol') !!}

                                                @else

                                                    {!! config('settings.currency_symbol').
                                                        number_format( (float) $invoice->amount,
                                                        config('settings.decimal_points'),
                                                        config('settings.decimal_separator') ,
                                                        config('settings.thousand_separator') ) !!}

                                                @endif

                                            </td>
                                            <td>{{ $invoice->payment_method }}</td>

                                            @if($invoice->is_refunded)
                                                <td><span class="label label-danger">{{ __('backend.invoices_refunded') }}</span></td>
                                            @endif

                                            @if(!$invoice->is_paid && $invoice->booking->status != __('backend.cancelled'))
                                                <td><span class="label label-danger">{{ __('emails.to_be_paid') }}</span></td>
                                            @endif

                                            @if(!$invoice->is_paid && $invoice->booking->status == __('backend.cancelled'))
                                                <td><span class="label label-danger">{{ __('backend.cancelled') }}</span></td>
                                            @endif

                                            @if($invoice->is_paid && !$invoice->is_refunded)
                                                <td><span class="label label-primary">{{ __('backend.paid') }}</span></td>
                                            @endif
                                            <td>
                                                <a href="{{ route('invoice.show', $invoice->id) }}" class="btn btn-primary btn-sm">{{ __('backend.view_invoice') }}</a>
                                                @if(!$invoice->is_paid && $invoice->booking->status != __('backend.cancelled'))
                                                    <a data-toggle="modal" data-target="#{{ $invoice->id }}" class="btn btn-danger btn-sm">{{ __('backend.paid') }}</a>
                                                @endif
                                            </td>

                                            <!-- payment confirm modal -->
                                            <div id="{{ $invoice->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('backend.mark_paid_message') }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{ route('invoice.edit', $invoice->id) }}" class="btn btn-danger">{{ __('backend.paid') }}</a>
                                                            <a type="button" class="btn btn-primary" data-dismiss="modal">{{ __('backend.no') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </tr>
                                    @endif
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