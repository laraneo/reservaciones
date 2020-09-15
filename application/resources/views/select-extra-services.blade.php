@extends('layouts.app', ['title' => __('app.step_three_title')])

<style>

.extra-service-counter {
    display: flex;
    justify-content: space-around;
}

.extra-service-counter .counter {
    padding: 3px 10px 3px 10px;
    border-radius: 50px;
    color: white;
    font-weight: bold;
    cursor: pointer;
    font-size: 35px;
}

.extra-service-counter .input-counter input {
    width: 10%;
    text-decoration: none;
    border-color: transparent;
    background-color: transparent;
    font-weight: bold;
    font-size: 20px;
}

.extra-service-counter .counter.add {
   color: blue;
}

.extra-service-counter .counter.remove {
   color: red;
}

.extra-service-delete.show {
    display: block; 
}

.extra-service-delete.hidde {
    display: none; 
}

.extra-service-player-active {
    color: blue;
    font-weight: bold;
}

.owl-theme .owl-nav .owl-next {
    margin-top: -45px !important;
    border-radius: 56px !important;
    background: #007bff !important;
}

.owl-theme .owl-nav .owl-prev {
    margin-top: -45px !important;
    border-radius: 56px !important;
    background: #007bff !important;
}

</style>

@section('content')

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.step_three_title') }}</h1>
            <p class="promo-desc text-center">{{ __('app.step_three_subtitle') }}</p>
        </div>
    </div>
	
	<?php
		include 'BookingCountDown.php';	
	?>		

    <form method="post" id="custom_booking_step_3" action="{{ route('postStep3') }}">
        <input type="hidden" name="session_email" value="{{ Auth::user()->email }}">
        {{ csrf_field() }}
		
		<input type="hidden"  id="countdown" name="countdown" >
		
        <div class="container">
            <div class="content">

			<div class="row begin-countdown">
			  <div class="col-md-12 text-center">
				<progress value="<?php echo $countdown?>" max="<?php echo config('settings.bookingTimeout')*60  ?>" id="pageBeginCountdown"></progress>
				<p> Tiempo restante <span id="pageBeginCountdownText"><?php echo $countdown?> </span> segundos</p>
			  </div>
			</div>
			
			<h6><i class="fas fa-calendar fa-lg text-primary"></i>&nbsp;&nbsp;{{ Session::get('event_date') }} {{ Session::get('booking_slot') }}</h6>

                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mx-lg-5" style="height: 30px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">75%</div>
                        </div>
                    </div>
                </div>

                @if(count($addons))

                    <div class="row" style="margin-top: 30px">
                        <div class="col-md-12">
                            <div class="col-md-12 form-group"><h5 class="text-center">{{ __('app.add_service_title') }}</h5></div>
                                
                                <div class="col-md-12 form-group"><strong><h5>Participantes<h5></strong></div>
                                <div class="col-md-12 form-group">
                                    <div class="row" id="extra-service-participants"></div>
                                </div>
                                <div class="alert alert-danger col-md-12 form-group d-none" id="addon_error"></div>
                                @if($selectedPlayer)
                                    <div class="col-md-12 form-group">
                                        <div class="owl-carousel custom-addons_carousel owl-theme owl-loaded owl-drag" id="custom-addons_carousel">
                                            @foreach($addons as $addon)

                                                <div class="package_box">
                                                        <div class="responsive-image"><img class="responsive-image" alt="{{ $addon->title }}" src="{{ asset($addon->photo->file) }}"></div>
                                                        <div class="package_title">
                                                            <div class="text-container">
                                                                <h4 class="text-center package_title_large paddings">{{ $addon->title }}</h4>
                                                                
                                                                <!--
                                                                <h4 class="text-center package_price">
                                                                    @if(config('settings.currency_symbol_position')==__('backend.right'))

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
                                                                </h4>
                                                                LA -->
                                                                <div class="text-center package_descrition">{!! $addon->description !!}</div>
                                                                <div style="text-align: center">
                                                                    <div class="extra-service-counter">
                                                                        <div class="counter remove" onclick="handleCounter('remove', {{ $addon->id }})" ><i class="fa fa-minus-circle" aria-hidden="true"></i></div>
                                                                        <div class="input-counter" >
                                                                            <input type="text" disabled id="current-addon-{{ $addon->id }}" value="{{ $addon->cant }}" >
                                                                        </div>
                                                                        <div class="counter add" onclick="handleCounter('add', {{ $addon->id }})"><i class="fa fa-plus-circle" aria-hidden="true"></i></div>
                                                                    </div>
                                                                </div>
                                                                <div class="package_btn custom_addon_buttons">
                                                                    <a class="btn btn-primary btn-lg btn-block btn-addon current-addon-{{ $addon->id }} button-default" data-addon-id="{{ $addon->id }}" data-method="add" id="{{ $addon->id }}">{{ $addon->buttonText }}</a>
                                                                    <a class="btn btn-danger btn-lg btn-block btn-addon current-addon-{{ $addon->id }} extra-service-delete {{ $addon->showDelete }}" data-addon-id="{{ $addon->id }}" data-method="remove" id="{{ $addon->id }}">{{ __("app.remove_service_btn") }}</a>
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>

                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                <div class="row">
                                    <div class="col-md-12 form-group" ><strong>Seleccione participante</strong></div>
                                </div>
                                @endif

                            </div>
                        </div>

                @else
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <br><br><br>
                            <h1 class="text-center text-danger">{{ __('app.no_extra_services_title') }}</h1>
                            <br><br>
                            <h3 class="text-center">{{ __('app.no_extra_services_subtitle') }}</h3>
                            <br><br><br>
                            <a class="btn btn-primary btn-lg" href="{{ route('loadFinalStep') }}">{{ __('app.step_three_button') }}</a>
                            <br><br><br>
                        </div>
                    </div>

                @endif
                <input type="hidden" id="selectedPlayer" value="{{ $selectedPlayer }}">
                <input type="hidden" id="isUser" value="">
            </div>
        </div>

        <br><br>
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
                            {{ __('app.step_three_button') }}
                        </button>
                    </div>
                </div>
            </div>
        </footer>

        {{--FOOTER FOR PHONES--}}

        <footer class="footer d-block d-sm-block d-md-none d-lg-none d-xl-none">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="navbar-btn btn btn-primary btn-lg ml-auto">
                            {{ __('app.step_three_button') }}
                        </button>
                    </div>
                </div>
            </div>
        </footer>

    </form>


