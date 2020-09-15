@extends('layouts.app', ['title' => __('app.step_two_page_title')])

@section('styles')

    <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datepicker.min.css') }}">

@endsection

@section('content')

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.step_two_page_title') }}</h1>
            <p class="promo-desc text-center">{{ __('app.step_two_subtitle') }}</p>
        </div>
    </div>

    <form method="post" id="booking_step_2" action="{{ route('postStep2') }}">
        {{ csrf_field() }}
        <div class="container">
            <div class="content">
			
			<div class="row begin-countdown">
			  <div class="col-md-12 text-center">
				<progress value="180" max="180" id="pageBeginCountdown"></progress>
				<p> Tiempo restante <span id="pageBeginCountdownText">180 </span> segundos</p>
			  </div>
			</div>
			
                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mx-lg-5">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">50%</div>
                        </div>
                    </div>
                </div>
                <br><br>






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
                            <input type="text" class="form-control form-control-lg" name="event_date"
                                   id="event_date" placeholder="{{ __('app.date_placeholder') }}" autocomplete="off">
                            <p class="form-text text-danger d-none" id="date_error_holder">
                                {{ __('app.date_error') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <br><br>
                            <h5>{{ __('app.add_instructions') }}</h5>
                            <br>
                            <textarea class="form-control" name="instructions" rows="7" placeholder="{{ __('app.add_instructions_placeholder') }}"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="slots_loader" class="d-none"><p style="text-align: center;"><img src="{{ asset('images/loader.gif') }}" width="52" height="52"></p></div>
                    </div>
                </div>

                <br>

                <div id="slots_holder"></div>

                <div class="row col-md-12">
                    <div class="alert alert-danger col-md-12 d-none" id="slot_error" style="margin-bottom: 50px;">
                        {{ __('app.time_slot_error') }}
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
		maxDate.setDate(today.getDate()+  {{ config('settings.bookingUser_maxDays') }} );  //LA set maximum booking days on future
		$('#event_date').datepicker({
            orientation: "auto right",
            autoclose: true,
            startDate: today,
			endDate: maxDate,
			
            format: 'dd-mm-yyyy',
            daysOfWeekDisabled: "{{ $disable_days_string }}",
            language: "{{ App::getLocale() }}"
        });
    </script>


    @if(config('settings.google_maps_api_key') != NULL)
        <script src="{{ asset('js/map.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.google_maps_api_key') }}&libraries=places&callback=initAutocomplete" async defer></script>
    @endif
	

<script>

//ProgressCountdown(10, 'pageBeginCountdown', 'pageBeginCountdownText').then(value => alert(`Tiempo expirado: ${value}.`));


//ProgressCountdown(10, 'pageBeginCountdown', 'pageBeginCountdownText').then(value => window.location.href = `http://stackoverflow.com`);

//ProgressCountdown(10, 'pageBeginCountdown', 'pageBeginCountdownText').then(value => window.location.href = `{{ url('logout') }}`);
ProgressCountdown(180, 'pageBeginCountdown', 'pageBeginCountdownText').then(value => window.location.href = `logoutBooking`);


function ProgressCountdown(timeleft, bar, text) {
  return new Promise((resolve, reject) => {
    var countdownTimer = setInterval(() => {
      timeleft--;

      document.getElementById(bar).value = timeleft;
      document.getElementById(text).textContent = timeleft;

      if (timeleft <= 0) {
        clearInterval(countdownTimer);
        resolve(true);
      }
    }, 1000);
  });
}
</script>

@endsection