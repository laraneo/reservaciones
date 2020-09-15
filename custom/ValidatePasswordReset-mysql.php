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
					foreach($_POST as $key=>$value){
						//echo $key, ' => ', $value, "<br/>";
					}

					// Show a particular value.
					$email = $_POST['email'];
					$group_id = $_POST['group_id'];
					$doc_id = $_POST['doc_id'];
					$newpassword = $_POST['newpassword'];
					$confirmpassword = $_POST['confirmpassword'];
					
					if ($newpassword != $confirmpassword)
					{
						print "                    <p style=\"text-align: center;\">\n";
						print "                        <img src=\"../images/icon-booking-completed.png\">\n";
						print "                    </p>\n";
						print "                    <br>\n";
						print "                    <h1 class=\"text-dark\"><strong>La confirmación de la clave no coincide. Por favor inténtelo nuevamente</strong></h1>\n";
						print "                    <br>\n";
						print "                    <p class=\"text-muted\"></p>";								

						// print "                    <button type=\"submit\" class=\"btn btn-success btn-block\">{{ __('passwords.reset_btn') }}</button>"
						// print "                    <a href=\"{{ route('login') }}\" class=\"display-block text-center m-t-md text-sm\">{{ __('passwords.back_to_login_btn') }}</a>"

						die();
					}								
					
					
					require '../config.inc';
					

					$conn = mysqli_connect($servername, $username, $password, $database);
					// Check connection
					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}
					$sql = "SELECT * FROM users WHERE  email = '" . trim($email) . "' AND group_id = '" . trim($group_id) . "' AND doc_id = '" . trim($doc_id) . "'";

						// $sql = "SELECT  p.confirmed,p.doc_id,g.first_name, g.last_name ,b.`booking_date`, b.`booking_time`
							// FROM  booking_players p, guests g , bookings b
							// WHERE g.doc_id=p.doc_id  AND p.`booking_id`=b.id AND token = '" . $token . "'";

					 //echo $sql;
					 //die();

					$result = mysqli_query($conn, $sql);

					if (mysqli_num_rows($result) > 0) {

							$password_encrypted= password_hash($newpassword, PASSWORD_BCRYPT, [10]);

							//echo $password_encrypted;
							//die();
							
							$sql="UPDATE users SET password='" . $password_encrypted . "' WHERE  email = '" . $email . "' AND group_id = '" . $group_id . "' AND doc_id = '" . $doc_id . "'";
							//echo $sql;
							//die();
							
							$result = mysqli_query($conn, $sql);

							if (!$result) {
								die('Consulta inválida: ' . mysqli_error());
							}
							else
							{
								print "                    <p style=\"text-align: center;\">\n";
								print "                        <img src=\"../images/icon-booking-completed.png\">\n";
								print "                    </p>\n";
								print "                    <br>\n";
								print "                    <h1 class=\"text-dark\"><strong>Su solicitud de Actualización de Clave ha sido procesada exitosamente</strong></h1>\n";
								print "                    <br>\n";
								print "                    <p class=\"text-muted\"></p>";								

								// print "                    <button type=\"submit\" class=\"btn btn-success btn-block\">{{ __('passwords.reset_btn') }}</button>"
								// print "                    <a href=\"{{ route('login') }}\" class=\"display-block text-center m-t-md text-sm\">{{ __('passwords.back_to_login_btn') }}</a>"
							}								
					} 
					else 
					{
						
						print "                    <p style=\"text-align: center;\">\n";
						print "                        <img src=\"../images/icon-booking-failed.png\">\n";
						print "                    </p>\n";
						print "                    <br>\n";
						print "                    <h1 class=\"text-dark\"><strong>Datos Inválidos <br><br></strong></h1>\n";
						print "                    <br>\n";
						/*print "                    <p class=\"text-muted\">Se ha enviado un correo electrónico para revisar la información ingresada</p>";
						
						$message = "";
						$message .= "<b>Carnet: </b>" . $doc_id . "<br>";
						$message .= "<b>Acción: </b>" . $group_id . "<br>";
						$message .= "<b>Email:  </b>" . $email . "<br>";
						$message .= "<b>Clave:  </b>" . $newpassword . "<br>";
						
						mail ("laraneo@gmail.com", "Solicitud Actualizacion Datos IZCC",$message);
						*/
					}

					mysqli_close($conn);

					?>

					<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-2"></div>
						<div class="col-md-4">
						<center>
						<a href="../home" class="btn btn-primary btn-lg btn-block"><i class="far fa-user"></i>&nbsp;&nbsp;Mi Cuenta</a>
						</center>	
						</div>
					
					</div>

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