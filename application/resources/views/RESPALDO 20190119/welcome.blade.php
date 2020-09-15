@extends('layouts.app', ['title' => __('app.welcome_page_title')])

@section('content')



<?php
	
	// require 'wsLibrary.php';
	include 'wsLibrary.php';
	
	function str_Normalize($data)
	{
		$aux = $data;
		$aux = str_replace("'","",$aux);	
		$aux = str_replace("\"","",$aux);	
		return $aux;
	}
	

	
	//check if logged
	if($user = Auth::user())
	//if (!Auth::check())
	{	
		$todayBookings = date("d-m-Y");

		
		$bookings_today = count(DB::table('bookings')->where('booking_date','=', $todayBookings)->where('user_id','=', Auth::user()->id)->get());
		//$bookings_today = Auth::user()->bookings()->where('booking_date','=',($todayBookings));
		$bookings_perday =  config('settings.bookingUserPerDay');
		
		//echo $bookings_today . " vs " . $bookings_perday . " @ " . $todayBookings;

		//check total bookings for current day already made
		if ($bookings_today <= $bookings_perday)
		{
			//echo "OK";	
			//echo $todayBookings;
		}
		else
		{
			
			echo "<center>MAX RESERVACIONES POR DIA EXCEDIDO</center>";	
			//return view('custom.restricted');		
			
			echo '<script>';
			echo '			window.location.href = `custom/RestrictedUserBooking.php?type=custom&customText=MAX RESERVACIONES POR DIA EXCEDIDO`;';
		//	echo '			window.location.href = `{{ url('login') }}`;';		
			echo '			</script>';
			exit;	
		}
		//			@if(count($session_players))
		//				@foreach($session_players as $player)				
	}


	//Force an schedule for bookings to users  LA 	
	$today = date("Y-m-d");
	date_default_timezone_set(env('LOCAL_TIMEZONE','America/Caracas'));
	//date_default_timezone_set('Asia/Kolkata');
	
	
	$StartTime = config('settings.bookingUser_startTime');
	$EndTime = config('settings.bookingUser_endTime');

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
				
				$connection = mysqli_connect( $servername, $username, $password,$database); 
				  
				// Check connection 
				if (mysqli_connect_errno()) 
				{ 
					echo "Database connection failed."; 
				}			
				
				//update local database
				$query = "DELETE FROM groups WHERE id='" . $group_id . "'";	
				$qry_result = mysqli_query($connection,$query ) or die(mysqli_error($connection));

				$query = "INSERT INTO groups (id, balance,is_suspended, is_active, balance_date,created_at, updated_at) VALUES ('" . $group_id . "'," . $balance . ",0,1,NOW(),NOW(), NOW())";	
				
				//echo $query;

				$qry_result = mysqli_query($connection,$query ) or die(mysqli_error($connection));
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
		
		$connection = mysqli_connect( $servername, $username, $password,$database); 
		
		if ($retval == 1 )
		{
			
			
			$blacklist = 1;
			$err_message = $err_message . "<br>En Lista Negra " . $first_name . " " .  $last_name . " - " . $comments ;
			$has_errors = 1;
			
			
			
			//update local table
			$query = "DELETE FROM blacklists WHERE doc_id='" . $doc_id . "'";	
			$qry_result = mysqli_query($connection,$query ) or die(mysqli_error($connection));



			$query = "INSERT INTO blacklists (doc_id, comments, created_at, updated_at, first_name, last_name) VALUES ('" . $doc_id . "','" . $comments . "',NOW(), NOW(),'" . $first_name . "','" . $last_name . "')";	
			$qry_result = mysqli_query($connection,$query ) or die(mysqli_error($connection));
			echo "jjj";
		}
		else  if ($retval == 0 )
		{
			//update local table deleting records
			$query = "DELETE FROM blacklists WHERE doc_id='" . $doc_id . "'";	
			$qry_result = mysqli_query($connection,$query ) or die(mysqli_error($connection));
			
		}
		elseif ($retval == -1 )  //error WS
		{

			$queryBlackList = "SELECT * from blacklists where doc_id='" . $doc_id . "'";
		   
			$resultBlackList = mysqli_query($connection, $queryBlackList); 
			  
			if ($resultBlackList) 
			{ 
				$rowBlackListCount = mysqli_num_rows($resultBlackList); 
			   // printf("Number of row in the table : " . $row); 
				if ($rowBlackListCount>0) 
				{
					$blacklist=1;
					while($row = mysqli_fetch_array($resultBlackList)){
						$comments = $row['comments'];
					}
				}
				else
				{

				}
			}
			if ($blacklist==1)
			{
				$err_message = $err_message . "<br>En Lista Negra - " . $comments;
				$has_errors = 1;
			}
			else
			{
				//$err_message = $err_message . "<br>Participantes - " . $cant;
			}
			@mysqli_free_result($resultBlackList); 

			
		}
		
		// echo '$has_errors' . $has_errors;
		// exit();
		
		
		if ($has_errors==1)
		{
				echo "<center>Registrado en Blacklist<br>";
				echo $comments;
				echo "</center>";
				
				$comments = "En Lista Negra. <br><br>Dirijase al Club para mayor informacion";
				
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

    <form method="post" id="booking_step_1" action="{{ Auth::user() ? route('postStep1') : route('register') }}">

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



        <div class="container">
            <div class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mx-lg-5">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                        </div>
                        <br><br>
                        <h5>{{ __('app.personal_details') }}</h5>
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

                    <div class="row">
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
                    </div>

                    <div class="row">
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
                    </div>
						
                    <div class="row">
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

                @endif

                <div id="categories_holder">
                    <br>
                    <div class="row"><div class="col-md-12"><h5>{{ __('app.booking_category') }}</h5></div></div>
                    <br>
                    <div class="row">
                        @if(count($categories))
                            @foreach($categories as $category)
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                                    <div class="type_box category_box" data-category-id="{{ $category->id }}">
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

                <div id="packages_holder"></div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger d-none" id="package_error">{{ __('app.no_package_selected_error') }}</div>
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
            $('.btn_package_select').text('{{ __("app.booking_package_btn_select") }}').removeClass('btn-danger').addClass('btn-primary');
            $(this).text('{{ __("app.booking_package_btn_selected") }}').removeClass('btn-primary').addClass('btn-danger');
        });
    </script>

{{ Session::get('timeout') }}

@endsection