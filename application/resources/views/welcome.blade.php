@extends('layouts.app', ['title' => __('app.welcome_page_title')])

@section('content')

<style>

.package_box {
  margin-bottom: 0px !important;
  cursor: pointer;
  box-shadow: 0 0.3em 0.88em rgba(0, 0, 0, 0.3);
  border-radius: 5px;
}

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

#packages-calendar {
	margin: 20px 0px 20px 0px;
}

#packages-calendar .cell {
	border: 1px solid #2c3e50;
}
#packages-calendar .cell.active {
	background-color: #27ae60;
}

#packages-calendar .cell.blocked {
	background-color: #e74c3c;
}

#packages-calendar .cell.expired {
	background-color: #7f8c8d;
}

#packages-calendar .cell.event {
	background-color: #f1c40f;
}

#packages-calendar .header, .time {
	font-weight: bold;
}

#packages-calendar .cell.header.active-header {
    border-top: 5px solid #3498db;
    border-left: 5px solid #3498db;
    border-right: 5px solid #3498db;
}

#packages-calendar .cell.body.active-body {
    border-left: 5px solid #3498db;
    border-right: 5px solid #3498db;
}

.custom-table {
    table-layout: fixed;
    border-collapse: collapse;
    width: 100%;
}

.custom-table tbody{
  display:block;
  overflow:auto;
  height:250px;
  width:100%;
}

.custom-table tbody::-webkit-scrollbar {
  display: none;
  overflow: hidden;
}

.custom-table thead {
    font-weight: bold;
}

.custom-table thead tr{
  display:block;
}

.custom-table th, .custom-table td {
  padding: 5px;
  width: 168px;
}

@media only screen and (max-width: 600px) {

    .custom-table th, .custom-table td {
        padding: 1px;
        width: 82px;
        font-size: 75%;
        text-align: center;
    }

    #packages-calendar .header .init-default {
        width: 108px;
    }

	//**#packages-calendar .cell {
		font-size: 9px;
		flex: 0 0 16.66666667%;
		max-width: 16.66666667%;
		padding-left: 5px;
		padding-right: 0px;
	} **/
}

</style>

