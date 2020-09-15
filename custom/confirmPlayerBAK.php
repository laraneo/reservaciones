
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

					// Show all URL parameters (and
					// all form data submitted via the 
					// 'get' method)
					foreach($_GET as $key=>$value){
						//echo $key, ' => ', $value, "<br/>";
					}

					// Show a particular value.
					$token = $_GET['token'];
					require '../config.inc';

					$conn = mysqli_connect($servername, $username, $password, $database);
					// Check connection
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					
					//validar horario para confirmacion con horario de uso de app
					
					$bookingUser_endTime = "";
					$sql = "select bookingUser_endTime from settings";
					$result1 = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result1) > 0) 
					{	
						while($row = mysqli_fetch_assoc($result1)) 
						{
							$bookingUser_endTime = $row["bookingUser_endTime"];					
						}
					}
					
					//echo $bookingUser_endTime;
					
					date_default_timezone_set("America/Caracas");
					//echo "<br>" . date("H:i");
					//$now = date("Y-m-d H:i:s");
					//echo "<br>" . date("H:i", strtotime('-2 hours', $now));
					
					//echo "<br>" .  date("H:i",time()+ (2*60*60));
					
					$comparedate = date("H:i",time()+ (2*60*60));
					//echo "<br>" . $comparedate;
					
					$time1 = (int) substr($bookingUser_endTime, 0, 2) + 1;
					$time2 = date("H");
					
					//echo $time1 . " - " .  $time2;
					//die();
					
					//if ($time2 < $time1)
					if (1==0)
					{
						print "                    <p style=\"text-align: center;\">\n";
						print "                        <img src=\"../images/icon-booking-failed.png\">\n";
						print "                    </p>\n";
						print "                    <br>\n";
						print "                    <h1 class=\"text-dark\"><strong>Fuera del horario para confirmar su participacion</strong></h1>\n";
						print "                    <br>\n";
						print "                    <p class=\"text-muted\"></p>";

					}
					
					else
					{	
					
						$sql = "
						SELECT p.confirmed,p.doc_id, 
						CASE p.player_type WHEN 0 THEN u.first_name ELSE g.first_name END AS first_name,
						CASE p.player_type WHEN 0 THEN u.last_name ELSE g.last_name END AS last_name,
						b.`booking_date`, b.`booking_time` 
						FROM booking_players p
						JOIN bookings b ON p.`booking_id`=b.id 
						LEFT JOIN guests g ON g.doc_id=p.doc_id
						LEFT JOIN users u ON u.doc_id=p.doc_id
						WHERE  token = '" . $token . "'";

							// $sql = "SELECT  p.confirmed,p.doc_id,g.first_name, g.last_name ,b.`booking_date`, b.`booking_time`
								// FROM  booking_players p, guests g , bookings b
								// WHERE g.doc_id=p.doc_id  AND p.`booking_id`=b.id AND token = '" . $token . "'";

						//echo $sql;

						$result = mysqli_query($conn, $sql);

						if (mysqli_num_rows($result) > 0) 
						{

							print "                    <p style=\"text-align: center;\">\n";
							print "                        <img src=\"../images/icon-booking-completed.png\">\n";
							print "                    </p>\n";
							print "                    <br>\n";
							print "                    <h1 class=\"text-dark\"><strong>Recuerde estar 15 minutos <br>antes en el Starter</strong></h1>\n";
							print "                    <br>\n";
							print "                    <p class=\"text-muted\"></p>";


								// output data of each row
								while($row = mysqli_fetch_assoc($result)) 
								{
									$booking_date = $row["booking_date"];
									$doc_id = $row["doc_id"];
									// $doc_id = $row["p.doc_id"];
									
									
									if ($row["confirmed"] == 0) 
										echo "Confirmacion de participante exitosa<br>";
									else if ($row["confirmed"] == 1)
										echo "Participante ya estaba confirmado<br>";
									else if ($row["confirmed"] == -1)
										echo "Participante ya habia sido rechazado por otra confirmacion previa el mismo dia<br>";
									//echo $row["confirmed"] ." - id: " . $row["doc_id"]. " - Nombre: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
									
									echo  $row["first_name"]. " " . $row["last_name"]. "<br>";
										echo "<b>	Fecha: "  .  $row["booking_date"] . "</b><br/>";
										echo "	<b>Hora: "  .  $row["booking_time"] .  "</b><br/>";
								}

								$sql="UPDATE booking_players SET confirmed=1,confirmed_at=NOW() WHERE token = '" . $token . "' and confirmed=0";
								$result = mysqli_query($conn, $sql);

								if (!$result) {
									die('Consulta invalida: ' . mysqli_error());
								}
								else							
								{
									$sql2="UPDATE booking_players SET confirmed=-1 WHERE doc_id = '" . $doc_id . "' and confirmed <>1 booking_id IN ( select id   from bookings where booking_date='" . $booking_date .  "' )";
									
									$result = mysqli_query($conn, $sql2);
								}
						} 
						else 
						{
							print "                    <p style=\"text-align: center;\">\n";
							print "                        <img src=\"../images/icon-booking-failed.png\">\n";
							print "                    </p>\n";
							print "                    <br>\n";
							print "                    <h1 class=\"text-dark\"><strong>Token no valido</strong></h1>\n";
							print "                    <br>\n";
							print "                    <p class=\"text-muted\"></p>";
						}

					}
					
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
