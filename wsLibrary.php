<?php 

// require_once __DIR__ . '/application/vendor/autoload.php';

// use App\Application;

    // const const_servicio="http://192.168.0.11/wsServiciosSocios/wsSocios.asmx?wsdl"; 
	const const_delimitador = ";";
	const const_Error_Conexion_WS = -1;
	const const_Error_Token = -4;
	
	// -1: Error de conexion
	// $servicioweb = '';
	require 'config.inc';

	//if ($webservice=='')
	{
		//$webservice=CONST_URI_WEB_SERVICE; 
		//$webservice="http://192.168.0.11/wsServiciosSocios/wsSocios.asmx?wsdl"; 
		
	}
	
class customException extends Exception {
  public function errorMessage() {
    //error message
    $errorMsg = 'Error en linea '.$this->getLine().' en '.$this->getFile() .': <b>'.$this->getMessage().'</b> ';
    return $errorMsg;
  }
}

function wsCalculateToken()
{
	date_default_timezone_set('America/Caracas');
    $domain_id = "CCC";
    $date = date('Ymd');
    $calculated_token = md5($domain_id.$date);
    $calculated_token = base64_encode(strtoupper(md5($domain_id.$date )));

	return $calculated_token;
}
	

function wsConsultaSaldo($group_id, &$saldo, &$comments)
{
	$skipSaldo = true; // Parametro para desactivar validacion saldo
	if($skipSaldo) {
		return 0;
	}
	try {

		$token = wsCalculateToken();

		// $app = new Application();

		global $webservice;

		//phpinfo();

		$servicioweb = CONST_URI_WEB_SERVICE;
		//$servicioweb = $webservice;

		 //echo $servicioweb . "***";

		if ($servicioweb == '') {
			throw new customException('La cadena de URI_WEB_SERVICE está vacia');
		}
		
		$client = new SoapClient($servicioweb);
		
		$parametros=array(); //parametros de la llamada

		$parametros['group_id']=$group_id;
		$parametros['token']=$token;

		$result = $client->GetSaldoCSV($parametros);  //llamamos al método que nos interesa con los parámetros

		$resultados = explode(const_delimitador, $result->GetSaldoCSVResult);
	
		//print_r ($resultados);
	
		$cant = count($resultados); 
		//   status:-2: (no existe), 1: saldo>0 con deuda, -1: error (no hubo conexión a SQL), 0: saldo<=0
		// $status = $resultados[0];
		// $saldo = $resultados[1];
		$status = ($cant >=1 ? $resultados[0] : -1);
		$saldo = ($cant >=2 ? $resultados[1] : "");		
	
		if ($status == const_Error_Token)
		{
			$comments = "<h2>Invalid Token</h2>" . "<br>";	
		}

		return $status; // $result->GetSaldoResult
	}
	catch (customException $e) {
		$status = -5;
		
		$comments = "<h2>Custom Exception</h2>" . "<br>" . $e->errorMessage(); 
		
        return $status;
	}
	catch (Exception $e) { 
	
		$status = const_Error_Conexion_WS;
		
		$comments = "<h2>Exception Error catched by the Reservaciones application!</h2>" . "<br>" . $e->getMessage(); 

        return $status;
	}
}