<?php
	
	// require 'wsLibrary.php';
	require 'wsLibrary.php';
	
	function str_Normalize($data)
	{
		$aux = $data;
		$aux = str_replace("'","",$aux);	
		$aux = str_replace("\"","",$aux);	
		return $aux;
	}
	

	
	// //check if logged
	// if($user = Auth::user())
	// //if (!Auth::check())
	// {	
		// $todayBookings = date("d-m-Y");

		
		// $bookings_today = count(DB::table('bookings')->where('booking_date','=', $todayBookings)->where('user_id','=', Auth::user()->id)->get());
		// //$bookings_today = Auth::user()->bookings()->where('booking_date','=',($todayBookings));
		// $bookings_perday =  config('settings.bookingUserPerDay');
		
		// //echo $bookings_today . " vs " . $bookings_perday . " @ " . $todayBookings;

		// //check total bookings for current day already made
		// if ($bookings_today <= $bookings_perday)
		// {
			// //echo "OK";	
			// //echo $todayBookings;
		// }
		// else
		// {
			
			// echo "<center>MAX RESERVACIONES POR DIA EXCEDIDO</center>";	
			// //return view('custom.restricted');		
			
			// echo '<script>';
			// echo '			window.location.href = `custom/RestrictedUserBooking.php?type=custom&customText=MAX RESERVACIONES POR DIA EXCEDIDO`;';
		// //	echo '			window.location.href = `{{ url('login') }}`;';		
			// echo '			</script>';
			// exit;	
		// }
		// //			@if(count($session_players))
		// //				@foreach($session_players as $player)				
	// }


	//Force an schedule for bookings to users  LA 	
	$today = date("Y-m-d");
	date_default_timezone_set(env('LOCAL_TIMEZONE','America/Caracas'));
	//date_default_timezone_set('Asia/Kolkata');
	
	
	$StartTime = App\Settings::query()->first()->bookingUser_startTime;
	$EndTime = App\Settings::query()->first()->bookingUser_endTime;

	$datetime1 = new DateTime($today . ' ' . $StartTime);
	$datetime2 = new DateTime($today . ' ' . $EndTime);
	$curDateTime = new DateTime();


	if (($curDateTime > $datetime1) && ($curDateTime < $datetime2)) {
			//echo "EN HORARIO";	
	}else
	{
		echo "<center>FUERA HORARIO</center>";
		
		//return view('custom.restricted');		
		echo '<script>';
		echo 'window.location.href = `custom/RestrictedUserBooking.php?type=schedule&StartTime=' . $StartTime . '&EndTime=' . $EndTime .  '`;';
	//	echo '			window.location.href = `{{ url(index) }}`;';		
		echo '			</script>';
	//	exit;		
	}

	//include 'wsLibrary.php';

	//validate balance of group-
	$group_id = Auth::user()->group_id;
	$user_id = Auth::user()->id ;
	
	//logged but without group_id
	if (($user_id!='') && ($group_id ==''))
	{
		echo "Usuario invalido";
		echo "<a href='login'>Haga click para ingresar nuevamente</a>";

		echo '<script>';
		echo '			window.location.href = `custom/RestrictedUserBooking.php?type=custom&customText=Usuario invalido`;';	
		echo '			</script>';
		exit();		

		/*
		echo '<script>';
		echo '			window.location.href = `login`;';
	//	echo '			window.location.href = `{{ url('login') }}`;';		
		echo '			</script>';
*/
		
	}


	//echo "$group_id" . $group_id;
	if ($group_id !='')
	{
		$result = wsConsultaSaldo($group_id, $balance, $comments);
		$balance_date = date('Y-m-d H:i:s');
		
		
		//echo $result;
		//exit();
		
		// echo $webservice;
		// echo CONST_URI_WEB_SERVICE;
		// echo "***" . $result;
		// echo $comments;
		
		if (($result==-1) || ($result==-3))
		{
			$balance = Auth::user()->group->balance;
			$balance_date = Auth::user()->group->balance_date;
		}
		else
		{
			if (($result==-2))
			{
				$balance=0;

				//echo '$result' . $result . '**';
				
				// Auth::user()->group->balance = $balance;
				// Auth::user()->group->balance_date = $balance_date;
				// Auth::user()->group->update();
				
				
				
				// $servername = env('DB_HOST');
				// $username=  env('DB_USERNAME');
				// $password = env('DB_PASSWORD');
				// $database = env('DB_DATABASE');

			$connectionInfo = array( 
				"Database"=> $database,
				"UID"=> $username, 
				"PWD"=> $password
			);
            $connection = sqlsrv_connect($servername, $connectionInfo);
				
				// Check connection 
				if (!$connection) 
				{ 
					echo "Database connection failed."; 
				}			
				
				//update local database
				$query = "DELETE FROM groups WHERE id='" . $group_id . "'";	
				$qry_result = sqlsrv_query($connection,$query ) or die(sqlsrv_error($connection));

				$query = "INSERT INTO groups (id, balance,is_suspended, is_active, balance_date,created_at, updated_at) VALUES ('" . $group_id . "'," . $balance . ",0,1,NOW(),NOW(), NOW())";	
				
				//echo $query;

				$qry_result = sqlsrv_query($connection,$query ) or die(sqlsrv_error($connection));
			}
	}

		if ($result<=0) {
				//echo "SOLVENTE";	
		}else
		{
			echo "<center>PRESENTA SALDO <br>";
			echo "Monto: " . $balance;
			echo " @ ";
			echo $balance_date;
			echo "</center>";
				
			echo '<script>';
			echo '			window.location.href = `custom/RestrictedUserBooking.php?type=balance&balance=' . $balance . '&group_id=' . $group_id  .  '&balance_date=' . $balance_date . '`;';
		//	echo '			window.location.href = `{{ url('login') }}`;';		
			echo '			</script>';
			exit;		
		}		
	}
	
	//check blacklist
	
	//user is logged
	//echo "check blacklist";
	if($user = Auth::user())
	//if (!Auth::check())	
	//if ($user_id != '')
	{
		
		//echo "check blacklist";
		
		$doc_id = Auth::user()->doc_id ;
		// 0: ok , 1: en lista negra, -1: error
		
		//echo $doc_id ;
		
		
		
		$retval = wsConsultarBlackList($doc_id, $comments, $first_name, $last_name);
		  //echo $retval;
		 // exit();

		$first_name = str_Normalize($first_name);
		$last_name = str_Normalize($last_name);

			$connectionInfo = array( 
				"Database"=> $database,
				"UID"=> $username, 
				"PWD"=> $password
			);
            $connection = sqlsrv_connect($servername, $connectionInfo);
		
		if ($retval == 1 )
		{
			
			
			$blacklist = 1;
			$err_message = $err_message . "<br>Actualmente Sr/a " . $first_name . " " .  $last_name . " posee una condicion que le impide realizar reservas - " . $comments ;
			$has_errors = 1;
			
			
			
			//update local table
			$query = "DELETE FROM blacklists WHERE doc_id='" . $doc_id . "'";	
			$qry_result = sqlsrv_query($connection,$query ) or die(sqlsrv_error($connection));



			$query = "INSERT INTO blacklists (doc_id, comments, created_at, updated_at, first_name, last_name) VALUES ('" . $doc_id . "','" . $comments . "',NOW(), NOW(),'" . $first_name . "','" . $last_name . "')";	
			$qry_result = sqlsrv_query($connection,$query ) or die(sqlsrv_error($connection));
			echo "jjj";
		}
		else  if ($retval == 0 )
		{
			//update local table deleting records
			$query = "DELETE FROM blacklists WHERE doc_id='" . $doc_id . "'";	
			$qry_result = sqlsrv_query($connection,$query ) or die(sqlsrv_error($connection));
			
		}
		elseif ($retval == -1 )  //error WS
		{

			$queryBlackList = "SELECT * from blacklists where doc_id='" . $doc_id . "'";
		   
			$resultBlackList = sqlsrv_query($connection, $queryBlackList); 
			  
			if ($resultBlackList) 
			{ 
				$rowBlackListCount = sqlsrv_num_rows($resultBlackList); 
			   // printf("Number of row in the table : " . $row); 
				if ($rowBlackListCount>0) 
				{
					$blacklist=1;
					while($row = sqlsrv_fetch_array($resultBlackList)){
						$comments = $row['comments'];
					}
				}
				else
				{

				}
			}
			if ($blacklist==1)
			{
				$err_message = $err_message . "<br>Actualmente presenta una condicion que le impide realizar reservas - " . $comments;
				$has_errors = 1;
			}
			else
			{
				//$err_message = $err_message . "<br>Participantes - " . $cant;
			}
			sqlsrv_next_result($resultBlackList); 

			
		}
		
		// echo '$has_errors' . $has_errors;
		// exit();
		
		
		if ($has_errors==1)
		{
				//echo "<center>Registrado en Blacklist<br>";
				echo "<center>No es posible reservar<br>";
				echo $comments;
				echo "</center>";
				
				$comments = "Actualmente posee una condicion que le impide realizar reservaciones . <br><br>Dirijase al Club para mayor informacion";
				
				echo '<script>';
				echo '			window.location.href = `custom/RestrictedUserBooking.php?type=custom&customText=' . $comments . '`;';
			//	echo '			window.location.href = `{{ url('login') }}`;';		
				echo '			</script>';
				exit;		

		}
		
	}

