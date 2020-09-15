	<?php
			require 'config.inc';
		
			$connection = mysqli_connect($servername, $username, $password, $database); 

			// Check connection 
			if (mysqli_connect_errno()) 
			{ 
				$has_errors = 1;	
				$err_message =  $err_message . "<br>Database connection failed."; 
				exit(); //die();
			}

			 $queryCountDown = "SELECT (TIME_TO_SEC(TIMEDIFF(expiration_date,NOW()))) as countdown from session_slots where session_email='" .  Auth::user()->email  .  "' and booking_date='" .  Session::get('event_date')  . "' AND booking_time='" .  Session::get('booking_slot')  . "'"  ;
			
			
 //echo $queryCountDown;

			$resultqueryCountDown = mysqli_query($connection, $queryCountDown); 
			 
			if ($resultqueryCountDown) 
			{ 
				$rowGroupCount = mysqli_num_rows($resultqueryCountDown); 
			    //printf("Number of row in the table : " . $rowGroupCount); 
				if ($rowGroupCount>0) 
				{
					while($row = mysqli_fetch_array($resultqueryCountDown)){
						$countdown = $row['countdown'];
					}
				}
				else
				{
					$countdown= config('settings.bookingTimeout')*60 ;
				}
			}	
			$countdown = floor($countdown) ;
		//	echo $countdown;
		//	exit();
	?>	