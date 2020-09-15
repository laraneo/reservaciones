@extends('layouts.app', ['title' => __('app.step_two_page_title')])

@section('styles')

    <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datepicker.min.css') }}">
    <style>   
        .slot-draw-picked {
            background-color: #4e5e6a;
            border: 1px solid #4e5e6a !important;
            border-color: #4e5e6a !important;
            color: white !important;
        }
        .btn-outline-yellow {
            border-color: #4e5e6a !important;
        }
        .btn-outline-yellow:hover {
            background-color: #4e5e6a;
            border-color: #777 !important;
        }

        .type_title.package-event.active {
            background-color: #277cea;
            color: #fff;
            padding: 0.1px;
        }

        .type_title.package-draw.active {
            background-color: #277cea;
            color: #fff;
            padding: 0.1px;
        }

        .package_title.package-event.active {
	        border: 1px solid #4E5E6A;
        }

        .package_title.package-draw.active {
	        border: 1px solid #4E5E6A;
        }
        #tennis-calendar .cell {
            border: 1px solid #2c3e50;
        }
        #tennis-calendar .cell.active {
            background-color: #f1c40f;
        }
        #tennis-calendar .header, .time {
            font-weight: bold;
        }

        .custom-slot-list {
            position: relative;
        }
        .custom-slot-list #slot-container {
            position: relative;
        }

        .loader-container {
            display: none;
        }

        .loader-container img {
            margin-top: 100px;
        }

        .slots-loader {
            display: block;
            background: white;
            opacity: 0.8;
            position: absolute;
            z-index: 200;
            width: 100%;
            height: 100%;
            text-align: center;
        }


        @media only screen and (max-width: 600px) {
            #tennis-calendar .cell {
                font-size: 9px;
                flex: 0 0 16.66666667%;
                max-width: 16.66666667%;
            }

            .select-type-mobile {
                width: 100%;
                padding-right: 0;
            }
            .select-type-mobile select {
                width: 100%;
            }
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
                <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="package_box select-booking-type " booking-type-id="1">
                        <div class="responsive-image"><img class="responsive-image" alt="Golf" src="/images/reservacion.jpg"></div>
                            <div class="package_title booking package-event">
                            <div class="type_title package-event">
                                <div class="text-container">
									<p class="text_type">Directa</p>	
                                    {{-- <div class="package_btn ">
                                        <a class="btn btn-primary btn-lg btn-block btn_package_select package-event" >Seleccionar</a>
                                    </div> --}}
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                 @if(Session::get('selectedCategoryDraw') == 1)
                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3">      
                        <div class="package_box select-booking-type " booking-type-id="2">
                            <div class="responsive-image"><img class="responsive-image" alt="Golf" src="/images/sorteo.jpg"></div>
                                <div class="package_title package-draw">

                                    <div class="type_title package-draw">
                                        <div class="text-container">
                                            <p class="text_type">Sorteo</p>
                                            {{-- <div class="package_btn ">
                                                <a class="btn btn-primary btn-lg btn-block btn_package_select package-draw" >Seleccionar</a>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>              
                        </div>                                                                                   
                @endif
                @if(Session::get('selectedCategoryDraw') == 0)
                    <div class="col col-xs-12 col-sm-12 col-md-3 col-lg-3"></div>
                @endif
            
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
                <div class="col-md-12 form-group" style="padding-left: 0">
                    <div class="row" >
                        <div class="col-xs-12 col-md-6 select-type-mobile" id="package-type"></div>
                        <div class="col-xs-12 col-md-6 select-type-mobile" id="package-list"></div>
                    </div>
                    <div class="col-md-12" id="tennis-calendar"></div>
                    <input type ="hidden" id="selected-package-type" value="">
                </div>
                <div id="custom_slots_holder" data-booking-type="{{ Session::get('booking_type_id') }}"></div>
                <div class="row col-md-12">
                    <div class="alert alert-danger col-md-12 d-none" id="slot_error" style="margin-bottom: 50px;">
                        {{ __('app.time_slot_error') }}
                    </div>
                    <div class="alert alert-danger col-md-12 d-none" id="tennis_slot_error" style="margin-bottom: 50px;">
                        
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
        <input type="hidden" name="tennis_slot" id="tennis_slot" value=''>
        <input type="hidden" name="package-duration" id="package-duration" value=''>
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
            <div class="container" style="display:flex; justify-content: center">
                    <div id="package-list-mobile"></div>
                    <div class="text-center">
                        <button type="submit" class="navbar-btn btn btn-primary btn-lg ml-auto">
                            {!! __('pagination.next') !!}
                        </button>
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
        const bookingUserMaxDays = '{{ \App\Settings::query()->first()->bookingUser_maxDays }}';
		maxDate.setDate(today.getDate() + Number(bookingUserMaxDays)  );  //LA set maximum booking days on future
		$('#custom-event_date').datepicker({
            orientation: "auto right",
            autoclose: true,
            startDate: today,
			endDate: maxDate,
			
            format: 'dd-mm-yyyy',
            daysOfWeekDisabled: "{{ $disable_days_string }}",
            language: "{{ App::getLocale() }}"
        });

        $('body').on('click', '.select-booking-type', function() {
                const BASE_URL = $('meta[name="index"]').attr('content');
                let booking_type_id = $(this).attr('booking-type-id');
                const selectedCategory = '{{ Session::get('selectedCategory') }}';
                const selectedCategoryDraw = '{{ Session::get('selectedCategoryDraw') }}';
                $('#booking_type_error').addClass('d-none');
                $('#booking_type_id').remove();
                $('#booking_step_1-1').append('<input type="hidden" attr-1 name="booking_type_id" id="booking_type_id" value="'+booking_type_id+'">');

                if(selectedCategoryDraw == 0) {
                     $('#booking_step_1-1').append('<input type="hidden" attr-1 name="booking_type_id" id="booking_type_id" value="1">');
                     booking_type_id = 1;
                }


                $('.package_title').removeClass('active');
                $('.type_title').removeClass('active');
                $(this).find('.type_title').addClass('active');
                $(this).find('.package_title').addClass('active');

                {{-- $('.btn_package_select').text('{{ __("app.booking_package_btn_select") }}').removeClass('btn-danger').addClass('btn-primary');
                $(this).text('{{ __("app.booking_package_btn_selected") }}').removeClass('btn-primary').addClass('btn-danger'); --}}
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
                if(!booking_type) {
                    $('#booking_type_error').removeClass('d-none');
                    $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                    check = false;
                }
                if(check) {
                   e.submit(); 
                }
                return false
            });
    

    function setPackageType (id) {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
            $.ajax({
                type: 'GET',
                url: `${URL_CONCAT}/set-package-type`,
                data: { id : id  },
                beforeSend: function() {
                    $('#selected-package-type').val('');
                    $('#package-duration').val('');
                    $('#time-package-type').empty();
                },
                success: function(response) {
                    console.log('response', response);
                    $('#selected-package-type').val(JSON.stringify(response.data));
                    //$('#package-duration').val(response.package.duration);
                     //const html = `${response.data.length} minutos`;
                    //$('#time-package-type').html(html);
                },
            }); 
    }
    
    function handlePackageType () {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
        const id = document.getElementById("select-package-type").value;
        if(id !== '') {
            $.ajax({
                type: 'GET',
                url: `${URL_CONCAT}/set-package-type`,
                data: { id : id  },
                beforeSend: function() {
                    $('#selected-package-type').empty();
                    $('#tennis_slot').val('');
                    $('.btn-slot').removeClass('slot-draw-picked');
                    $('.loader-container').addClass('slots-loader');
                    $('#time-package-type').empty();
                    $('#package-duration').val('');
                },
                success: function(response) {
                    $('#selected-package-type').val(JSON.stringify(response.data));
                    $('.loader-container').removeClass('slots-loader');
                    const html = `${response.data.length} minutos`;
                    $('#time-package-type').html(html);
                    $('#package-duration').val(response.package.duration);
                },
            });
        }
        
    }

    function renderPackageType(data) {
			let html = '';
			data.forEach(element => {
				html +=`<option value="${element.id}">${element.title}</option>`;
			})
			return html;
		}

    function getPackageType(mobile = false) {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
        
                $.ajax({
                type: 'GET',
                url: `${URL_CONCAT}/get-package-type`,
                beforeSend: function() {
                    $('#package-type').empty();
                    $('.loader-container').addClass('slots-loader');
                    $('#time-package-type').empty();
                },
                success: function(response) {
                    let html = '';
                    html +=` <div style="font-weight: bold; margin-bottom: 5px" >Seleccione Tipo de Juego<div> 
                    <select name="package-type" id="select-package-type" onchange="handlePackageType()" style="padding: 10px 0px 10px 0px; background-color: transparent; border: 0; border-bottom: 1px solid grey; font-size: 16px; margin-bottom:10px" >
                                <option value="">Tipo de Juego</option>
							    ${renderPackageType(response.data)}	
						</select> <div id="time-package-type"></div> `;
                    $('#package-type').html(html);
                    const selectedPackageType = response.selectedPackageType;
                    if(selectedPackageType) {
                        const find = response.data.find(e => e.alias == selectedPackageType.alias);
                        if(find) {
                            $('#select-package-type').val(find.id);
                            $('#selected-package-type').val(JSON.stringify(find));
                            const html = `${find.length} minutos`;
                            $('#time-package-type').html(html);
                            $.ajax({
                            type: 'GET',
                            url: `${URL_CONCAT}/set-package-type`,
                            data: { id : find.id  },
                                beforeSend: function() {
                                    $('#package-duration').val('');
                                },
                                success: function(response) {
                                    console.log('response', response);
                                    $('#package-duration').val(response.package.duration);
                                }
                            });
                        }
                    }
                    $('.loader-container').removeClass('slots-loader');
                },
                complete: function () {
                    $('#slots_loader').addClass('d-none');
                }
            });
    }

    function getPackages() {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
        const packageId = '{{ Session::get('package_id') }}';
    
                $.ajax({
                type: 'GET',
                url: `${URL_CONCAT}/get-packages-by-category`,
                beforeSend: function() {
                    $('#package-list').empty();
                    $('#package-list-mobile').empty();
                    $('#selected-package-type').empty();
                    $('#tennis_slot').val('');
                    $('.btn-slot').removeClass('slot-draw-picked');
                    $('.loader-container').addClass('slots-loader');
                    $('#time-package-type').empty();
                    $('#package-duration').val('');
                },
                success: function(response) {
                   let html = '';
                    html +=` <div style="font-weight: bold; margin-bottom: 5px" >Seleccione el paquete preferido<div>  
                    <select name="package-list" id="select-package-list" onchange="onSelectPackage()" style="padding: 10px 0px 10px 0px; background-color: transparent; border: 0; border-bottom: 1px solid grey; font-size: 16px; margin-bottom:10px" >
                                <option value="">Paquete</option>
							    ${renderPackageType(response.data)}	
						</select>`;
                    $('#package-list').html(html);
                    let htmlMobile = '';
                    htmlMobile +=` <select name="select-package-list-mobile" id="select-package-list-mobile" onchange="onSelectPackage(true)" style="padding: 10px 0px 10px 0px; border: 0; border-bottom: 1px solid grey; font-size: 13px; background-color: white; margin-right: 50px" >
                                <option value="">Paquete</option>
							    ${renderPackageType(response.data)}	
						</select>
                         `;
                    $('#package-list-mobile').html(htmlMobile);

                    if(packageId !== null) {
                        $('#select-package-list-mobile').val(packageId);
                        $('#select-package-list').val(packageId);
                        const find = response.data.find(e => e.id == packageId);
                        if(find) {
                            $('#package-duration').val(find.duration);
                        }
                    }
                    $('.loader-container').removeClass('slots-loader');

                },
                complete: function () {
                    $('#slots_loader').addClass('d-none');
                }
            });
    }

    function onSelectPackage(mobile = false) {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
        const date = document.getElementById('custom-event_date').value;
        const package = document.getElementById(`${mobile ? 'select-package-list-mobile' : 'select-package-list'}`).value;
        const categoryType = '{{ Session::get('categoryType') }}';
        $('#select-package-list-mobile').val(package);
        $('#select-package-list').val(package);
        if(package !== '') {
            $.ajax({
                type: 'POST',
                url: URL_CONCAT + '/get_timing_slots',
                data: { 
                    event_date:date,
                    package: package
                    },
                beforeSend: function() {
                    $('#time-package-type').empty();
                    $('#slots_loader').removeClass('d-none');
                    $('#package-type').empty();
                    $('#selected-package-type').empty();
                    $('#tennis_slot').val('');
                    $('#time-package-type').empty();
                    $('#package-duration').val('');
                },
                success: function(response) {
                    $('#custom_slots_holder').html(response);
                    if(categoryType == 1) {
                        getPackageType();
                    }
                },
                complete: function () {
                    $('#slots_loader').addClass('d-none');
                }
            });
        }
    }

    function onSelectDraw() {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
        const categoryType = '{{ Session::get('categoryType') }}';
            const id = document.getElementById("select-draw").value;
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
                            package:null,
                        },
                            beforeSend: function() {
                                $('#slots_loader').removeClass('d-none');
                                $('#package-type').empty();
                                $('#selected-package-type').empty();
                                $('#time-package-type').empty();
                                $('#package-duration').val('');
                                $('#tennis_slot').val('');
                            },
                            success: function(response) {
                                $('#custom_slots_holder').html(response);
                                getPackages();
                                if(categoryType == 1) {
                                    getPackageType();
                                }
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
        const categoryType = '{{ Session::get('categoryType') }}';

        //prepare to send ajax request
        $.ajax({
            type: 'POST',
            url: URL_CONCAT + '/get_timing_slots',
            data: {
                event_date:selected_date,
                package: null
                },
            beforeSend: function() {
                $('#slots_loader').removeClass('d-none');
                $('#package-type').empty();
                $('#selected-package-type').empty();
                $('#time-package-type').empty();
                $('#package-duration').val('');
                $('#tennis_slot').val('');
            },
            success: function(response) {
                $('#custom_slots_holder').html(response);
                getPackages();
                if(categoryType == 1) {
                    getPackageType();
                }
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
                    $('#draw-list').html(response);
                },
                complete: function () {
                    $('#slots_loader').addClass('d-none');
                }
            });
    }

    function setBookingType() {
        var bookingType = document.getElementById("data-booking-type").value;
        $('.package_title').removeClass('active');
		$('.type_title').removeClass('active');
        if(bookingType == 1) {
            $('.package_title.package-event').addClass('active');
            $('.type_title.package-event').addClass('active');
        }
        if(bookingType == 2) {
           // $('.package-draw').removeClass('btn-primary').addClass('btn-danger');
            $('.package_title.package-draw').addClass('active');
            $('.type_title.package-draw').addClass('active');
        }
        
    }

    function initDraws() {
        const bookingType = document.getElementById("data-booking-type").value;
        if(bookingType == 2){
            getDraws();
        }
    }

    function getBtnSlotPosition (hour) {
            let count = 0;
            let position = 0;
            $('.btn-slot.available').each(function() {
                count = count + 1;
                 const currentHour = $(this).attr('data-slot-time');
                if(currentHour == hour) {
                    position = count;
                }
            });
        return position;
    }

    // Revisar disponibilidad de slots para seleccion automatica de casillas
    function checkAvailableButtonSlot(hours) {
        let exist = true;
            $('.btn-slot.disabled').each(function() {
                 const currentHour = $(this).attr('data-slot-disable-time');
                 const find = hours.find(e => e == currentHour);
                if(find) exist = false;  
            });
        return exist;
    }

    // Construccion de horas seleccionadas dependiendo del intervalo
    function buildSelectedHours(hour, cant, interval) {
        const array = [];
        if(cant === 0) {
           array.push(hour);
        } else {
            array.push(hour);
            for(i=0; i < cant; i++) {
                const position = i + 1;
                const newInterval = position * interval;
                const time = moment(hour, 'hh:mm A').add(newInterval, 'minutes').format('hh:mm A');
                array.push(time);
            }
        }
        return array;
    }

    const array = [];
    $('#custom_slots_holder').on('click', 'a.btn-slot', function() {
        var slot_time = $(this).attr('data-slot-time');
        var bookingType = document.getElementById("data-booking-type").value;
        let selectedPackageType = $("#selected-package-type").val();
        const categoryType = '{{ Session::get('categoryType') }}';
        const packageDuration = $('#package-duration').val();

        $('#tennis_slot_error').addClass('d-none').html('');
        $('.btn-slot').removeClass('slot-draw-picked');
        $('#tennis_slot').val('');
         if(categoryType == 1 && selectedPackageType === '' || selectedPackageType === 'null') {
             $('#tennis_slot_error').removeClass('d-none').html('{{ __('app.package_type_error') }}');
             $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
         }

         

         if(bookingType === "1" && categoryType == 1 && selectedPackageType) {
            selectedPackageType = JSON.parse(selectedPackageType);
            const tennisCondition = selectedPackageType.length / packageDuration;
            let slots = [];
            const btnsLength = $('.btn-slot.available').length;
            const slotPosition = getBtnSlotPosition(slot_time);
            const ButtonCondition = btnsLength - slotPosition; // 

            // console.log('tennisCondition ', tennisCondition);
            // console.log('btnsLength ', btnsLength);
            // console.log('slotPosition ', slotPosition);
            // console.log('ButtonCondition ', ButtonCondition);

            const availableSlotsCondition = tennisCondition === 1 ? 0 : tennisCondition - 1; // Calcular siempre la cantidad de slots disponibles una vez presionado el slot inicial
            
            if(ButtonCondition < availableSlotsCondition) {
                $('#tennis_slot_error').removeClass('d-none').html('{{ __('app.tennis_slot_error') }}');
                $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                $('#tennis_slot').val('');
            } else {
                const slotsToBuild = tennisCondition === 1 ? 0 : tennisCondition - 1;
                const newSlotSelectedHours =  buildSelectedHours(slot_time, slotsToBuild, packageDuration);
                //console.log('newSlotSelectedHours ', newSlotSelectedHours);
                if(newSlotSelectedHours.length === 1) {
                    $('.btn-slot.available').each(function() {
                    const currentHour = $(this).attr('data-slot-time');
                    const exist = newSlotSelectedHours.find(e => e === currentHour );
                        if (exist) $(this).addClass('slot-draw-picked');
                    });
                    $('#tennis_slot').val(JSON.stringify(newSlotSelectedHours));
                } else if (newSlotSelectedHours.length > 1 && checkAvailableButtonSlot(newSlotSelectedHours)) {
                    $('.btn-slot.available').each(function() {
                    const currentHour = $(this).attr('data-slot-time');
                    const exist = newSlotSelectedHours.find(e => e === currentHour );
                        if (exist) $(this).addClass('slot-draw-picked');
                    });
                    $('#tennis_slot').val(JSON.stringify(newSlotSelectedHours));
                } else {
                    $('#tennis_slot_error').removeClass('d-none').html('{{ __('app.tennis_slot_error') }}');
                    $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                    $('#tennis_slot').val('');
                }
                
            }
          
         }
        
        if(bookingType === "1" && categoryType == 0) {
            $('#custom_slots_holder').find('.btn-slot').removeClass('slot-picked');
            $('#booking_slot').remove();
            $('#custom_booking_step_2').append('<input type="hidden" name="booking_slot" id="booking_slot" value="'+slot_time+'">');
            $(this).addClass('slot-picked');
        }

        if(bookingType === "2" && categoryType == 0) {
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
        const tennisSlot = $('#tennis_slot').val();
        const categoryType = '{{ Session::get('categoryType') }}';

        if(categoryType == 1 && !tennisSlot) {
            $('#tennis_slot_error').removeClass('d-none').html('{{ __('app.tennis_slot_error') }}');
            $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
            check = false;
        }

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

        if(bookinType === "1" && categoryType == 0) {
            if(booking_slot === undefined) {
                $('#slot_error').removeClass('d-none');
                $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                check = false;
            }
        }

        if(bookinType === "2" && categoryType == 0) {
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
    
    function handleSelectReport() {
            moment.locale('es')
            const customMoment = moment('2020-06-24 19:08:18.536759').format('MMMM Do YYYY');
            console.log('customMoment ', customMoment);
			$('#tennis-calendar').empty();
			let html = `
				<div class="row header">
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell">Cancha 1</div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell">Cancha 2</div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell">Cancha 3</div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell">Cancha 4</div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell">Cancha 5</div>
                </div>
                <div class="row">
					<div class="col-sm-2 col-xs-2 col-md-2 cell time">6:00</div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
                </div>
                <div class="row">
					<div class="col-sm-2 col-xs-2 col-md-2 cell time">6:30</div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
                </div>
                <div class="row">
					<div class="col-sm-2 col-xs-2 col-md-2 cell time">7:00</div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
                </div>
                <div class="row">
					<div class="col-sm-2 col-xs-2 col-md-2 cell time">7:30</div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
                </div>
                <div class="row">
					<div class="col-sm-2 col-xs-2 col-md-2 cell time">8:00</div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
                </div>
                <div class="row">
					<div class="col-sm-2 col-xs-2 col-md-2 cell time">8:30</div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
                </div>
                <div class="row">
					<div class="col-sm-2 col-xs-2 col-md-2 cell time">9:00</div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
                </div>
                <div class="row">
					<div class="col-sm-2 col-xs-2 col-md-2 cell time">9:30</div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
                </div>
                <div class="row">
					<div class="col-sm-2 col-xs-2 col-md-2 cell time">10:00</div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell active"></div>
					<div class="col-sm-2 col-xs-2 col-md-2 cell"></div>
				</div>
			`;
			$('#tennis-calendar').html(html);
			
		}
    
    
    
    //handleSelectReport();

    setBookingType();
    initDraws();
    
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