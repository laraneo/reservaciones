
<!DOCTYPE html>
<html lang="es">
<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="9XFK0F3LPAJzJ9oUEVgPWNjzYTxcurzdcksosuu8">

    <title>Registro Contraseña</title>

    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta charset="UTF-8">
    <meta name="title" content="Registro Contraseña" />
    <meta name="description" content="Registro Contraseña" />
    <meta name="keywords" content="Booking, Calender, Make Booking, Laravel" />
    <meta name="author" content="Xtreme Webs" />

    <link rel="icon" href="../favicon.png">

    <!-- Styles -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="../plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
    <link href="../plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>

    <!-- Theme Styles -->
    <link href="../css/backend.min.css" rel="stylesheet" type="text/css"/>
    <link href="../css/themes/green.css" class="theme-color" rel="stylesheet" type="text/css"/>
    <link href="../css/custom.css" rel="stylesheet" type="text/css"/>



<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="page-login">

					<script type="text/javascript">
					function checkPass()
					{
						//Store the password field objects into variables ...
						var pass1 = document.getElementById('newpassword');
						var pass2 = document.getElementById('confirmpassword');
						//Store the Confimation Message Object ...
						var message = document.getElementById('confirmMessage');
						//Set the colors we will be using ...
						var goodColor = "#66cc66";
						var badColor = "#ff6666";
						//Compare the values in the password field 
						//and the confirmation field
						if(pass1.value == pass2.value){
							//The passwords match. 
							//Set the color to the good color and inform
							//the user that they have entered the correct password 
							pass2.style.backgroundColor = goodColor;
							message.style.color = goodColor;
							message.innerHTML = "";
							return true;
						}else{
							//The passwords do not match.
							//Set the color to the bad color and
							//notify the user.
							pass2.style.backgroundColor = badColor;
							message.style.color = badColor;
							message.innerHTML = "Las claves no coinciden!";
							return false;
						}
					} 
					
					
					function ValidateForm()
					{
						// return false;
						if(checkPass()){
							return true;
					   }
					   else{
						   alert("Las claves no coinciden!");
						   return false;
						}
					}
					
					
					</script>


<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper">
            
    <div class="row">
        <div class="col-md-3 center">
            <div class="login-box">
                <p style="text-align:center;">
                    <a href="../" class="logo-name text-lg text-center"><img src="../images/logo-dark.png" class="img-responsive"></a>
                </p>
                <p class="text-center m-t-md">Proporcione los detalles para registrar su contraseña a continuación.</p>

                
                <form class="m-t-md" method="post"  action="ValidatePasswordReset.php"
				onSubmit="return ValidateForm()"
				>
                    <input type="hidden" name="_token" value="9XFK0F3LPAJzJ9oUEVgPWNjzYTxcurzdcksosuu8">
                    <div class="form-group">
                     
						<input class="form-control" type="text" name="doc_id"  id="doc_id"  placeholder="Carnet Ej: 12422099, sin puntos ni letras" autofocus required><br><br>
						<input class="form-control" type="text" name="group_id" id="group_id" placeholder="Accion Ej: 1201-10, con el guion" required><br><br>
						 <input class="form-control" type="email" name="email" id="email" placeholder="Email Ej: jose.perez@gmail.com" required><br><br>
						 <input class="form-control" type="password" name="newpassword" id="newpassword" placeholder="Nueva Clave" required><br><br>
			   <input type="password" class="form-control" name="confirmpassword" id="confirmpassword"  onkeyup="checkPass(); return false;" placeholder="Confirmacion Clave" required><br>
						<span id="confirmMessage" class="confirmMessage" id="confirmMessage" ></span><br><br>
								<button type="submit"  class="btn btn-success btn-block" >Registrar Contraseña</button>						
					
                    </div>

                    

                    <br>
							
					
                </form>
                <p class="text-center m-t-xs text-sm">
                    Derechos de autor. &copy; 2020. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </div>

        </div>
    </div>
</main>


<!-- Javascripts -->
<script src="../plugins/jquery/jquery-2.1.4.min.js"></script>
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="../plugins/pace-master/pace.min.js"></script>
<script src="../plugins/jquery-blockui/jquery.blockui.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="../plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="../plugins/waves/waves.min.js"></script>
<script src="../js/backend.min.js"></script>

</body>
</html>
