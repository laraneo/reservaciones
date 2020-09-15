<?php					
	$refresh = '';
	// Show a particular value.
	if (isset($_GET['refresh']))
	{
		$refresh = $_GET['refresh'];	
	}
	else
	{
		$refresh = 120;
	}
?>

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

	<meta http-equiv="refresh" content="<?php echo $refresh; ?>">

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
			<div class="col-md-12 text-center">
			<center>
			<br><strong> LEYENDA</strong> <br>
			<table width='50%' border=1>
			<tr>
			<td bgcolor="FFFFFF" align="center">DISPONIBLE</td>
			<td bgcolor="f2ef11" align="center">EVENTO</td>
			<td bgcolor="00FF00" align="center">RESERVADO</td>
			</tr>
			</table>
			</center>
			</div>
			</div>

		
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 text-center">
                    <br>

	
                    <h1 class="text-dark"><strong></strong></h1>	

					<?php

					$debug=0;	

					// 0 reservado
					// 1 evento
					// -1 disponible
					function CalcularSlot($booking_date, $booking_time, $package_id, $conn, $debug)
					{
						$status = -1;
						$sSQL = "SELECT * FROM bookings WHERE status = 'Procesando' AND  package_id=" . $package_id . " AND booking_date = '"  . $booking_date .  "' and 	booking_time = '"  . $booking_time . "'";
						if ($debug==1) echo $sSQL . "<br>";

						$result = sqlsrv_query($conn, $sSQL);
						
						if( $result === false) {
							die( print_r( sqlsrv_errors(), true) );
						}

						while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) {
							 $status = 0;		
						}
						sqlsrv_free_stmt( $result);	
										
						//echo $booking_date . " " . strtotime($booking_date) . " - " . $booking_time . " " . date("H:i:s", strtotime($booking_time)) . " * " . strtotime($booking_time).  "<br>";
						
						//$sSQL = "SELECT * FROM events WHERE is_active = 1 AND  date = '"  . date("Y-m-d", strtotime($booking_date)) .  "' AND Convert(Time(0),time1,0)  <= '"  . date("h:i:s", strtotime($booking_time))  . "' AND Convert(Time(0),time2,0)  >= '"  . date("h:i:s", strtotime($booking_time)) . "'";
						$sSQL = "SELECT * FROM events WHERE is_active = 1 AND  date = '"  . date("Y-m-d", strtotime($booking_date)) .  "' AND Convert(Time(0),time1,0)  <= '"  . date("H:i:s", strtotime($booking_time))  . "' AND Convert(Time(0),time2,0)  >= '"  . date("H:i:s", strtotime($booking_time)) . "'";
						//echo $sSQL . "<br>";


						if ($debug==1) echo $sSQL . "<br>";
						$result2 = sqlsrv_query($conn, $sSQL);
						
						
						if( $result2 === false) {
							die( print_r( sqlsrv_errors(), true) );
						}

						while( $row = sqlsrv_fetch_array( $result2, SQLSRV_FETCH_ASSOC) ) {
							 $status = 1;		
						}
						sqlsrv_free_stmt( $result2);	

						
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
					
					$category_id = "";
					if (isset($_GET['category']))
					{
						$category_id = $_GET['category'];	
					}		
					
					$package_id = "";
					if (isset($_GET['package']))
					{
						$package_id = $_GET['package'];	
					}		
					
					
					
					require '../config.inc';

					$connectionInfo = array( 
						"Database"=> $database,
						"UID"=> $username, 
						"PWD"=> $password
					);

					$conn = sqlsrv_connect($servername, $connectionInfo);
					// Check connection
					if( $conn === false ) {
						die( print_r( sqlsrv_errors(), true));
					}					
					
					
					//validar horario para confirmacion con horario de uso de app
					$bookingUser_endTime = "";
					$bookingTime_perpackage = 0;
					$sql = "select  slot_duration,bookingTime_perpackage from settings";
					$result1 = sqlsrv_query( $conn, $sql );
					if( $result1 === false) {
						die( print_r( sqlsrv_errors(), true) );
					}

					while( $row = sqlsrv_fetch_array( $result1, SQLSRV_FETCH_ASSOC) ) {
						  $slot_duration = $row["slot_duration"];
						  $bookingTime_perpackage = $row["bookingTime_perpackage"];					  
					}
	
					sqlsrv_free_stmt( $result1);					
					

					if ($bookingTime_perpackage ==1)
					{
						//buscar settings para el package que se envia por URL
						
					}
					
					if ($debug==1)
					{
						echo "slot_duration " . $slot_duration . "<br>";
						echo "bookingTime_perpackage " . $bookingTime_perpackage . "<br>";
						echo "package " . $package_id . "<br>";
						echo "category " . $category_id . "<br>";						
					}
					


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
					
					// para todos los paquetes de la categoria golf 
					$filtro_paquetes = "";
					if ($category_id!="")
					{
						$filtro_paquetes = $filtro_paquetes . " AND p.category_id=" . $category_id ;
					}
					
					if ($package_id!="")
					{
						$filtro_paquetes = $filtro_paquetes . " AND p.id=" . $package_id ;
					}					
					
					
					$sql = "select p.id, p.title, c.title as categoria  from packages p, categories c where c.id=p.category_id ";
					$sql = $sql . $filtro_paquetes;
					//$sql = "select id, title from packages where category_id=" . $category_id;

					if ($debug==1)	echo $sql . "<br>";
					//echo $sql . "<br>";
					
					$result9 = sqlsrv_query($conn, $sql);
					
					if( $result9 === false) {
						die( print_r( sqlsrv_errors(), true) );
					}

					while( $row = sqlsrv_fetch_array( $result9, SQLSRV_FETCH_ASSOC) ) {

							$package_id= $row["id"];					
							$package_name= $row["title"];	
							$category_name = $row["categoria"];	
							
							//$package_id=2;

							//$sql = "select opening_time, closing_time, day, is_off_day from booking_times where id=" . $today_number  ;  //incluir package y tabla booking times package
							$sql = "select opening_time, closing_time, day, is_off_day from booking_times_packages where package_id=" . $package_id . " AND number=" . $today_number  ;  //incluir package y tabla booking times package
							$result2 = sqlsrv_query($conn, $sql);
							if ($debug==1) echo $sql . "<br>";

							if( $result2 === false) {
								die( print_r( sqlsrv_errors(), true) );
							}

							while( $row = sqlsrv_fetch_array( $result2, SQLSRV_FETCH_ASSOC) ) {
									$opening_time = $row["opening_time"];					
									$closing_time = $row["closing_time"];					
									$is_off_day = $row["is_off_day"];					
							}

							sqlsrv_free_stmt( $result2);							
							

							echo  "<br><strong>" . $category_name . " - " .  $package_name . "</strong> <br>";
							echo  $event_date . " @ ";
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
								$status = CalcularSlot($booking_date, $booking_time, $package_id, $conn, $debug);
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

						  
					}

					sqlsrv_free_stmt( $result9);					

					sqlsrv_close($conn);

					?>
						
				<br><br>						
	
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
                            Derechos de autor. &copy; 2020. Todos los derechos reservados 
                        </span>
                </div>
            </div>
        </div>
    </footer>

<script src="../js/jquery-3.1.1.min.js"></script>
<script src="../js/app.js"></script>
</body>
</html>