function wsConsultaSocio($doc_id, &$comments)
{
	try {
		
		$token = wsCalculateToken();
	
		// $app = new Application();

		// $servicioweb = getenv('URI_WEB_SERVICE');
		global $webservice;
		
		$servicioweb = CONST_URI_WEB_SERVICE;
		
		if ($servicioweb == '') {
			throw new customException('La cadena de URI_WEB_SERVICE está vacia');
		}		
		
		$client = new SoapClient($servicioweb);
		
		$parametros=array(); 

		// string GetSocio($doc_id) 
		$parametros['doc_id']=$doc_id;
		$parametros['token']=$token;
		
		$result = $client->GetSocio($parametros); 

		$resultados = explode(const_delimitador, $result->GetSocioResult);
		$cant = count($resultados); 
		
		// status: 0: invalido (no existe), 1: ok, -1: error, -2: blacklist
		// $status = $resultados[0];
		// $comments = $resultados[1];
		$status = ($cant >=1 ? $resultados[0] : -1);
		$comments = ($cant >=2 ? $resultados[1] : "");		

		if ($status == const_Error_Token)
		{
			$comments = "<h2>Invalid Token</h2>" . "<br>";	
		}
		
		return $status; // $result->GetSocioResult
		
		}
	catch (Exception $e) { 
		$status = const_Error_Conexion_WS;
		
		$comments = "<h2>Exception Error catched by the Reservaciones application!</h2>" . "<br>" . $e->getMessage(); 

        return $status;
	}
}

function wsConsultaInvitado($doc_id, &$comments)
{
	try {
		
		$token = wsCalculateToken();
		
			// $app = new Application();

			// $servicioweb = getenv('URI_WEB_SERVICE');

		global $webservice;

		
		$servicioweb = CONST_URI_WEB_SERVICE;
		
		if ($servicioweb == '') {
			throw new customException('La cadena de URI_WEB_SERVICE está vacia');
		}		
		
		$client = new SoapClient($servicioweb);
		
		$parametros=array(); 

		// string GetInvitado($doc_id) 
		$parametros['doc_id']=$doc_id;
		$parametros['token']=$token;
		
		$result = $client->GetInvitado($parametros);
	
		$resultados = explode(const_delimitador, $result->GetInvitadoResult);
		$cant = count($resultados); 
		
		// status: 0: invalido (no existe), 1: ok, -1: error, -2: blacklist, -3 : socio
		// $status = $resultados[0];
		// $comments = $resultados[1];
		$status = ($cant >=1 ? $resultados[0] : -1);
		$comments = ($cant >=2 ? $resultados[1] : "");			

		if ($status == const_Error_Token)
		{
			$comments = "<h2>Invalid Token</h2>" . "<br>";	
		}
		return $status; // $result->GetInvitadoResult
		
		}
	catch (Exception $e) { 
		$status = const_Error_Conexion_WS;
		
		$comments = "<h2>Exception Error catched by the Reservaciones application!</h2>" . "<br>" . $e->getMessage(); 

        return $status;
	}
}

function wsConsultarBlackList($doc_id, &$comments, &$first_name, &$last_name)
{
	try {
		
		$token = wsCalculateToken();
		
			// $app = new Application();

			// $servicioweb = getenv('URI_WEB_SERVICE');

		global $webservice;
		
		//echo $doc_id;
		
		
		$servicioweb = CONST_URI_WEB_SERVICE;
		
		if ($servicioweb == '') {
			throw new customException('La cadena de URI_WEB_SERVICE está vacia');
		}
		
		$client = new SoapClient($servicioweb);
		
		$parametros=array(); 

		// string GetBlacklist($doc_id)  
		$parametros['doc_id']=$doc_id;
		$parametros['token']=$token;
		
		
		
		$result = $client->GetBlacklist($parametros);  
	
		$resultados = explode(const_delimitador, $result->GetBlacklistResult);
		
		
		
		$cant = count($resultados); 
		// status: 0: ok (no existe), 1: en lista negra, -1: error
		
		$status = ($cant >=1 ? $resultados[0] : -1);
		$comments = ($cant >=2 ? $resultados[1] : "");
		$first_name = ($cant >=3 ? $resultados[2] : "");
		$last_name = ($cant >=4 ? $resultados[3] : "");

		if ($status == const_Error_Token)
		{
			$comments = "<h2>Invalid Token</h2>" . "<br>";	
		}

		return $status;  // $result->GetBlacklistResult
		
		}
	catch (Exception $e) { 
		$status = const_Error_Conexion_WS;
		
		$comments = "<h2>Exception Error catched by the Reservaciones application!</h2>" . "<br>" . $e->getMessage(); 

        return $status;
	}
}


?>