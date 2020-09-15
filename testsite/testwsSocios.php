<?php

use MyApp\Application;

require __DIR__ . './vendor/autoload.php';

echo __DIR__;
exit;


const const_delimitador = ";";
const const_Error_Conexion_WS = -1;

//const const_servicio="http://localhost:55256/wsServiciosSocios/wsSocios.asmx?wsdl"; 
// const const_servicio="http://192.168.0.11/wsServiciosSocios/wsSocios.asmx?wsdl"; 

			
try {
	//phpinfo();

	$app = new Application();

	$servicioweb = getenv('URI_WEB_SERVICE');
	//$servicioweb = const_servicio;

	//$tz = getenv('REMOTE_ADDR'); //getenv('Default timezone');
	// $tz = $_SERVER["REMOTE_ADDR"];
	// echo $tz . "<br>";
	
	// $ipString = @getenv("HTTP_X_FORWARDED_FOR"); 
    // $addr = explode(",",$ipString); 
    // echo $ipString . "<br>";
    // echo $addr[sizeof($addr)-1] . "<br>";
	
	try {
		$servicio=$servicioweb; //url del servicio

        //$client = new SoapClient($servicio, $parametros);
        $client = new SoapClient($servicio);

		echo "* Conectado al servicio: " . $servicio;
		echo "<br>";

        $parametros=array(); //parametros de la llamada
		
	}
	catch (Exception $e) { 
		echo "<h2>Exception Error catched by the application connecting to " . $servicio . "</h2>"; 
		echo $e->getMessage(); 
	}

	try {
		/*  Version */
        
        $result = $client->GetVersion();  //llamamos al método que nos interesa con los parámetros

		$resultados = explode(const_delimitador, $result->GetVersionResult);
		
        //   status:-2: (no existe), 1: saldo>0 con deuda, -1: error (no hubo conexión a SQL), 0: saldo<=0
		$version = $resultados[0];

        echo "* Versión : "  . $version;
		echo "<br>";

	}
	catch (Exception $e) { 
		echo "<h2>Exception Error catched by the application connecting to " . $servicio . "</h2>"; 
		echo $e->getMessage(); 
	}
	
	try {
		/*  Acciones <- Saldos */
		// $accion = "1395-10";
        $accion="0052-10";
        // $accion="0395-10";
        $parametros['group_id']=$accion;
        
        $result = $client->GetSaldo($parametros);  //llamamos al método que nos interesa con los parámetros

		$resultados = explode(const_delimitador, $result->GetSaldoResult);
		
        //   status:-2: (no existe), 1: saldo>0 con deuda, -1: error (no hubo conexión a SQL), 0: saldo<=0
		$status = $resultados[0];
		$comments = $resultados[1];

        echo "* Saldo de la Accion No. "  . $accion . " es : status=" . $status . ", Saldo=" . $comments;
		echo "<br>";

	}
	catch (Exception $e) { 
		echo "<h2>Exception Error catched by the application connecting to " . $servicio . "</h2>"; 
		echo $e->getMessage(); 
	}
	
	try {
			/* Socios */
		// $cedula = "14.033.181";	// <- Socio Existente Activo no sancionado
        // $cedula = "14.033.182";	// <- Socio Inexistente
        // $cedula="12163697";	// <- Socio Existente Activo no sancionado
        // $cedula="13850754"; // <-- -- REMATE DE ACCION <- Socio Inactivo
        // $cedula="06319415"; // <-- ACCION EMBARGADA - 0378-10 <- Socio Activo
		//$cedula="42500319"; // <-- ACCION EMBARGADA - 0378-10 <- Socio Activo
		$cedula="11309311"; // PROHIBIDA LA ENTRADA ACCIÓN EMBARGADA  NOVIEMBRE 2010 <- Socio Inactivo
		
        $parametros['doc_id']=$cedula;
        
        $result = $client->GetSocio($parametros);  //llamamos al método que nos interesa con los parámetros
	
		$resultados = explode(const_delimitador, $result->GetSocioResult);
		
        // status: 0: invalido (no existe), 1: ok, -1: error, -2: blacklist
		$status = $resultados[0];
		$comments = $resultados[1];

        echo "* Socio de la Cedula No. "  . $cedula . " es : status=" . $status . ", Comments=" . $comments;
		echo "<br>";
		
	}
	catch (Exception $e) { 
		echo "<h2>Exception Error catched by the application connecting to " . $servicio . "</h2>"; 
		echo $e->getMessage(); 
	}

	try {
			/* Invitados */
		// $cedula = "110331917";	// <- Invitado Existente Activo no sancionado
        // $cedula = "10331918";	// <- Invitado Inexistente
        // $cedula="10146217";	// <- Ingresar solo como invitado, sin efecto el convenio. notificar a Deisy.
        // $cedula="3943264"; // <-- -- PROHIBIDA LA ENTRADA ACCIÓN EMBARGADA  NOVIEMBRE 2010
        //$cedula="10508460"; // <-- Invitados que son Socios
		$cedula="11309311"; // PROHIBIDA LA ENTRADA ACCIÓN EMBARGADA  NOVIEMBRE 2010 <- Socio Inactivo
		
        $parametros['doc_id']=$cedula;
        
        $result = $client->GetInvitado($parametros);  //llamamos al método que nos interesa con los parámetros
	
		$resultados = explode(const_delimitador, $result->GetInvitadoResult);
		
        // status: 0: invalido (no existe), 1: ok, -1: error, -2: blacklist, -3 : socio
		$status = $resultados[0];
		$comments = $resultados[1];

        echo "* Invitado de la Cedula No. "  . $cedula . " es : status=" . $status . ", Comments=" . $comments;
		echo "<br>";
		
	}
	catch (Exception $e) { 
		echo "<h2>Exception Error catched by the application connecting to " . $servicio . "</h2>"; 
		echo $e->getMessage(); 
	}

	try {
				/* Sancionados (Blacklist) */
		// $cedula = "14.033.1817";	// <- Socio Existente Activo no sancionado
        // $cedula = "14.033.182";	// <- Socio Inexistente
        // $cedula="06319415";	// <- ACCION EMBARGADA - 0378-10 <- Socio Activo
        // $cedula="06913233"; // <-- -- REMATE DE ACCION <- Socio Activo
		// $cedula="13850754"; // <-- -- REMATE DE ACCION <- Socio Inactivo
		$cedula="11309311"; // PROHIBIDA LA ENTRADA ACCIÓN EMBARGADA  NOVIEMBRE 2010 <- Socio Inactivo
		
        $parametros['doc_id']=$cedula;
        
        $result = $client->GetBlacklist($parametros);  //llamamos al método que nos interesa con los parámetros
	
		$resultados = explode(const_delimitador, $result->GetBlacklistResult);
		
        // status: 0: ok (no existe), 1: en lista negra, -1: error
		$status = $resultados[0];
		$comments = $resultados[1];
		$first_name = $resultados[2];
		$last_name = $resultados[3];

        echo "* Sancionado (Blacklist) de la Cedula No. "  . $cedula . " es : " . "status=" . $status . ", First Name=" . $first_name . ", Last Name=" . $last_name  . ", Comments=" . $comments;
		echo "<br>";

	}
	catch (Exception $e) { 
		echo "<h2>Exception Error catched by the application connecting to " . $servicio . "</h2>"; 
		echo $e->getMessage(); 
	}
}
catch (Exception $e) { 
	echo "<h2>Exception Error catched by the application connecting to " . $servicio . "</h2>"; 
	echo $e->getMessage(); 
}


?>