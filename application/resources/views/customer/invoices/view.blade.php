@extends('layouts.customer', ['title' => __('backend.view_invoice')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.view_invoice') }} # {{ $invoice->id }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('customerInvoices') }}">{{ __('backend.invoices') }}</a></li>
                <li class="active">{{ __('backend.view_invoice') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="invoice col-md-12">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h1 class="m-b-md"><b>{{ config('settings.business_name') }}</b></h1>
                                <address>
                                    <strong>{{ __('backend.email') }}</strong>: {{ config('settings.contact_email') }}<br>
                                    <strong>{{ __('backend.phone') }}</strong>: {{ config('settings.contact_number') }}
                                </address>
                            </div>
                            <div class="col-md-8 hidden-sm hidden-xs text-right">
                                @if($invoice->is_refunded)
                                    <h1 class="text-danger">{{ strtoupper(__('backend.invoice_refunded')) }}</h1>
                                @endif

                                @if(!$invoice->is_paid && $invoice->booking->status != __('backend.cancelled'))
                                    <h1 class="text-danger">{{ strtoupper(__('emails.to_be_paid')) }}</h1>
                                @endif

                                @if(!$invoice->is_paid && $invoice->booking->status == __('backend.cancelled'))
                                    <h1 class="text-danger">{{ strtoupper(__('backend.cancelled')) }}</h1>
                                @endif

                                @if($invoice->is_paid && !$invoice->is_refunded)
                                    <h1 class="text-primary">{{ strtoupper(__('backend.invoice_paid')) }}</h1>
                                @endif
                            </div>
                            <div class="col-md-8 hidden-md hidden-lg">
                                @if($invoice->is_refunded)
                                    <h1 class="text-danger">{{ strtoupper(__('backend.invoice_refunded')) }}</h1>
                                @endif

                                @if(!$invoice->is_paid && $invoice->booking->status != __('backend.cancelled'))
                                    <h1 class="text-danger">{{ strtoupper(__('emails.to_be_paid')) }}</h1>
                                @endif

                                @if(!$invoice->is_paid && $invoice->booking->status == __('backend.cancelled'))
                                    <h1 class="text-danger">{{ strtoupper(__('backend.cancelled')) }}</h1>
                                @endif

                                @if($invoice->is_paid && !$invoice->is_refunded)
                                    <h1 class="text-primary">{{ strtoupper(__('backend.invoice_paid')) }}</h1>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <hr>
                                <p>
                                    <strong>{{ __('backend.invoice_to') }}</strong><br>
                                    {{ $invoice->booking->user->first_name }}
                                    {{ $invoice->booking->user->last_name }}<br>
                                    <strong>{{ __('backend.phone') }}</strong>: {{ $invoice->booking->user->phone_number }}<br>
                                    <strong>{{ __('backend.email') }}</strong>: {{ $invoice->booking->user->email }}<br>
                                    {{ $invoice->booking->booking_address }}
                                </p>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>{{ __('backend.item') }}</th>
                                        <th>{{ __('backend.quantity') }}</th>
                                        <th>{{ __('backend.price') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{ $invoice->booking->package->category->title }} - {{ $invoice->booking->package->title }}</td>
                                        <td>1</td>
                                        <td>

                                            @if(config('settings.currency_symbol_position')== __('backend.right'))

                                                {!! number_format( (float) $invoice->booking->package->price,
                                                    config('settings.decimal_points'),
                                                    config('settings.decimal_separator') ,
                                                    config('settings.thousand_separator') ). '&nbsp;' .
                                                    config('settings.currency_symbol') !!}

                                            @else

                                                {!! config('settings.currency_symbol').
                                                    number_format( (float) $invoice->booking->package->price,
                                                    config('settings.decimal_points'),
                                                    config('settings.decimal_separator') ,
                                                    config('settings.thousand_separator') ) !!}

                                            @endif

                                        </td>
                                    </tr>
                                    @if(count($invoice->booking->addons))
                                        @foreach($invoice->booking->addons as $addon)
                                            <tr>
                                                <td>{{ $addon->title }}</td>
                                                <td>1</td>
                                                <td>

                                                    @if(config('settings.currency_symbol_position')== __('backend.right'))

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

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-8">
                                <h3>{{ __('backend.thank_you') }}</h3>
                            </div>
                            <div class="col-md-4">
                                <div class="text-right">
                                    @if(config('settings.enable_gst')==1)

                                        <h4 class="no-m m-t-sm">{{ __('backend.subtotal') }}</h4>
                                        <h2 class="no-m">

                                            @if(config('settings.currency_symbol_position')== __('backend.right'))

                                                {!! number_format( (float) $invoice->amount - $gst_amount,
                                                    config('settings.decimal_points'),
                                                    config('settings.decimal_separator') ,
                                                    config('settings.thousand_separator') ). '&nbsp;' .
                                                    config('settings.currency_symbol') !!}

                                            @else

                                                {!! config('settings.currency_symbol').
                                                    number_format( (float) $invoice->amount - $gst_amount,
                                                    config('settings.decimal_points'),
                                                    config('settings.decimal_separator') ,
                                                    config('settings.thousand_separator') ) !!}

                                            @endif

                                        </h2>
                                        <hr>
                                        <h4 class="no-m m-t-sm">{{ __('backend.gst') }} {{ config('settings.gst_percentage') }}%</h4>
                                        <h2 class="no-m">

                                            @if(config('settings.currency_symbol_position')== __('backend.right'))

                                                {!! number_format( (float) $gst_amount,
                                                    config('settings.decimal_points'),
                                                    config('settings.decimal_separator') ,
                                                    config('settings.thousand_separator') ). '&nbsp;' .
                                                    config('settings.currency_symbol') !!}

                                            @else

                                                {!! config('settings.currency_symbol').
                                                    number_format( (float) $gst_amount,
                                                    config('settings.decimal_points'),
                                                    config('settings.decimal_separator') ,
                                                    config('settings.thousand_separator') ) !!}

                                            @endif

                                        </h2>
                                        <hr>
                                        <h4 class="no-m m-t-md text-success">{{ __('backend.Total') }}</h4>
                                        <h1 class="no-m text-success">
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
                                        </h1>

                                    @else

                                        <h4 class="no-m m-t-md text-success">{{ __('backend.Total') }}</h4>
                                        <h1 class="no-m text-success">

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

                                        </h1>

                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--row-->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection