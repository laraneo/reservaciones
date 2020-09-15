<?php 
	const const_delimitador = ";";
	const const_Error_Conexion_WS = -1;

	try {
		$client_id = $_GET['clientid'];	
		$numero = $_GET['number'];   
		$message= $_GET['message'];
		
		$numero = "4122840974";
		
		//client_id check
		if ($client_id != "izca2019")
		{
			$comments = "Invalid ClientID";
			echo $comments;
			
			$log = "\n" . date("d-M-Y H:m:s") . " " . $comments;
			file_put_contents('./logSMS/logSMS_'.date("d-M-Y").'.log', $log, FILE_APPEND);
		}
		else
		{
			//$idlog= $idlog;
			$usuario= "VXTECNO";
			$clave= "4SB2e5pcUc";
			$servicio="http://200.41.57.109:8086/m4.in.wsint/services/M4WSIntSR?wsdl"; 
			$parametros=array(); //parametros de la llamada
			$parametros['passport']=$usuario;
			$parametros['password']=$clave;
			$parametros['number']=$numero;
			$parametros['text']=$message;
			$client = new SoapClient($servicio, $parametros);
			$result = $client->sendSMS($parametros);
			foreach ($result as $r) {
				echo $r;    # code...
			}
			$log = "\n" . date("d-M-Y H:m:s") . " " . $numero . " - " . $message . " response: " . print_r($result);
			
			file_put_contents('./logSMS/logSMS_'.date("d-M-Y").'.log', $log, FILE_APPEND);
		}

	}
	catch (Exception $e) { 
	
		$status = const_Error_Conexion_WS;
		$comments = "<h2>Exception Error SMS Gateway!</h2>" . "<br>" . $e->getMessage(); 
		echo $comments;
		$log = "\n" . date("d-M-Y H:m:s") . " "  . $comments;
		file_put_contents('./logSMS/logSMS_'.date("d-M-Y").'.log', $log, FILE_APPEND);
	}

?>