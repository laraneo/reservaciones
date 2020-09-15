@extends('layouts.app', ['title' => __('app.final_step_title')])

<style>

.booking-collapse-button {
    border: 3px solid #007bff;
    padding: .375rem .75rem;
    font-size: .9rem;
    line-height: 1.6;
    border-radius: .25rem;
    color: #007bff;
}

.booking-collapse-button:hover {
    text-decoration: none;
}

.collapse-href a {
	font-size: 20px;
	color: white;
}


</style>

@section('content')

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.final_step_title') }}</h1>
            <p class="promo-desc text-center">{{ __('app.final_step_subtitle') }}</p>
        </div>
    </div>
	
	<?php
		include 'BookingCountDown.php';	
	?>	


	<input type="hidden"  id="countdown" name="countdown" >

    <div class="container">
        <div class="content">

			<div class="row begin-countdown">
			  <div class="col-md-12 text-center">
				<progress value="<?php echo $countdown?>" max="<?php echo config('settings.bookingTimeout')*60  ?>" id="pageBeginCountdown"></progress>
				<p> Tiempo restante <span id="pageBeginCountdownText"><?php echo $countdown?> </span> segundos</p>
			  </div>
			</div>

            <div class="row">
                <div class="col-md-12">
                    <div class="progress mx-lg-5">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>
                </div>
            </div>

            <div class="row">

                @if(Session::has('paypal_error'))
                    <div class="alert alert-danger col-md-12">{{session('paypal_error')}}</div>
                @endif

                <div class="col-md-6">
                    <br><br>
                    <h3>{{ __('app.booking_summary') }}</h3>
                    <br>
                    <h4>Tipo</h4>
                    <h5>
                        @if(Session::get('booking_type_id') == 1)
                        Reserva Directa
                        @endif
                        @if(Session::get('booking_type_id') == 2)
                        Sorteo
                        @endif
                    </h5>
                    <br>
                    <h5>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
                    <h6><i class="fas fa-envelope fa-lg text-primary"></i>&nbsp;&nbsp;{{ Auth::user()->email }}</h6>
                    <h6><i class="fas fa-phone fa-lg text-primary"></i>&nbsp;&nbsp;{{ Auth::user()->phone_number }}</h6>
					<!--
                    <h6><i class="fas fa-map-marker fa-lg text-primary"></i>&nbsp;&nbsp;{{ Session::get('address')=="" ? 'Not Provided' : Session::get('address') }}</h6>
					LA -->
					
                    <h6><i class="fas fa-calendar fa-lg text-primary"></i>&nbsp;&nbsp;{{ Session::get('event_date') }} {{ Session::get('booking_slot') }}</h6>
                    <br>
                    <h4>{{ __('app.booking_details') }}</h4>
                    <h5>{{ $category }} - {{ $package->title }} - {{ $packageType }}<span class="text-danger">
                          
