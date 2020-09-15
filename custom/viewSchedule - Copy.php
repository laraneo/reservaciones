
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="Sistema Reservaciones" />
    <meta name="description" content="Sistema de Reservaciones" />
    <meta name="keywords" content="reservar, golf, partidas" />
    <meta name="author" content="Sevicon Soluciones" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="6YitsSAgtnORcx5j7UrqA4swuSH6a88Rr3x5C43J">

    <!-- INDEX URL -->
    <meta name="index" content="../reservaciones">

    <!-- Title -->
    <title>Reservacion de Partidas</title>
    <link rel="stylesheet" href="../css/app.css">
    <link rel="icon" href="../favicon.png">
        <!-- GENERATED CUSTOM COLORS -->
<style>
    .top-nav {
        background-color: #007bff !important;
    }
    .bottom-nav {
        background-color: #4e5e6a !important;
    }
    .type_title.active {
        background-color: #4e5e6a !important;
    }
    .btn-outline-dark {
        border-color: #4e5e6a !important;
    }
    .btn-outline-dark:hover {
        background-color: #4e5e6a !important;
    }
    .btn-primary {
        color:#FFFFFF !important;
    }
    .btn-danger {
        color:#FFFFFF !important;
    }
    .btn-dark {
        color:#FFFFFF !important;
    }
    .fas {
        color:#007bff !important;
    }
    .text-primary {
        color:#007bff !important;
    }
    .footer {
        background-color: #4e5e6a !important;
    }
