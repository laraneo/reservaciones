@extends('layouts.customer', ['title' => __('backend.invoices')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.invoices') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.invoices') }}</li>
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
                            <h4 class="panel-title">{{ __('backend.invoices') }}</h4>
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
                                    <th>{{ __('backend.created') }}</th>
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
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->id }}</td>
                                        <td>{{ $invoice->booking->id }}</td>
                                        <td>

                                            @if(config('settings.currency_symbol_position')== __('backend.right'))

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
                                            <td><span class="label label-danger">{{ __('backend.invoice_refunded') }}</span></td>
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
                                        <td>{{ $invoice->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('showInvoice', $invoice->id) }}" class="btn btn-primary btn-sm">{{ __('backend.view_invoice') }}</a>
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