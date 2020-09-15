@extends('layouts.admin', ['title' => __('backend.update_booking')])


@section('styles')

    <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datepicker.min.css') }}">

@endsection

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.update_booking') }} # {{ $booking->id }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('bookings.index') }}">{{ __('backend.bookings') }}</a></li>
                <li class="active">{{ __('backend.update_booking') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.change_booking_time') }}</h4>
                    </div>
                    <div class="panel-body">
                        <br>
                        <form method="post" id="update_booking_time" action="{{ route('updateBookingTime', $booking->id) }}">

                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            <div class="alert alert-info">
                                {{ __('backend.current_booking_time', ['date' => $booking->booking_date, 'time' => $booking->booking_time]) }}
                            </div>

                            <input type="hidden" name="booking_id" id="booking_id" value="{{ $booking->id }}">

                            <div class="form-group">
                                <label><strong>{{ __('app.select_date') }}</strong></label>
                                <input type="text" class="form-control" name="event_date_bk"
                                       id="event_date_bk" placeholder="{{ __('app.date_placeholder') }}">
                                <p class="text-danger hidden" id="date_error_holder_bk">
                                    {{ __('app.date_error') }}
                                </p>
                            </div>

                            <div class="col-md-12">
                                <div id="slots_loader" class="hidden"><p style="text-align: center;"><img src="{{ asset('images/loader.gif') }}" width="52" height="52"></p></div>
                            </div>

                            <div class="col-md-12">
                                <div id="slots_holder"></div>
                            </div>

                            <div class="alert alert-danger col-md-12 hidden" id="slot_error">
                                {{ __('app.time_slot_error') }}
                            </div>

							
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('backend.change_booking_time') }}</button>
                            </div>

							
							
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        $('#event_date_bk').datepicker({
            autoclose: true,
            orientation : 'bottom left',
            startDate: today,
            format: 'dd-mm-yyyy',
            daysOfWeekDisabled: "{{ $disable_days_string }}",
            language: "{{ App::getLocale() }}"
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('input[id="event_date_bk"]').change(function () {
            //populate timing slots
            var selected_date;
            var booking_id;
            selected_date = $(this).val();
            booking_id = $('input[id="booking_id"]').val();

            //prepare to send ajax request
            $.ajax({
                type: 'POST',
                url: '{{ route('index') }}/get_update_slots',
                data: {event_date:selected_date , booking:booking_id},
                beforeSend: function() {
                    $('#slots_loader').removeClass('hidden');
                },
                success: function(response) {
                    $('#slots_holder').html(response);
                },
                complete: function () {
                    $('#slots_loader').addClass('hidden');
                }
            });
        });

        $('#slots_holder').on('click', 'a.btn-slot', function() {
            var slot_time = $(this).attr('data-slot-time');
            $('#slots_holder').find('.btn-slot').removeClass('btn-info').addClass('btn-default');
            $('#booking_slot').remove();
            $('#update_booking_time').append('<input type="hidden" name="booking_slot" id="booking_slot" value="'+slot_time+'">');
            $(this).removeClass('btn-default').addClass('btn-info');
        });


        $('#update_booking_time').submit(function(e){

            var check = true;
            var event_date;
            event_date = $('input[name=event_date_bk]').val();
            var booking_slot;
            booking_slot = $('input[name=booking_slot]').val();

            if(event_date === "")
            {
                $('#date_error_holder_bk').removeClass('hidden');
                check = false;
            }

            if(check === false)
            {
                return false;
            }
            else if(check === true)
            {
                if(booking_slot === undefined)
                {
                    $('#slot_error').removeClass('hidden');
                    return false;
                }
                else
                {
                    e.submit();
                }
            }
        });

    </script>



@endsection