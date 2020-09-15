@extends('layouts.app', ['title' => __('app.step_players_page_title')])

 
@section('content')


<?php
	$domain_id = config('settings.business_name', 'Reservaciones');
	$date = date('Y-m-d');
	$calculated_token = md5($domain_id.$date);	
	//$calculated_token = $domain_id.$date.date_default_timezone_get();	
	//$calculated_token = "123";
?>

<script language="javascript" type="text/javascript">

</script> 

<form method="post" id="booking_step_1-1" action="{{ Auth::user() ? route('setStep2') : route('register') }}">
    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">Seleccionar Fecha y Hora de reserva</h1>
            <p class="promo-desc text-center">{{ __('app.step_players_subtitle') }}</p>
        </div>
    </div>
        <input type="hidden" name="session_email" value="{{ Auth::user()->email }}">
        {{ csrf_field() }}
		
		<input type="hidden"  id="countdown" name="countdown" >
		
		
        <div class="container">
            <div class="content">	
			<h6><i class="fas fa-calendar fa-lg text-primary"></i>&nbsp;&nbsp;{{ Session::get('event_date') }} {{ Session::get('booking_slot') }}</h6>

                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mx-lg-5" style="height: 30px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">35%</div>

                        </div>
                    </div>
                </div>
				<br><br>
                <div class="row"><div class="col-md-12"><h5>Seleccionar Modalidad</h5></div></div>
                <br><br>
				<div class="row">
                <div class="col">
                    <div class="package_box">
                        <div class="responsive-image"><img class="responsive-image"></div>
                            <div class="package_title">
                                <div class="text-container">
									
                                    <h3 class="text-center package_title_large">Reserva Directa</h3>			
									
									<div class="responsive-image"><img class="responsive-image" alt="Golf" src="/images/reservacion.jpg"></div>
                                    <h4 class="text-center text-success">
                                    </h4>
                                    
                                    <div class="text-center package_description">Reserva Directa</div>
                                    <div class="package_btn">
                                        <a class="btn btn-primary btn-lg btn-block btn_package_select" booking-type-id="1" >Seleccionar</a>
                                    </div>
                                    <br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">      
                    <div class="package_box">
                        <div class="responsive-image"><img class="responsive-image"></div>
                            <div class="package_title">
                                <div class="text-container">
                                    <h3 class="text-center package_title_large">Sorteo</h3>		
									
									<div class="responsive-image"><img class="responsive-image" alt="Golf" src="/images/sorteo.jpg"></div>									
                                    <h4 class="text-center text-success">
                                    </h4>
                                    
                                    <div class="text-center package_description">Sorteo</div>
                                    <div class="package_btn">
                                        <a class="btn btn-primary btn-lg btn-block btn_package_select"  booking-type-id="2" >Seleccionar</a>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>              
                    </div>                                                                                   
				</div>

                <div class="col">
                    <div class="col-md-12">
                        <div class="alert alert-danger d-none" id="booking_type_error">Por favor seleccione una modalidad para continuar</div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer d-none d-sm-none d-md-block d-lg-block d-xl-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-copyrights">
                            {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }} {{ config('settings.business_name', 'Bookify') }}.
                        </span>
                    </div>
					
                    <div class="col-md-6 text-right">
                        <button type="submit" class="navbar-btn btn btn-primary btn-lg ml-auto">
                            <i class="far fa-clock"></i> &nbsp; {{ __('app.welcome_post_btn') }}
                        </button>
                    </div>
					
	<!--				
					<div class="col-md-6 text-right">
                       <button type="submit" class="navbar-btn btn btn-primary btn-lg ml-auto">
                           {{ __('app.step_player_button') }}
                       </button>
                   </div>	
-->				   
					
                </div>
            </div>
        </footer>

 {{--FOOTER FOR PHONES--}}

        <footer class="footer d-block d-sm-block d-md-none d-lg-none d-xl-none">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="navbar-btn btn btn-primary btn-lg ml-auto">
                            <i class="far fa-clock"></i> &nbsp; {{ __('app.welcome_post_btn') }}
                        </button>
                    </div>
                </div>
            </div>
        </footer>
    </form>

@endsection

@section('scripts')
	<script>
        $('body').on('click', 'a.btn_package_select', function() {
                var booking_type_id = $(this).attr('booking-type-id');
                console.log('booking_type_id ', booking_type_id);
                $('#booking_type_error').addClass('d-none');

                $('#booking_type_id').remove();
                $('#booking_step_1-1').append('<input type="hidden" attr-1 name="booking_type_id" id="booking_type_id" value="'+booking_type_id+'">');

                $('.btn_package_select').text('{{ __("app.booking_package_btn_select") }}').removeClass('btn-danger').addClass('btn-primary');
                $(this).text('{{ __("app.booking_package_btn_selected") }}').removeClass('btn-primary').addClass('btn-danger');
            });
            $('#booking_step_1-1').submit(function(e){
                const booking_type  = $('input[name=booking_type_id]').val();
                let check = true;
                console.log('booking_type ', booking_type);
                if(!booking_type) {
                    $('#booking_type_error').removeClass('d-none');
                    $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                    check = false;
                }
                console.log('check ', check);
                if(check) {
                   e.submit(); 
                }
                return false
            });
	</script>
	
@endsection