</style>    <style>
        .promo {
            background: linear-gradient(rgba(0,0,0,.5),rgba(0,0,0,.7)),rgba(0,0,0,.7) url('../images/promoClosed.jpg') no-repeat;
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body style="background-color: #F2F2F2;">

<nav class="navbar navbar-light navbar-expand-lg bg-primary top-nav">
    <a class="navbar-brand" href="../" style="color:#FFFFFF;"><img src="../images/logo-light.png" height="40"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

</nav>

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">
			
			
			</h1>
            <p class="promo-desc text-center"></p>
        </div>
    </div>

    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 text-center">
                    <br>

	
                    <h1 class="text-dark"><strong></strong></h1>	

					<?php

					// 0 reservado
					// 1 evento
					// -1 disponible
					function CalcularSlot($booking_date, $booking_time, $conn)
					{
						$status = -1;
						$sSQL = "SELECT * FROM bookings WHERE status = 'Procesando' AND  booking_date = '"  . $booking_date .  "' and 	booking_time = '"  . $booking_time . "'";
						//echo $sSQL . "<br>";

						$result = mysqli_query($conn, $sSQL);
						//echo $sql;
						if (mysqli_num_rows($result) > 0) 
						{	
							while($row = mysqli_fetch_assoc($result)) 
							{
								$status = 0;				
							}
						}											

						
						
						$sSQL = "SELECT * FROM events WHERE is_active = 1 AND  date = '"  . date("Y-m-d", strtotime($booking_date)) .  "' AND CONVERT(time1, TIME) <= '"  . date("h:i:s", strtotime($booking_time))  . "' AND CONVERT(time2, TIME) >= '"  . date("h:i:s", strtotime($booking_time)) . "'";


						//echo $sSQL . "<br>";
						$result2 = mysqli_query($conn, $sSQL);
						//echo $sql;
						if (mysqli_num_rows($result2) > 0) 
						{	
							while($row = mysqli_fetch_assoc($result2)) 
							{
								$status = 1;				
							}
						}						
						
						return  $status;
					}
					
					function CalcularColorSlot($status)
					{
						$color = "FFFFFF";
						if ($status==-1)
						{
							$color = "FFFFFF";
						}
						else if ($status==0)
						{
							$color = "00FF00";
						}
						else if ($status==1)
						{
							$color = "f2ef11";
						}
					
						return "#" . $color;
					}
												

					
					
					// Show all URL parameters (and
					// all form data submitted via the 
					// 'get' method)
					foreach($_GET as $key=>$value){
						//echo $key, ' => ', $value, "<br/>";
					}

					$fecha = '';
					// Show a particular value.
					if (isset($_GET['date']))
					{
						$fecha = $_GET['date'];	
					}
					
					require '../config.inc';

					$conn = mysqli_connect($servername, $username, $password, $database);
					// Check connection
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					
					//validar horario para confirmacion con horario de uso de app
					
					$bookingUser_endTime = "";
					$sql = "select  slot_duration from settings";
					$result1 = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result1) > 0) 
					{	
						while($row = mysqli_fetch_assoc($result1)) 
						{
							$slot_duration = $row["slot_duration"];					
						}
					}

					$package_id=3;
					
					date_default_timezone_set("America/Caracas");
					if ($fecha != '')
					{
						$event_date =  $fecha;
					}
					else
					{
						$event_date = date("d-m-Y");	
					}
					
					echo  $event_date . " @ ";
					$timestamp_for_event = strtotime($event_date);
					$today_number = date('N', $timestamp_for_event);			
					//echo $today_number;
					//$sql = "select opening_time, closing_time, day, is_off_day from booking_times where id=" . $today_number  ;  //incluir package y tabla booking times package
					$sql = "select opening_time, closing_time, day, is_off_day from booking_times_packages where package_id=" . $package_id . " AND number=" . $today_number  ;  //incluir package y tabla booking times package
					$result2 = mysqli_query($conn, $sql);
					//echo $sql;
					if (mysqli_num_rows($result2) > 0) 
					{	
						while($row = mysqli_fetch_assoc($result2)) 
						{
							$opening_time = $row["opening_time"];					
							$closing_time = $row["closing_time"];					
							$is_off_day = $row["is_off_day"];					
						}
					}					

					echo	$opening_time . " - " . $closing_time . "<br><br>"; 
					//echo	$is_off_day . "<br>";  
					

					//$start_time  = date("d-m-Y") . " " . $opening_time ;
					//$end_time  = date("d-m-Y") . " " . $closing_time ;

					$start_time  = $event_date . " " . $opening_time ;
					$end_time  = $event_date . " " . $closing_time ;
					
					//echo	"<br>" . $start_time . " - "; 
					//echo	$end_time . "<br><br>"; 
					
					
					echo "<table width='100%' border=1>";
					$count = 0;
					
					$hour = $start_time;
					$hour = date("H:i", strtotime($hour));
					
					$start_time = date("H:i", strtotime($start_time));
					$end_time = date("H:i", strtotime($end_time));

					//echo	"<br>" . $start_time . " - "; 
					//echo	$end_time . "<br><br>"; 
					//echo	$hour . "<br><br>"; 

					
					while ($hour <	$end_time)
					{
						//echo	$hour . " < " . $end_time . "<br>"; 	
						//echo $hour . "<br>";

						if ($count == 0 )
						{
							echo "<tr>";	
						}

						//pintar color
						//$booking_date = date("d-m-Y", strtotime($hour));
						$booking_date = date("d-m-Y",  strtotime($event_date . " " . $hour));
						$booking_time = date("H:i A", strtotime($hour));
						$status = CalcularSlot($booking_date, $booking_time, $conn);
						$color = CalcularColorSlot($status);
						//$color = "00FF00";
						
						if ($count < 6)
						{
							
							echo "<td bgcolor='" . $color . "'>";
							echo $hour;
							echo "</td>";
							$count = $count + 1;
						}
						else
						{
							echo "</tr>";		
							$count = 0;
							
							echo "<tr>";		
							
							echo "<td bgcolor='" . $color . "'>";
							echo $hour;
							echo "</td>";
							$count = $count + 1;
							
						}
						
						//$start = '2018-05-21 20:24:45';
						$hour = date('d-m-Y H:i',strtotime('+' . $slot_duration .  ' minutes',strtotime($hour)));
						$hour = date("H:i", strtotime($hour));
						//echo $hour;		
						
					}						

					echo "</table>";					
					
					mysqli_close($conn);

					?>
									
	
                    <p class="text-muted"></p></b>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                        <span class="text-copyrights">
                            Derechos de autor. &copy; 2018. Todos los derechos reservados a IZCC.
                        </span>
                </div>
            </div>
        </div>
    </footer>

<script src="../js/jquery-3.1.1.min.js"></script>
<script src="../js/app.js"></script>
</body>
</html>
