@extends('layouts.app', ['title' => __('app.step_two_page_title')])

@section('styles')

    <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datepicker.min.css') }}">
    <style>   
        .slot-draw-picked {
            background-color: #ffc107;
            border: 1px solid #ffc107 !important;
            border-color: #ffc107 !important;
            color: black !important;
        }
        .btn-outline-yellow {
            border-color: #4e5e6a !important;
        }
        .btn-outline-yellow:hover {
            background-color: #ffc107;
            border-color: #777 !important;
        }
    </style>

@endsection

@section('content')

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.step_two_page_title') }}</h1>
            <p class="promo-desc text-center">{{ __('app.step_two_subtitle') }}</p>
        </div>
    </div>

    <form method="post" id="custom_booking_step_2" action="{{ route('postStep2') }}">
        {{ csrf_field() }}
		
		<input type="hidden"  id="countdown" name="countdown" >
		
        <div class="container">
            <div class="content">
			
			<?php
			/*
			<div class="row begin-countdown">
			  <div class="col-md-12 text-center">
				<progress value="{{  Session::get('countdown')  }}" max="<?php echo config('settings.bookingTimeout')*60  ?>" id="pageBeginCountdown"></progress>
				<p> Tiempo restante <span id="pageBeginCountdownText">{{   Session::get('countdown')  }} </span> segundos</p>
			  </div>
			</div>*/
			?>
			
                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mx-lg-5">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">35%</div>
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
									
									<div class="responsive-image"><img class="responsive-image"  alt="Golf" src="/images/reservacion.jpg"></div>
                                    <h4 class="text-center text-success">
                                    </h4>
                                    
                                    <div class="text-center package_description">Reserva Directa</div>
                                    <div class="package_btn ">
                                        <a class="btn btn-primary btn-lg btn-block btn_package_select package-event" booking-type-id="1" >Seleccionar</a>
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
									
									<div class="responsive-image"><img class="responsive-image"    alt="Golf" src="/images/sorteo.jpg"></div>									
                                    <h4 class="text-center text-success">
                                    </h4>
                                    
                                    <div class="text-center package_description">Sorteo</div>
                                    <div class="package_btn ">
                                        <a class="btn btn-primary btn-lg btn-block btn_package_select package-draw"  booking-type-id="2" >Seleccionar</a>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>              
                    </div>                                                                                   
				</div>


    @if(Session::get('booking_type_id'))
                <div class="row">
                    <div class="col-md-6">
                        
						<!--
						<br><br>
                        <h5>{{ __('app.provide_address') }}</h5>
                        <br>
                        <div class="form-group">
                            <input id="autocomplete" placeholder="{{ __('app.address_placeholder') }}" onFocus="geolocate()"
                                   name="address" type="text" class="form-control form-control-lg" autocomplete="off">
                            <p class="form-text text-danger d-none" id="address_error_holder">
                                {{ __('app.address_error') }}
                            </p>
                        </div>
						LA -->
						
                        <br>
                        <h5>{{ __('app.select_date') }}</h5>
                        <br>
                        <div class="form-group">
                        @if(Session::get('booking_type_id') == 1)
                            <input type="text" class="form-control form-control-lg" name="custom-event_date"
                            id="custom-event_date" placeholder="{{ __('app.date_placeholder') }}" autocomplete="off" readonly>
                            <p class="form-text text-danger d-none" id="date_error_holder" >
                            {{ __('app.date_error') }}
                            </p>
                        @endif
                        @if(Session::get('booking_type_id') == 2)
                            <div id="draw-list"></div>
                         @endif
                        </div>
                        <input type="hidden" name="booking_type_id" id="booking_type_id" value={{Session::get('booking_type_id')}}>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <br>
                            <h5>{{ __('app.add_instructions') }}</h5>
                            <br>
                            <textarea class="form-control" name="instructions" rows="4" placeholder="{{ __('app.add_instructions_placeholder') }}"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="slots_loader" class="d-none"><p style="text-align: center;"><img src="{{ asset('images/loader.gif') }}" width="52" height="52"></p></div>
                    </div>
                </div>
  @endif
                <br>
                <div id="custom_slots_holder" data-booking-type="{{ Session::get('booking_type_id') }}"></div>
                <div class="row col-md-12">
                    <div class="alert alert-danger col-md-12 d-none" id="slot_error" style="margin-bottom: 50px;">
                        {{ __('app.time_slot_error') }}
                    </div>
                    <div class="alert alert-danger col-md-12 d-none" id="user_draw_error" style="margin-bottom: 50px;">
                        {{ __('app.draw_user_error') }}
                    </div>
                    <div class="alert alert-danger col-md-12 d-none" id="booking_type_error" style="margin-bottom: 50px;">
                        Seleccione Modalidad
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="data-booking-type" value='{{ Session::get('booking_type_id') }}'>
        <input type="hidden" name="draw_booking_slot" id="draw_booking_slot" value=''>
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
                            {!! __('pagination.next') !!}
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
                            {!! __('pagination.next') !!}
                        </button>
                    </div>
                </div>
            </div>
        </footer>

    </form>

