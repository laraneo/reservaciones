	<?php
			require 'config.inc';
		
			$connectionInfo = array( 
				"Database"=> $database,
				"UID"=> $username, 
				"PWD"=> $password
				);
			$connection = sqlsrv_connect($servername, $connectionInfo); 

			// Check connection 
			if (!$connection) 
			{ 
				$has_errors = 1;	
				$err_message =  $err_message . "<br>Database connection failed."; 
				exit(); //die();
			}

			 $queryCountDown = "SELECT  (DATEDIFF(SECOND, GETDATE(), expiration_date)) as countdown from session_slots where session_email='" .  Auth::user()->email  .  "' and booking_date='" .  Session::get('event_date')  . "' AND booking_time='" .  Session::get('booking_slot')  . "'"  ;
			 
			
			
//echo $queryCountDown;
//die();

			$countdown= config('settings.bookingTimeout')*60 ;

			$resultqueryCountDown = sqlsrv_query($connection, $queryCountDown); 
			 
			 if( $resultqueryCountDown === false) {
				die( print_r( sqlsrv_errors(), true) );
			}

			while( $row = sqlsrv_fetch_array( $resultqueryCountDown, SQLSRV_FETCH_ASSOC) ) {
				  //echo $row['opening_time']."<br />";
				  $countdown = $row['countdown'];
			}

			sqlsrv_free_stmt( $resultqueryCountDown);

//echo $countdown;
//die();

			 
			 
			 
			 /*
			if ($resultqueryCountDown) 
			{ 
				$rowGroupCount = sqlsrv_num_rows($resultqueryCountDown); 
			    //printf("Number of row in the table : " . $rowGroupCount); 
				if ($rowGroupCount>0) 
				{
					while($row = sqlsrv_fetch_array($resultqueryCountDown)){
						$countdown = $row['countdown'];
					}
				}
				else
				{
					$countdown= config('settings.bookingTimeout')*60 ;
				}
			}	
			*/
			
			$countdown = floor($countdown) ;
		//	echo $countdown;
		//	exit();
	?>	