<!--
						   @if(config('settings.currency_symbol_position')==__('backend.right'))

                                {!! number_format( (float) $package->price,
                                    config('settings.decimal_points'),
                                    config('settings.decimal_separator') ,
                                    config('settings.thousand_separator') ). '&nbsp;' .
                                    config('settings.currency_symbol') !!}

                            @else

                                {!! config('settings.currency_symbol').
                                    number_format( (float) $package->price,
                                    config('settings.decimal_points'),
                                    config('settings.decimal_separator') ,
                                    config('settings.thousand_separator') ) !!}

                            @endif
							LA -->
							
                        </span></h5>
					
					<!--
                    @if(config('settings.enable_gst'))
                        <h5 class="text-primary">{{ __('app.total') }} :
                            @if(config('settings.currency_symbol_position')==__('backend.right'))

                                {!! number_format( (float) $total,
                                    config('settings.decimal_points'),
                                    config('settings.decimal_separator') ,
                                    config('settings.thousand_separator') ). '&nbsp;' .
                                    config('settings.currency_symbol') !!}

                            @else

                                {!! config('settings.currency_symbol').
                                    number_format( (float) $total,
                                    config('settings.decimal_points'),
                                    config('settings.decimal_separator') ,
                                    config('settings.thousand_separator') ) !!}

                            @endif
                        </h5>
                        <p class="text-danger">{{ __('app.gst') }} ({{ config('settings.gst_percentage') }}%) -

                            @if(config('settings.currency_symbol_position')==__('backend.right'))

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

                        </p>
                        <h3 class="text-danger">{{ __('app.grand_total') }} :

                            @if(config('settings.currency_symbol_position')==__('backend.right'))

                                {!! number_format( (float) $total_with_gst,
                                    config('settings.decimal_points'),
                                    config('settings.decimal_separator') ,
                                    config('settings.thousand_separator') ). '&nbsp;' .
                                    config('settings.currency_symbol') !!}

                            @else

                                {!! config('settings.currency_symbol').
                                    number_format( (float) $total_with_gst,
                                    config('settings.decimal_points'),
                                    config('settings.decimal_separator') ,
                                    config('settings.thousand_separator') ) !!}

                            @endif

                        </h3>
                    @else
                        <h3 class="text-danger">{{ __('app.grand_total') }} :

                            @if(config('settings.currency_symbol_position')==__('backend.right'))

                                {!! number_format( (float) $total,
                                    config('settings.decimal_points'),
                                    config('settings.decimal_separator') ,
                                    config('settings.thousand_separator') ). '&nbsp;' .
                                    config('settings.currency_symbol') !!}

                            @else

                                {!! config('settings.currency_symbol').
                                    number_format( (float) $total,
                                    config('settings.decimal_points'),
                                    config('settings.decimal_separator') ,
                                    config('settings.thousand_separator') ) !!}

                            @endif

                        </h3>
                    @endif
					
					LA -->
					

                </div>
                <div class="col-md-12 form-group" style="margin-top: 20px">
                         
                         <div class="row">
                            <div class="col-md-5 form-group" style="margin-right: 5px;"> 
                                <div class="row">
                                    <div class="col-md-12 form-group btn-primary"> 
                                        <div class="row" style="padding: 10px;">
                                            <div class="col-md-6 " style="text-align: left; font-weigth: bold; line-height: 2; font-size: 1.125rem;"> Participantes</div>
                                            <div class="col-md-6 collapse-href" style="text-align: right;"> 
                                                <a class="collapsed" data-toggle="collapse" href="#participantsCollapse" role="button" aria-expanded="false" aria-controls="participantsCollapse">
                                                    <i class="fa fa-angle-down" style="margin-left: 5px"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 collapse" id="participantsCollapse"> 
                                        <div class="row" id="extra-service-participants"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group" > 
                                <div class="row">

                                    <div class="col-md-12 form-group btn-primary"> 
                                        <div class="row" style="padding: 10px;">
                                            <div class="col-md-10 " style="text-align: left; font-weigth: bold; line-height: 2; font-size: 1.125rem;"> Resumen Servicios Adicionales</div>
                                            <div class="col-md-2 collapse-href" style="text-align: right;"> 
                                                <a class="collapsed" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                    <i class="fa fa-angle-down" style="margin-left: 5px"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 collapse" id="collapseExample"> 
                                        <div class="row" id="total-addons"></div>                                        
                                    </div>
                                </div>
                            </div>
                           
                        </div>

                            
                </div>
                         
                         </div>
                <div class="col-md-6">
                    @if(config('settings.google_maps_api_key')!=NULL && Session::get('address')!="")
                        <iframe
                                width="100%"
                                height="400"
                                frameborder="0" style="border:0; width:100%; height:400px; margin-top:13%;"
                                src="https://www.google.com/maps/embed/v1/place?key={{ config('settings.google_maps_api_key') }}&q={{ $event_address }}" allowfullscreen>
                        </iframe>
                    @endif
                </div>
            </div>
							
            <div class="row">
                @if(config('settings.stripe_enabled'))
                    <div class="col-md-6">
                        <br><br>
                        <h5>{{ __('app.pay_with_card') }}</h5>
                        <form method="post" action="{{ route('payWithStripe') }}" id="stripe_cc_form">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" placeholder="{{ __('app.card_number') }}" data-stripe="number" autocomplete="off" maxlength="16">
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control form-control-lg" placeholder="{{ __('app.card_exp_month') }}" data-stripe="exp-month" autocomplete="off" maxlength="2">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control form-control-lg" placeholder="{{ __('app.card_exp_year') }}" data-stripe="exp-year" autocomplete="off" maxlength="2">
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" placeholder="CVC" data-stripe="cvc" autocomplete="off" maxlength="4">
                            </div>

                            <div class="stripe_error"></div>
                            @if(config('settings.stripe_sandbox_enabled'))
                                <div class="alert alert-warning">
                                    {{ __('app.stripe_sandbox_notice') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <button type="submit" class="btn btn-dark btn-lg" name="stripe_cc_form_submit">
                                    <i class="fas fa-circle-notch fa-spin d-none" id="cc_loader"></i>
                                    {{ __('app.pay_with_card') }}
                                </button>
                            </div>

                            @if(!config('settings.offline_payments'))
                                <br><br><br>
                            @endif

                        </form>
                    </div>
                @endif

                <div class="col-md-6">
                    @if(config('settings.paypal_enabled'))
                        <br><br>
                        <h5>{{ __('app.pay_with_paypal') }}</h5>
                        <a href="{{ route('payWithPaypal') }}" class="btn btn-primary btn-lg btn-block"><i class="fab fa-paypal"></i> {{ __('app.pay_with_paypal') }}</a>
                        <br>
                        @if(config('settings.paypal_sandbox_enabled'))
                            <div class="alert alert-warning">
                                {{ __('app.paypal_sandbox_notice') }}
                            </div>
                        @endif
                        <div class="alert alert-info">* {{ __('app.paypal_redirect_notice') }}</div>
                        <br><br><br>
                    @endif
                </div>

                <div class="col-md-6">
                     @if(config('settings.offline_payments'))
                        <br><br>
                        <h5>{{ __('app.offline_payment_heading') }}</h5>
                        <a href="{{ route('payOffline') }}" class="btn btn-success btn-lg btn-block"><i class="far fa-file-alt"></i>&nbsp;&nbsp;{{ __('app.complete_booking') }}</a>
                        <br><br><br>
                     @endif
                </div>

                @if(!config('settings.paypal_enabled') && !config('settings.stripe_enabled') && !config('settings.offline_payments'))
                     <div class="col-md-12">
                         <br><br>
                         <div class="alert alert-danger">{{ __('app.no_gateway_error') }}</div>
                         <br><br><br>
                     </div>
                @endif

            </div>


			
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                        <span class="text-copyrights">
                            {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }} {{ config('settings.business_name', 'Bookify') }}.
                        </span>
                </div>
            </div>
        </div>
    </footer>

@endsection

@section('scripts')
    @if(config('settings.stripe_enabled'))
        <script src="https://js.stripe.com/v2/"></script>
        <script type="text/javascript">
            Stripe.setPublishableKey('{{ config('settings.stripe_sandbox_enabled') ?
        config('settings.stripe_test_key_pk') : config('settings.stripe_live_key_pk') }}');
            $('#stripe_cc_form').submit(function(e){
                $form = $(this);
                $form.find('button').prop('disabled',true);
                $('#cc_loader').removeClass('d-none');
                Stripe.card.createToken($form,function(status,response){

                    if(response.error){
                        $('#cc_loader').addClass('d-none');
                        $form.find('.stripe_error').html('<div class="alert alert-danger">'+response.error.message+'</div>');
                        $form.find('button').prop('disabled',false);
                    }
                    else{
                        var token = response.id;
                        $form.append($('<input type="hidden" name="stripe-token">').val(token));
                        $form.get(0).submit();
                    }
                });
                return false;
            });
        </script>
    @endif

    	<script>
		ProgressCountdown(<?php echo $countdown;?>, 'pageBeginCountdown', 'pageBeginCountdownText').then(value => window.location.href = `logoutBooking`);


		function ProgressCountdown(timeleft, bar, text) {
		  return new Promise((resolve, reject) => {
			var countdownTimer = setInterval(() => {
			  timeleft--;

			  document.getElementById(bar).value = timeleft;
			  document.getElementById(text).textContent = timeleft;
			  document.getElementById('countdown').value = timeleft;

			  if (timeleft <= 0) {
				clearInterval(countdownTimer);
				resolve(true);
			  }
			}, 1000);
		  });
		}
	</script>
	
    <script>

    function getTotalAddons() {
            const URL_CONCAT = $('meta[name="index"]').attr('content');
            $.ajax({
            type: 'GET',
            url: `${URL_CONCAT}/total-session-addons`,
                beforeSend: function() {
                    $('#total-addons').empty();
                },
                success: function(response) {
                   let html = '';
                   const data = response.addons;
                    data.forEach(element => {
                        html += `<div class="col-md-12">
                                    <i class="fa fa-angle-right"></i> ${element.title} - <span>
                                    <strong>${element.total}</strong></span>
                                </div>`;
                    });
                    $('#total-addons').html(html);
                },
            });
    }

    function handleAddonDelete(id) {
            const URL_CONCAT = $('meta[name="index"]').attr('content');
            $.ajax({
            type: 'GET',
            url: `${URL_CONCAT}/remove-adddon-by-participant`,
            data: { id: id },
                success: function(response) {
                    getParticipants(); 
                },
            });
    }

    function renderAddons(list) {
            let html = '';
            list.forEach(element => {
                html += `<div class="col-md-12">
                            <i class="fa fa-angle-right"></i> ${element.addon.title} - <span>
                            <strong>${element.cant}</strong></span>
                            <span class="btn btn-danger btn-sm" style="margin-left:5px" onclick="handleAddonDelete(${element.id})" ><i class="far fa-trash-alt"></i></span>
                         </div>`;
            });
            return html;
    }


    function getParticipants(){
            const URL_CONCAT = $('meta[name="index"]').attr('content');
            const selectedPlayer = '{{ $selectedPlayer }}';
            $.ajax({
            type: 'GET',
            url: `${URL_CONCAT}/extra-service-participants`,
                beforeSend: function() {
                    $('#extra-service-participants').empty();
                },
                success: function(response) {
                     if(response.success) {
                        let html = '';
                        let addons = '';
                        const data = response.data;
                        data.forEach(element => {
                            html += `<div class="col-md-12 form-group">
                                <div class="row">
                                    <div class="col-md-12" style="cursor: pointer"> 
                                        <i class="${element.isUser ? 'fa fa-star' : 'fa fa-user'}"></i> ${element.doc_id} ${element.first_name} ${element.last_name} 
                                    </div>
                                    ${element.addons.length > 0 ?
                                        `<div class="col-md-12"> 
                                            <div class="row" style='margin-left: 1px'>${ renderAddons(element.addons) }</div>
                                        </div>` 
                                    : ''}
                                </div>
                            </div>`
                        });
                         $('#extra-service-participants').html(html);
                     }
                     
                },
            });
        }

        getParticipants();
        getTotalAddons();


</script>
	
@endsection