@endsection

@section('scripts')


    <script src="{{ asset('plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    @if(App::getLocale()=="es")
        <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    @elseif(App::getLocale()=="fr")
        <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.fr.min.js') }}"></script>
    @elseif(App::getLocale()=="de")
        <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.de.min.js') }}"></script>
    @elseif(App::getLocale()=="da")
        <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.da.min.js') }}"></script>
    @elseif(App::getLocale()=="it")
        <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.it.min.js') }}"></script>
    @elseif(App::getLocale()=="pt")
        <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.pt.min.js') }}"></script>
    @endif



    <script>
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        var maxDate = new Date();
		maxDate.setDate(today.getDate() +  {{ \App\Settings::query()->first()->bookingUser_maxDays }} );  //LA set maximum booking days on future
		$('#custom-event_date').datepicker({
            orientation: "auto right",
            autoclose: true,
            startDate: today,
			endDate: maxDate,
			
            format: 'dd-mm-yyyy',
            daysOfWeekDisabled: "{{ $disable_days_string }}",
            language: "{{ App::getLocale() }}"
        });

        $('body').on('click', 'a.btn_package_select', function() {
                const BASE_URL = $('meta[name="index"]').attr('content');
                var booking_type_id = $(this).attr('booking-type-id');
                $('#booking_type_error').addClass('d-none');

                $('#booking_type_id').remove();
                $('#booking_step_1-1').append('<input type="hidden" attr-1 name="booking_type_id" id="booking_type_id" value="'+booking_type_id+'">');

                $('.btn_package_select').text('{{ __("app.booking_package_btn_select") }}').removeClass('btn-danger').addClass('btn-primary');
                $(this).text('{{ __("app.booking_package_btn_selected") }}').removeClass('btn-primary').addClass('btn-danger');
                console.log('flag');
                $.ajax({
                            type: 'POST',
                            url: BASE_URL + '/setStep2',
                            data: {
                            booking_type_id:booking_type_id,
                        },
                            success: function(response) {
                                window.location.href = '/select-booking-time'

                            },
                        });
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

    function onSelectDraw() {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
            const id = document.getElementById("select-draw").value;
                console.log('id ', id);
                $('#hour-list').empty();
                 $('#draw_booking_slot').val('');
                $.ajax({
                type: 'GET',
                url: `${URL_CONCAT}/get-date-draw?id=${id}`,
                    success: function(response) {
                        const selectedDate = response.date;  
                        $('#custom_booking_step_2').append('<input type="hidden" name="custom-event_date" id="custom-event_date" value="'+selectedDate+'">');
                        $.ajax({
                            type: 'POST',
                            url: URL_CONCAT + '/get_timing_slots',
                            data: {
                            event_date:selectedDate,
                        },
                            beforeSend: function() {
                                $('#slots_loader').removeClass('d-none');
                            },
                            success: function(response) {
                                $('#custom_slots_holder').html(response);

                            },
                            complete: function () {
                                $('#slots_loader').addClass('d-none');
                            }
                        });
                    },
                }); 
        }

    $('input[id="custom-event_date"]').change(function () {
        //populate timing slots
        var selected_date;
        selected_date = $(this).val();
        var URL_CONCAT = $('meta[name="index"]').attr('content');

        //prepare to send ajax request
        $.ajax({
            type: 'POST',
            url: URL_CONCAT + '/get_timing_slots',
            data: {event_date:selected_date},
            beforeSend: function() {
                $('#slots_loader').removeClass('d-none');
            },
            success: function(response) {
                $('#custom_slots_holder').html(response);
            },
            complete: function () {
                $('#slots_loader').addClass('d-none');
            }
        });
    });

    function getDraws() {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
                $.ajax({
                type: 'GET',
                url: `${URL_CONCAT}/get-draws`,
                beforeSend: function() {
                    $('#slots_loader').removeClass('d-none');
                },
                success: function(response) {
                    console.log('response ', response);
                    $('#draw-list').html(response);
                },
                complete: function () {
                    $('#slots_loader').addClass('d-none');
                }
            });
    }

    function setBookingType() {
        var bookingType = document.getElementById("data-booking-type").value;
        if(bookingType == 1) {
            $('.package-event').removeClass('btn-primary').addClass('btn-danger');
        }
        if(bookingType == 2) {
            $('.package-draw').removeClass('btn-primary').addClass('btn-danger');
        }
        
    }
    setBookingType();
    getDraws();

    $( "a.btn-slot" ).on( "mouseenter", function() {
         console.log('ddd');
        } 
    );

    const array = [];
    $('#custom_slots_holder').on('click', 'a.btn-slot', function() {
        var slot_time = $(this).attr('data-slot-time');
        var bookingType = document.getElementById("data-booking-type").value;

        if(bookingType === "1") {
            $('#custom_slots_holder').find('.btn-slot').removeClass('slot-picked');
            $('#booking_slot').remove();
            $('#custom_booking_step_2').append('<input type="hidden" name="booking_slot" id="booking_slot" value="'+slot_time+'">');
            $(this).addClass('slot-picked');
        }

        if(bookingType === "2") {
             const hourSlots = $('input[name=draw_booking_slot]').val();
             if(hourSlots) {
                 const slots = JSON.parse(hourSlots);
                 const exist = slots.find(e => e === slot_time);
                 if(!exist &&  slots.length < 3) {
                     slots.push(slot_time);
                     $('#draw_booking_slot').val(JSON.stringify(slots));
                     renderHours(slots);
                     $(this).addClass('slot-draw-picked');  
                 }   
             } else {
                const array = [];
                array.push(slot_time);
                $('#draw_booking_slot').val(JSON.stringify(array));
                renderHours(array);
                $(this).addClass('slot-draw-picked');  
             }
                   
                //getHourList(event_date, slot_time);
        }
    }); 

    function getHourList(date, hour) {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
        $.ajax({
        type: 'POST',
        url: `${URL_CONCAT}/set-hour-list`,
        data: {
            date: date,
            hour: hour,
            },
            success: function(response) {
                renderHours(response.hours);
            },
        });
    }

    function checkDrawUser() {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
        return new Promise(function(resolve, reject) {
            $.ajax({
            type: 'GET',
            url: `${URL_CONCAT}/check-user-draw`,
                success: function(response) {
                    console.log('response ', response);
                    resolve(response.check);
                    return false;
                },
            })
        });
    }

    function removeHour(hour) {
        $( ".custom-slot-list div" ).each(function( index ) {
            const time = $('a.btn-slot').eq(index).text();
            if(time.trim() == hour.trim()) {
                $('a.btn-slot').eq(index).removeClass('slot-draw-picked');
            }
        });
        const hourSlots = $('input[name=draw_booking_slot]').val();
        const slots = JSON.parse(hourSlots);
        const newList = slots.filter(e => e !== hour);
        renderHours(newList);
        $('#draw_booking_slot').val(JSON.stringify(newList));
    }

    function renderHours(list){
         $('#hour-list').empty();
        let html = '';
        list.forEach((element, index) => {
            html += `<div id="delete-hour" style="display: flex; justify-content: flex-start; margin: 5px 0px 5px 0px">
            <div style="border: 1px solid black; width: 50%; padding: 5px; text-align: center; border-radius: 5px;">${element}</div>
            <div style="padding: 5px; cursor: pointer" onclick="removeHour('${element}')">X</div>
            </div>
            `;
        });
        $('#hour-list').html(html);
    }
    
    $('#custom_booking_step_2').submit(async function(e){
        e.preventDefault();
        var check = true;
        var address;
        address = $('input[name=address]').val();
        var event_date;
        event_date = $('input[name=custom-event_date]').val();
        var booking_slot;
        booking_slot = $('input[name=booking_slot]').val();
        const hourBookingSlots = $('input[name=draw_booking_slot]').val();
        const bookinType = $('input[name=booking_type_id]').val();

        if(!bookinType) {
            $('#booking_type_error').removeClass('d-none');
            $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
            check = false;
        }

        if(event_date === "") {
            $('#custom-event_date').addClass('is-invalid');
            $('#date_error_holder').removeClass('d-none');
            $("html, body").animate({ scrollTop: 2000 }, "slow");
            check = false;
        }

        if(bookinType === "1") {
            if(booking_slot === undefined) {
                $('#slot_error').removeClass('d-none');
                $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                check = false;
            }
        }

        if(bookinType === "2") {
            if(hourBookingSlots === '') {
                $('#slot_error').removeClass('d-none');
                $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                check = false;
            }
            const value = await checkDrawUser();
            if(value) {
                $('#user_draw_error').removeClass('d-none');
                $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                check = false;
            }
        }

        if(check === false) {
            return false;
        } else {
            this.submit();
        }
    });    
    
    
    
    
    
    
    
    </script>


    @if(config('settings.google_maps_api_key') != NULL)
        <script src="{{ asset('js/map.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.google_maps_api_key') }}&libraries=places&callback=initAutocomplete" async defer></script>
    @endif
	

<script>

// ProgressCountdown( {{  Session::get('countdown')  }} , 'pageBeginCountdown', 'pageBeginCountdownText').then(value => window.location.href = `logoutBooking`);

 
// function ProgressCountdown(timeleft, bar, text) {
  // return new Promise((resolve, reject) => {
    // var countdownTimer = setInterval(() => {
      // timeleft--;

      // document.getElementById(bar).value = timeleft;
      // document.getElementById(text).textContent = timeleft;
	  // document.getElementById('countdown').value = timeleft;

      // if (timeleft <= 0) {
        // clearInterval(countdownTimer);
        // resolve(true);
      // }
    // }, 1000);
  // });
// }
</script>

@endsection