@endsection

@section('scripts')
	<script>

    function getParticipants(){
            const URL_CONCAT = $('meta[name="index"]').attr('content');
            const selectedPlayer = '{{ $selectedPlayer }}';
            $.ajax({
            type: 'GET',
            url: `${URL_CONCAT}/extra-service-participants`,
                success: function(response) {
                     if(response.success) {
                        let html = '';
                        let addons = '';
                        const data = response.data;
                        data.forEach(element => {
                            const selected = selectedPlayer == element.doc_id ? 'extra-service-player-active' : '';
                            html += `<div class="col-md-12 form-group">
                                <div class="row">
                                    <div class="col-md-12 ${selected}" style="cursor: pointer" onclick=selectParticipant(${element.doc_id},${element.isUser})> 
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
    

    $(document).ready(function(){
        const BASE_URL = $('meta[name="index"]').attr('content');
        $(".owl-carousel.custom-addons_carousel").owlCarousel({
            margin:20,
            dots:false,
            nav:true,
            items: 1,
            navText: [
                '<img src="'+ BASE_URL +'/images/left.png">',
                '<img src="'+ BASE_URL +'/images/right.png">'
            ],
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    loop:true,
                },
                480: {
                    items: 1,
                    loop:true,
                },
                769: {
                    items: 3,
                }
            }
        });

        getParticipants();

        $('.custom_addon_buttons').on('click', 'a.btn-addon', function() {
            const URL_CONCAT = $('meta[name="index"]').attr('content');
            var addon_id = $(this).attr('data-addon-id');
            var addonCount = $(`#current-addon-${addon_id}`).val();
            var method = $(this).attr('data-method');
            const isUser = $('#isUser').val();
            const doc_id = $('#selectedPlayer').val();
            $('#addon_error').addClass('d-none').empty();
            if(method === "add") {
                    $.ajax({
                        type: 'POST',
                        url: URL_CONCAT + '/session_addons',
                        data: {
                            addon_id:addon_id, 
                            session_email:$('input[name=session_email]').val(),
                            doc_id: doc_id,
                            cant: addonCount,
                            isUser: isUser,
                        },
                        success: function(response) {
                            if(response.success) {
                                $(`.current-addon-${addon_id}.extra-service-delete`).removeClass('hidde').addClass('show');
                                $(`.current-addon-${addon_id}.button-default`).text('{{ __("app.update_service_btn") }}');
                                $('#extra-service-participants').empty();
                                getParticipants();
                            } else {
                                $('#addon_error').removeClass('d-none').html(response.message);
                            }

                        }
                    });
            }

            if(method === "remove") {
                    $.ajax({
                        type: 'POST',
                        url: URL_CONCAT + '/remove_session_addon',
                        data: {
                            addon_id:addon_id, 
                            session_email:$('input[name=session_email]').val(),
                            doc_id: doc_id,
                            cant: addonCount,
                        },
                        success: function() {
                            $(`.current-addon-${addon_id}.extra-service-delete`).removeClass('show').addClass('hidde');
                            $(`.current-addon-${addon_id}.button-default`).text('{{ __("app.add_service_btn") }}');
                            $(`#current-addon-${addon_id}`).val(1);
                            $('#extra-service-participants').empty();
                            getParticipants();
                        }
                    });
            }
        });

    });

        function handleCounter(type, id) {
            let currentCount = $(`#current-addon-${id}`).val();
            currentCount = Number(currentCount);

            if(type === "add") {
                currentCount = ++currentCount;
            }

            if(type === "remove" && currentCount > 1) {
                currentCount = --currentCount;
            }
            
            $(`#current-addon-${id}`).val(currentCount);
        }

        function selectParticipant(participant ,isUser = false) {
            $('#selectedPlayer').val(participant);
            $('#isUser').val(isUser);
            const BASE_URL = $('meta[name="index"]').attr('content');
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/extra-service-set-participant',
                data: {
                    doc_id: participant,
                },
                success: function() {
                    window.location.href = '/select-extra-services';
                }
            });
        }

        function renderAddons(list) {
            let html = '';
            list.forEach(element => {
                html += `<div class="col-md-12"><i class="fa fa-angle-right"></i> ${element.addon.title} - <span><strong>${element.cant}</strong></span></div>`;
            });
            return html;
        }
        
        function checkBookingAddonsParameters() {
            const URL_CONCAT = $('meta[name="index"]').attr('content');
            return new Promise(function(resolve, reject) {
                $.ajax({
                type: 'GET',
                url: `${URL_CONCAT}/check-booking-addons`,
                    success: function(response) {
                        resolve(response);
                        return false;
                    },
                })
            });
        }



    $('#custom_booking_step_3').submit(async function(e){
        e.preventDefault();
        $('#addon_error').addClass('d-none').empty();
        let check = true;

        const res = await checkBookingAddonsParameters();

        if(res.success) {
            $('#user_draw_error').removeClass('d-none');
            $('#addon_error').removeClass('d-none').html(res.message);           
            check = false;
        }

        if(check === false) {
            return false;
        } else {
            this.submit();
        }
        
    }); 


	</script>
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
	
@endsection