?>

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.welcome_title') }}</h1>
            <p class="promo-desc text-center">
                {{ __('app.welcome_subtitle') }}
            </p>
        </div>
    </div>

    <form method="post" id="custom_booking_step_1" action="{{ Auth::user() ? route('postStep1') : route('register') }}">

        {{csrf_field()}}

        @if(!Auth::user())
            <input type="hidden" name="password" value="{{ $random_pass_string }}">
            <input type="hidden" name="password_confirmation" value="{{ $random_pass_string }}">
			
			

			<!-- Force to be logged to book  LA 			-->
			<script>
			window.location.href = `{{ url('login') }}`;
			</script>

        @else
		@endif

		<input type="hidden"  id="countdown" name="countdown" >

        <div class="container">
            <div class="content">
			<div class="col-md-12 text-center">
                
				<h6><a href="{{ $reglamento_link }}" target="_blank"> <i class="fas fa-briefcase fa-lg text-primary"></i>&nbsp;{{ $reglamento_label }}<br><br></a> </h6>
			</div>
			
			<?php
			/*
			<div class="row begin-countdown">
			  <div class="col-md-12 text-center">
				<progress value="180" max="180" id="pageBeginCountdown"></progress>
				<p> Tiempo restante <span id="pageBeginCountdownText">180 </span> segundos</p>
			  </div>
			</div>*/
			?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mx-lg-5">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                        </div>
                        
                        <br>
                        @if($errors->has('email'))
                            <div class="alert alert-danger">
                                {{ __('app.existing_email_error') }}
                            </div>
                        @endif
						
						
                        @if($errors->has('phone_number'))
                            <div class="alert alert-danger">
                                {{ __('app.existing_phone_error') }}
                            </div>
                        @endif
						
                    </div>
                </div>

                @if(!Auth::user())

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" autocomplete="off" class="form-control form-control-lg"
                                       name="first_name" id="first_name" placeholder="{{ __('app.first_name') }}">
                                <p id="first_name_error_holder" class="form-text text-danger d-none">
                                    {{ __('app.first_name_error') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" autocomplete="off" class="form-control form-control-lg"
                                       name="last_name" id="last_name" placeholder="{{ __('app.last_name') }}">
                                <p id="last_name_error_holder" class="form-text text-danger d-none">
                                    {{ __('app.last_name_error') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" autocomplete="off" class="form-control form-control-lg"
                                       name="phone_number" id="phone_number" placeholder="{{ __('app.phone_number') }}">
                                <p id="phone_number_error_holder" class="form-text text-danger d-none">
                                    {{ __('app.phone_error') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" autocomplete="off" class="form-control form-control-lg"
                                       name="email" id="email" placeholder="{{ __('app.email') }}">
                                <p id="email_error_holder" class="text-danger d-none">
                                    {{ __('app.email_error') }}
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" autocomplete="off" class="form-control form-control-lg"
                                       name="doc_id" id="doc_id" placeholder="{{ __('app.doc_id') }}">
                                <p id="doc_id_error_holder" class="text-danger d-none">
                                    {{ __('app.doc_id_error') }}
                                </p>
                            </div>
                        </div>					
					
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" autocomplete="off" class="form-control form-control-lg"
                                       name="group_id" id="group_id" placeholder="{{ __('app.group_id') }}">
                                <p id="group_id_error_holder" class="form-text text-danger d-none">
                                    {{ __('app.group_id_error') }}
                                </p>
                            </div>
                        </div>

                    </div>

                @else
						<div class="col-md-12 form-group"> 
                                <div class="row">
                                    <div class="col-md-12 form-group btn-primary"> 
                                        <div class="row" style="padding: 10px;">
                                            <div class="col-md-6 " style="text-align: left; font-weigth: bold; line-height: 2; font-size: 1.125rem;"> {{ __('app.personal_details') }} </div>
                                            <div class="col-md-6 collapse-href" style="text-align: right;"> 
                                                <a class="collapsed" data-toggle="collapse" href="#participantsCollapse" role="button" aria-expanded="false" aria-controls="participantsCollapse">
                                                    <i class="fa fa-angle-down" style="margin-left: 5px"></i>
                                                </a>
                                            </div>
										</div>
                                    </div>
                                    <div class="col-md-12 collapse" id="participantsCollapse"> 
                                        <div class="row" id="extra-service-participants">

										<div class="col-md-6">
											<div class="form-group">
												<input type="text" value="{{ Auth::user()->first_name }}" readonly disabled=""
													autocomplete="off" class="form-control form-control-lg"
													name="first_name" id="first_name" placeholder="{{ __('app.first_name') }}">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" autocomplete="off" value="{{ Auth::user()->last_name }}"
														readonly disabled="" class="form-control form-control-lg"
														name="last_name" id="last_name" placeholder="{{ __('app.last_name') }}">
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<input type="text" autocomplete="off" value="{{ Auth::user()->phone_number }}"
													readonly disabled="" class="form-control form-control-lg"
													name="phone_numberNOTVALID" id="phone_numberNOTVALID" placeholder="{{ __('app.phone_number') }}">
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<input type="email" autocomplete="off" value="{{ Auth::user()->email }}"
													readonly disabled="" class="form-control form-control-lg"
													name="email" id="email" placeholder="{{ __('app.email') }}">
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<input type="text" autocomplete="off" value="{{ Auth::user()->doc_id }}"
														readonly disabled="" class="form-control form-control-lg"
														name="doc_id" id="doc_id" placeholder="{{ __('app.doc_id') }}">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" autocomplete="off" value="{{ Auth::user()->group_id }}"
														readonly disabled="" class="form-control form-control-lg"
														name="group_id" id="group_id" placeholder="{{ __('app.group_id') }}">
											</div>
										</div>

										</div>
                                    </div>
                                </div>
                            </div>			

                @endif

                <div id="categories_holder">
                    <br>
                    <div class="row"><div class="col-md-12"><h5>{{ __('app.booking_category') }}</h5></div></div>
                    <br>
                    <div class="row">
                        @if(count($categories))
                            @foreach($categories as $category)
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                    <div class="type_box custom_category_box" data-category-type="{{ $category->category_type }}" data-category-id="{{ $category->id }}">
                                        <div class="responsive-image"><img class="responsive-image" alt="{{ $category->title }}" src="{{ asset($category->photo->file) }}"></div>
                                        <div class="type_title">
                                            <div class="text-container">
                                                <p class="text_type">{{ $category->title }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <div class="alert alert-danger">{{ __('app.no_category_error') }}</div>
                            </div>
                        @endif
                    </div>
                    <br>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="packages_loader" class="d-none"><p style="text-align: center;"><img src="{{ asset('images/loader.gif') }}" width="52" height="52"></p></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" id="packages-by-type"></div>
                </div>
                <div id="packages_holder"></div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger d-none" id="package_error">{{ __('app.no_package_selected_error') }}</div>
                        <div class="alert alert-danger d-none" id="welcome-message-error"></div>
                        <div class="alert alert-danger d-none" id="welcome-custom-message-error"></div>
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
			$('.package_title.container').removeClass('active');
			$('.type_title.pack').removeClass('active');
        	$(this).find('.type_title.pack').addClass('active');
            $('.btn_package_select').text('{{ __("app.booking_package_btn_select") }}').removeClass('btn-danger').addClass('btn-primary');
            $(this).text('{{ __("app.booking_package_btn_selected") }}').removeClass('btn-primary').addClass('btn-danger');
        });
    </script>

{{ Session::get('timeout') }}


	<script>
		// ProgressCountdown(180, 'pageBeginCountdown', 'pageBeginCountdownText').then(value => window.location.href = `logoutBooking`);


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

        function handlePackageCalendar(id) {
            $(`.cell`).removeClass('active-header');
            $(`.cell`).removeClass('active-body');
            $('.package_title.container').removeClass('active');
            $('.type_title.pack').removeClass('active');
            $(`.cell.header.calendar-package-${id}`).addClass('active-header');
            $(`.cell.body.calendar-package-${id}`).addClass('active-body');
            $(`.custom-data-package-${id}`).find('.type_title.pack').addClass('active');
            $(`.custom-data-package-${id}`).find('.package_title.container').addClass('active');

            $('#package_id').remove();
            $('#custom_booking_step_1').append(`<input type="hidden" name="package_id" id="package_id" value="${id}">`);
        }

        function renderCalendarHeader(packages) {
            let html = '';
			packages.forEach(element => {
				html +=`<td class="cell header calendar-package-${element.id}" onclick="handlePackageCalendar(${element.id})" style="cursor:pointer;" >${element.title}</td>`;
			})
            return html;
        }

        function renderStatus(data) {
            if(data.expired) return 'expired';
            if(data.blocked) return 'blocked';
            if(data.event) return 'event';
            if(!data.available) return 'active';
        }

        function renderSchedule(data) {
            let html = '';
			data.forEach(element => {
				html +=`<td class="cell ${renderStatus(element)} body calendar-package-${element.id}" calendar-package="${element.id}" >&nbsp;</td>`;
			});
            return html;
        }

		function handleSelectDay(category) {
            let date = document.getElementById("tennis-time").value;
			var URL_CONCAT = $('meta[name="index"]').attr('content');
            const packageId  = $('#package_id').val();
            if(date !== '') {
                let number = moment(date).weekday();
                if(number == 0) number = number + 1;
                $.ajax({
                type: 'GET',
                url: URL_CONCAT + '/booking-category-calendar',
                data: { 
                    date : moment(date).format('DD-MM-YYYY'),
                    number : number,
                    category : category,
                },
                    beforeSend: function() {
                        $('#packages_loader').removeClass('d-none');
                    },
                    success: function(response) {
                        const packages = response.packages;
                        const schedule = response.schedule;
                        const count = packages.length + 1;
                        const widthColumn =  100 / count;
                        let html = '';
                        const header = `
                            <tr class="header">
                                <td class="cell" ></td>
                                ${renderCalendarHeader(packages)}
                            </tr>`;

                        let content = '';
                        
                        schedule.forEach(element => {
                            content += `
                                <tr>
                                    <td class="cell time" >${moment(element.hour, 'hh:mm A').format('hh:mm A')}</td>
                                    ${renderSchedule(element.packages)}
                                </tr>
                            `;
                        } );

                        html += `
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 col-md-12">
                                <table class="custom-table" >
                                    <thead>${header}</thead>
                                    <tbody>${content}  </tbody>
                                </table>   
                            </div>
                        </div>
                        `;
                        $('#packages-calendar').fadeIn().html(html);
                        $('#packages_loader').addClass('d-none');
                    },
                });
            }
			
		}

		function renderDates(dates) {
			let html = '';
            html +=`<option value="" selected >Seleccione Dia</option>`;
			dates.forEach(element => {
                html +=`<option value="${element.date.date}">${moment(element.date.date).format('DD-MM-YYYY')}</option>`;
			})
			return html;
		}

	$("div").on("click", "div.custom_category_box", function(){
        var category_id = $(this).attr('data-category-id');
        var category_type = $(this).attr('data-category-type');
        $('.type_title').removeClass('active');
        $(this).find('.type_title').addClass('active');
        var URL_CONCAT = $('meta[name="index"]').attr('content');
		if(category_type == 0) {
			$.ajax({
            type: 'POST',
            url: URL_CONCAT + '/get_packages',
            data: {parent:category_id},
            beforeSend: function() {
                $('#package_id').val('');
                $('#packages_loader').removeClass('d-none');
				$('#packages-by-type').empty();
				$('#packages-calendar').empty();
                $('#statusSlots').empty();
                $('#packages_holder').empty();
                $('#welcome-custom-message-error').addClass('d-none').empty();;
                $('#welcome-message-error').addClass('d-none').empty();
            },
            success: function(response) {
                if(typeof response === 'object') {
                    $('#welcome-custom-message-error').removeClass('d-none').html(response.message);
                    $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                    $('#package_id').val('');
                } else {
                    $('#packages_holder').fadeIn().html(response);
                    $(".owl-carousel").owlCarousel({
                        margin:20,
                        dots:false,
                        nav:true,
                        items: 1,
                        navText: [
                            '<img src="'+ URL_CONCAT + '/images/left.png">',
                            '<img src="'+ URL_CONCAT + '/images/right.png">'
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
                }
            },
            complete: function () {
                $('#packages_loader').addClass('d-none');
            }
        });
		}

		if(category_type == 1) {
			$.ajax({
            type: 'GET',
            url: URL_CONCAT + '/get-packages-by-type',
            data: {id:category_id},
            beforeSend: function() {
                $('#package_id').val('');
                $('#packages_loader').removeClass('d-none');
				$('#packages_holder').empty();
                $('#packages-by-type').empty();
                $('#statusSlots').empty();
                $('#packages-calendar').empty();
                $('#welcome-custom-message-error').addClass('d-none').empty();;
                $('#welcome-message-error').addClass('d-none').empty();
            },
            success: function(response) {

                if(response.success) {

                    let html = '';
                    html += `
                    <div class="row" >
                        <div class="col-md-12 form-group btn-primary"> 
                            <div class="row" style="padding: 10px;">
                                <div class="col-md-6 " style="text-align: left; font-weigth: bold; line-height: 2; font-size: 1.125rem;"> Ocupacion General </div>
                                <div class="col-md-6 collapse-href" style="text-align: right;"> 
                                    <a class="collapsed" data-toggle="collapse" href="#calendarCollapse" role="button" aria-expanded="false" aria-controls="calendarCollapse">
                                        <i class="fa fa-angle-down" style="margin-left: 5px"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 collapse" id="calendarCollapse">
                            <div class="row">
                            
                                <div class="col-md-12 form-group">
                                    <select class="form-control" name="tennis-time" id="tennis-time" onchange="handleSelectDay(${category_id})">
                                    ${renderDates(response.dates)}	
                                </select>
                                </div>
                            
                            <div class="col-md-12 form-group">
                                <div class="row">           
                                    <div class="col-md-2">
                                    <a class="btn btn-outline-dark btn-lg btn-block btn-slot disabled"> DISPONIBLE</a>
                                    </div>
                                    
                                    <div class="col-md-2">
                                    <a class="btn   btn-lg btn-block  btn-slot btn-warning disabled">EVENTO</a>
                                    </div>
                                    
                                    <div class="col-md-2">
                                    <a class="btn   btn-lg btn-block  btn-slot btn-secondary disabled"><font color="FFFFFF"> EXPIRADO</font></a>
                                    </div>
                                    
                                    <div class="col-md-2">
                                    <a class="btn   btn-lg btn-block  btn-slot btn-success disabled"><font color="FFFFFF"> RESERVADO</font></a>
                                    </div>

                                    <div class="col-md-2">
                                    <a class="btn   btn-lg btn-block  btn-slot btn-danger disabled"><font color="FFFFFF"> EN PROCESO </font></a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12" id="packages-calendar" style="text-align:center"></div>

                            </div>
                        </div>
                    </div>
                    `;
                    //$('#packages-by-type').fadeIn().html(html);

                    $.ajax({
                    type: 'POST',
                    url: URL_CONCAT + '/get_packages',
                    data: {parent:category_id},
                    beforeSend: function() {
                        $('#packages_loader').removeClass('d-none');
                        $('#packages_holder').empty();
                            $('#package_id').remove();
                    },
                    success: function(response) {
                        $('#packages_holder').fadeIn().html(response);
                        $(".owl-carousel").owlCarousel({
                            margin:20,
                            dots:false,
                            nav:true,
                            items: 1,
                            navText: [
                                '<img src="'+ URL_CONCAT + '/images/left.png">',
                                '<img src="'+ URL_CONCAT + '/images/right.png">'
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
                                    items: 3
                                }
                            }
                    });
                    $('#packages_loader').removeClass('d-none');
                    },
                    complete: function () {
                        $('#packages_loader').addClass('d-none');
                    }
                    });

                } else {
                    $('#welcome-custom-message-error').removeClass('d-none').html(response.message);
                    $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                    $('#package_id').val('');
                }

            	},
				complete: function () {
					$('#packages_loader').addClass('d-none');
				}
				});
		}
    });

    $('body').on('click', 'div.package_box', function() {
        var package_id = $(this).attr('custom-data-package-id');
		$('.package_title.container').removeClass('active');
		$('.type_title.pack').removeClass('active');
        $(`.cell`).removeClass('active-header');
        $(`.cell`).removeClass('active-body');
		$(this).find('.type_title.pack').addClass('active');
		$(this).find('.package_title.container').addClass('active');
        $('#package_error').addClass('d-none');

        $(`.cell.header.calendar-package-${package_id}`).addClass('active-header');
        $(`.cell.body.calendar-package-${package_id}`).addClass('active-body');

        $('#package_id').remove();
        $('#custom_booking_step_1').append('<input type="hidden" name="package_id" id="package_id" value="'+package_id+'">');
    });

	function checkPackageParameters() {
		const URL_CONCAT = $('meta[name="index"]').attr('content');
		const package_id  = $('input[name=package_id]').val();
		return new Promise(function(resolve, reject) {
			$.ajax({
			type: 'GET',
			url: `${URL_CONCAT}/check-user-package-parameters`,
			data: { package_id: package_id },
				success: function(response) {
					resolve(response);
					return false;
				},
			})
		});
	}

    $('#custom_booking_step_1').submit(async function(e){
		e.preventDefault();
        var check;
        check = true;
        var first_name;
        first_name = $('input[name=first_name]').val();
        var last_name;
        last_name = $('input[name=last_name]').val();
        var phone_number;
        phone_number = $('input[name=phone_number]').val();
        var email;
        email = $('input[name=email]').val();
		$('#welcome-message-error').addClass('d-none').empty();

        if(first_name === "") {
            $('#first_name').addClass('is-invalid');
            $('#first_name_error_holder').removeClass('d-none');
            check = false;
        }

        if(last_name === "") {
            $('#last_name').addClass('is-invalid');
            $('#last_name_error_holder').removeClass('d-none');
            check = false;
        }

        if(phone_number === "") {
            $('#phone_number').addClass('is-invalid');
            $('#phone_number_error_holder').removeClass('d-none');
            check = false;
        }

        if(email === "") {
            $('#email').addClass('is-invalid');
            $('#email_error_holder').removeClass('d-none');
            check = false;
        }

        var emailReg = /^([\w-.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if(!emailReg.test(email)) {
            $('#email').addClass('is-invalid');
            $('#email_error_holder').removeClass('d-none');
            check = false;
        }

        if(check === false) {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        }

        var package_id  = $('input[name=package_id]').val();
		
        if(package_id === undefined) {
            $('#package_error').removeClass('d-none');
            $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
            check = false;
        }

		const res = await checkPackageParameters();
        if(res.success) {
            $('#welcome-message-error').removeClass('d-none').html(res.message);           
            check = false;
        }
        if(check === false) {
            return false;
        }
		var enviar = document.getElementById("custom_booking_step_1");
		enviar.submit();
    });
 


	</script>


@endsection