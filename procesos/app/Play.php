<?php 
namespace App;   
use INC\DB;
use INC\Reader;

class Play {

    var $db;
	var $appbaselink;
	var $debug = 0;

    function __construct(){

        Reader::open('inc/Settings.inc');

        $data = Reader::getConnectionArray();

        $this->db = new DB($data["HOST"], $data['PORT'],$data["DB_NAME"], $data["DB_USER"], $data["DB_PASS"]);

		$this->appbaselink  = $data['APP_CONFIRMATION_LINK'];
		//echo $this->$appbaselink;
		//die();

//		echo  $this->debug;
		
        if (isset($_GET['cmd'])){
            if($_GET['cmd']==1){
                print_r($this->ReminderBookings(0));   //reminder confirmations
            }
            else if($_GET['cmd']==2){
                print_r($this->ReminderBookings(1));   //purge bookings with less than two participants confirmed
			}
            else if($_GET['cmd']==3){
                print_r($this->ReleaseCanceledBookings());   //release canceled bookings
			}			
/*            else if($_GET['cmd']==4){
                print_r($this->sendEmails());
			}
            else if($_GET['cmd']==5){
                print_r($this->sendEmailsElastic());
			}*/
			else if($_GET['cmd']==0){
				echo "test";
				die();
			}
        } else {
            echo "Debe indicar una operacion";
        }
    }


	
	//functions to collect information

    function dataToReleaseCanceledBookings(){
	/*
	SELECT CURDATE()
	SELECT DATE_FORMAT(NOW(), '%d-%m-%Y');	
	*/
	
		$sql = "SELECT c.*, b.`booking_date`, b.`booking_time`, b.locator, b.`status` FROM cancel_requests c, bookings b WHERE b.id=c.`booking_id` AND c.STATUS='Pendiente'";

        return $this->db->query($sql);

        //return $this->db->fetchAll(PDO::FETCH_ASSOC) ;
    }

	
    function dataToPurgeBookings(){
	/*
      $sql = "SELECT b.id,pk.title AS paquete, c.title AS categoria,
			(CASE
				WHEN p.player_type =0 THEN 
				( SELECT CONCAT(u.first_name,' ',u.last_name,';', IFNULL(u.phone_number, ''  ) ,';', IFNULL(u.email, ''  )) FROM users u WHERE u.doc_id = p.doc_id ) 
				ELSE 
				( SELECT CONCAT(g.first_name ,' ', g.last_name, ';', IFNULL(g.phone_number, ''  ),';', IFNULL( g.email, '')) FROM guests g WHERE g.doc_id = p.doc_id )
			END) AS player,
			b.booking_date, b.booking_time, b.status, b.locator, b.package_id,
			p.confirmed, p.confirmed_at, '' AS group_id, 'INVITADO' AS rol
			FROM   bookings b , booking_players p, packages pk, categories c
			WHERE b.id = p.booking_id
			AND DATE_FORMAT(b.created_at, '%d-%m-%Y') = DATE_FORMAT(NOW(), '%d-%m-%Y')
			AND b.package_id = pk.id 
			AND c.id=pk.category_id  
			
			UNION ALL

			SELECT b.id, pk.title AS paquete, c.title AS categoria,
			CONCAT(u.first_name ,' ', u.last_name, ';',u.phone_number,';', u.email)  AS player , 
			b.booking_date, b.booking_time, b.status, b.locator, b.package_id,
			1 AS confirmed,b.created_at AS confirmed_at, u.group_id, 'RESPONSABLE' AS rol
			FROM  bookings b , users u, packages pk, categories c
			WHERE b.user_id = u .id
			AND DATE_FORMAT(b.created_at, '%d-%m-%Y') = DATE_FORMAT(NOW(), '%d-%m-%Y')
			AND b.package_id = pk.id 
			AND c.id=pk.category_id
	  ";
	  */
	  
	  $sql = " SELECT b.id,pk.title AS paquete, c.title AS categoria,
			(CASE
				WHEN p.player_type =0 THEN 
				( SELECT CONCAT(u.first_name,' ',u.last_name,';', IFNULL(u.phone_number, ''  ) ,';', IFNULL(u.email, ''  )) FROM users u WHERE u.doc_id = p.doc_id ) 
				ELSE 
				( SELECT CONCAT(g.first_name ,' ', g.last_name, ';', IFNULL(g.phone_number, ''  ),';', IFNULL( g.email, '')) FROM guests g WHERE g.doc_id = p.doc_id )
			END) AS player,
			b.booking_date, b.booking_time, b.status, b.locator, b.package_id,
			p.confirmed, p.confirmed_at, '' AS group_id, 'INVITADO' AS rol,
			
			CONCAT(u.first_name ,' ', u.last_name, ';',u.phone_number,';', u.email)  AS Mainplayer  , p.token			
			
			FROM   bookings b , booking_players p, packages pk, categories c, users u
			WHERE b.id = p.booking_id
			AND DATE_FORMAT(b.created_at, '%d-%m-%Y') = DATE_FORMAT(NOW(), '%d-%m-%Y')
			AND b.package_id = pk.id 
			AND c.id=pk.category_id  
			AND b.user_id=u.id
			AND b.status <> 'Cancelado'
			
			ORDER BY b.id ASC
		";
	  

        return $this->db->query($sql);

        //return $this->db->fetchAll(PDO::FETCH_ASSOC) ;
    }

	
	function dataToReminderBookings()
	{
		return dataToPurgeBookings();
	}


    function dataToCalcularParticipantesNoConfirmados($booking_id){
	
		$sql = "SELECT p.doc_id,
			(CASE
				WHEN p.player_type =0 THEN 
				( SELECT CONCAT(u.first_name,' ',u.last_name,';', IFNULL(u.phone_number, ''  ) ,';', IFNULL(u.email, ''  )) FROM users u WHERE u.doc_id = p.doc_id ) 
				ELSE 
				( SELECT CONCAT(g.first_name ,' ', g.last_name, ';', IFNULL(g.phone_number, ''  ),';', IFNULL( g.email, '')) FROM guests g WHERE g.doc_id = p.doc_id )
			END) AS player
			FROM booking_players p WHERE p.confirmed=0 and booking_id=" . $booking_id ;
		
		//echo $sql;
        return $this->db->query($sql);

        //return $this->db->fetchAll(PDO::FETCH_ASSOC) ;
    }

    function dataToCalcularParticipantesConfirmados($booking_id){
	
		$sql = "SELECT count(*) as cantidad from booking_players where confirmed=1 and booking_id=" . $booking_id ;
		//echo $sql;
        return $this->db->query($sql);

        //return $this->db->fetchAll(PDO::FETCH_ASSOC) ;
    }
	
	
	//functions to execute processes
	
	function ReleaseCanceledBookings()
	{
		$debug = $this->debug;
		$data = $this->dataToReleaseCanceledBookings(); 
		
		foreach($data as $d)
		{
			$cancelid =  $d["id"];
			$bookid =  $d["booking_id"];
			$bookslot =  $d["booking_date"] . " " . $d["booking_time"];
			$booklocator =  $d["locator"];

			echo "<br>Cancelando reservacion " .  $bookid . " - cancelID " . $cancelid  . " - " . $booklocator  . " @ " . $bookslot .  "<br>";
			
			$sSQL = "UPDATE cancel_requests SET STATUS='Terminado' , updated_at = NOW() WHERE id=" . $cancelid;
			if ($debug ==1)
			{
				echo $sSQL . "<br>";	
			}	
			else
			{
				$this->db->query($sSQL); 	
			}
			
			
			$sSQL = "UPDATE bookings SET STATUS='Cancelado' , updated_at = NOW() WHERE id=" . $bookid;

			if ($debug ==1)
			{
				echo $sSQL . "<br>";	
			}	
			else
			{
				$this->db->query($sSQL); 	
			}
			
			//$sSQL = "UPDATE bookings set status = \"Expirado\" WHERE id= " . $bookid;
		}
	}


	

	public function CalcularParticipantesNoConfirmados($bookid)
	{
		$data = $this->dataToCalcularParticipantesNoConfirmados($bookid); 
		$participantes = "";
		foreach($data as $d)
		{
			$str_arr = explode (";", $d["player"]);  
			$playername = $str_arr["0"];
			$phone = $str_arr["1"];
			$email = $str_arr["2"];			
			
			$participantes =  $participantes . "<br>" .  $d["doc_id"] . " - " .  $playername;
		}
		return $participantes;
	}
	
	public function CalcularParticipantesConfirmados($bookid)
	{
		$data = $this->dataToCalcularParticipantesConfirmados($bookid); 
		$total = 0;
		foreach($data as $d)
		{
			$total =  $d["cantidad"];
		}
		return $total;
	}
		
	
	
	
	
	function ReminderBookings($purge)
	{
		$debug = $this->debug;
		$data = $this->dataToPurgeBookings(); 
		
		foreach($data as $d)
		{
			$bookid =  $d["id"];
			$player =  $d["player"];
			$confirmed =  $d["confirmed"];
			
			$bookslot =  $d["booking_date"] . " " . $d["booking_time"];
			$booklocator =  $d["locator"];

			echo "<br>Reservacion " .  $bookid . " @ " . $bookslot .  " - " .  $player .    "<br>";

			if ($confirmed ==0)
			{
				//$count = 2;

				$count = $this->CalcularParticipantesConfirmados($bookid);
				$participantes = $this->CalcularParticipantesNoConfirmados($bookid);			

				if ($debug ==1)
				{
					if ($count <= 2) {$color='FF0000';} else {$color='0000FF';} 
					
					echo  "<strong>CalcularParticipantesConfirmados: </strong> <font color='" . $color . "'>" . $count . "</font><br>";
				}
				
				if ($count <= 2)
				{
					if ($purge==1)
					{
						echo "expirar y liberar reservacion <br>";
						
						$mensaje = "";	   
						$mensajeSMS = "";	   
						$count = 0;
						
						$bookid =  $d["id"];
						$booking_date =  $d["booking_date"];
						$booking_time =  $d["booking_time"];
						$locator =  $d["locator"];
						$package =  $d["paquete"];
						$token =  $d["token"];
					   
						$str_arr = explode (";", $d["Mainplayer"]);  
						$playername = $str_arr["0"];
						$phone = $str_arr["1"];
						$email = $str_arr["2"];

						/*
						$mybooking_date =  $d["booking_date"];
						date_default_timezone_set('America/Caracas');
						$today = date('d-m-Y', time());
						echo  $mybooking_date . " / " . $today . "<br>";
						*/
						
						//expirar y liberar reservacion
						//$sSQL = "UPDATE bookings SET STATUS='Terminado' , updated_at = NOW() WHERE id=" . $bookid;

						$sSQL = "UPDATE bookings SET STATUS='Cancelado' , booking_address='EXPIRADO AUTOMATICO POR FALTA DE CONFIRMACION' , updated_at = NOW() WHERE id=" . $bookid;
						//echo $sSQL . "<br>";
						//$this->db->query($sSQL); 
						if ($debug ==1)
						{
							echo $sSQL . "<br>";	
						}	
						else
						{
							$this->db->query($sSQL); 	
						}
						
						
						if ($mensaje == "")
						{
							$mensaje =  $mensaje . "<br>Estimado(a) " . $playername . "<br><br> Su reserva de la partida de golf el dia <b>" . $booking_date . " " . $booking_time . "</b>";
							$mensaje =  $mensaje . " fue <font  color='FF0000'><strong> CANCELADA</strong> </font> debido a que no confirmaron el minimo de participantes " . $participantes ;
							
							$mensaje =  $mensaje . "<br><br>" .  "<strong>Localizador: </strong> <font color='0000FF'>" . $locator . "</font><br>";
							/*
						   $mensaje =  $mensaje . "<br>" .  "Reservacion ID: " . $bookid;
						   $mensaje =  $mensaje . "<br>" .  "Paquete: " . $package;
						   $mensaje =  $mensaje . "<br>" .  "Fecha: " . $booking_date;
						   $mensaje =  $mensaje . "<br>" .  "Hora: " . $booking_time;
						   */
						   
						   $mensajeSMS = "Reservacion LCC " . $booking_date . " " . $booking_time . " cancelada por falta de confirmaciones";
			
							$titulo = "LCC - Reservacion cancelada por falta de confirmacion  " . $booking_date . " " . $booking_time ;

							if ($debug ==1)
							{
								echo $email . " - " . $titulo . " <br>" .  $mensaje . "<br>";	
								echo $phone . " - " . $mensajeSMS . "<br>";	
							}	
							else
							{
								$email = 'laraneo@gmail.com';
								$this->sendEmails($email, $titulo, $mensaje);
								$this->sendSMS($phone, $mensajeSMS);
							}
						}						
					}
					else
					{
						echo "enviar notificacion por email<br>";
						//enviar notificacion por email
						echo "Enviando email" . "<br>";

						$mensaje = "";	   
						$mensajeSMS = "";	   
						$count = 0;
					   
					   
						$bookid =  $d["id"];
					   $booking_date =  $d["booking_date"];
					   $booking_time =  $d["booking_time"];
					   $locator =  $d["locator"];
					   $package =  $d["paquete"];
					   $token =  $d["token"];
					   
					   
						$str_arr = explode (";", $d["player"]);  
						$playername = $str_arr["0"];
						$phone = $str_arr["1"];
						$email = $str_arr["2"];
						
						
						if ($mensaje == "")
						{
							$mensaje =  $mensaje . "<br>Estimado(a) " . $playername . "<br><br> Recuerde que debe confirmar su participacion en la partida de golf el dia <b>" . $booking_date . " " . $booking_time . "</b>";
							$mensaje =  $mensaje . "<br>" .  "<strong>Localizador: </strong> <font color='0000FF'>" . $locator . "</font><br>";
							/*
						   $mensaje =  $mensaje . "<br>" .  "Reservacion ID: " . $bookid;
						   $mensaje =  $mensaje . "<br>" .  "Paquete: " . $package;
						   $mensaje =  $mensaje . "<br>" .  "Fecha: " . $booking_date;
						   $mensaje =  $mensaje . "<br>" .  "Hora: " . $booking_time;
						   */
						   
						   
						   $mensajeSMS = "Reservacion LCC " . $booking_date . " " . $booking_time . " Recuerde confirmar a tiempo por email";
			
						}
						
					   
					   if ($d["confirmed"]==0)
					   {
						   //$mensaje = $mensaje . "<br>"  . $playername . " - " . "<font color=\"ff0000\"> Sin Confirmar</font>";
						   //$mensaje = $mensaje . "<br>"  .   $token;
							//$mensaje = $mensaje . "<br>" . "<a target='_blank' href='http://45.230.168.18:8081/reservaciones/custom/confirmPlayer.php?token=" . $token . "'>Confirmar Participacion</a>";
							//echo '$appbaselink' . $this->$appbaselink . "<br>";
							$mensaje = $mensaje . "<br>" . "<a target='_blank' href='" . $this->appbaselink . "=" . $token . "'>Confirmar Participacion</a>";
							
							//$mensaje = $mensaje . "<br>" .	"<button onclick='window.location.href = '  http://45.230.168.18:8081/reservaciones/custom/confirmPlayer.php?token=" . $token . "'> Confirmar Participacion </button> ";						   
						   
						   
						   //$mensaje = $mensaje . "<br>"  . $d["player"];
						   //$emails_array= $emails_array .  ";" $email;
						   //$phones_array= $phones_array .  ";" $phone;
						   
						   //echo $mensaje . "<br>";
						   
						   $titulo = "LCC - Recordatorio confirmacion partida Golf " . $booking_date . " " . $booking_time ;

							if ($debug ==1)
							{
								echo $email . " - " . $titulo . " <br>" .  $mensaje . "<br>";	
								echo $phone . " - " . $mensajeSMS . "<br>";	
							}	
							else
							{
								$email = 'laraneo@gmail.com';
								$this->sendEmails($email, $titulo, $mensaje);
								$this->sendSMS($phone, $mensajeSMS);
							}
						   
					   }
					   else  //confirmed
					   {
						   /*
						   $mensaje = $mensaje . "<br>"  . $playername . " - " . "<>font color=\"00ff00\" Confirmado</font>";
						   $emails_array= $emails_array .  ";" $email;
						   $phones_array= $phones_array .  ";" $phone;
						   */
						   //$count = $count . 1;
					   }
					$mensaje = "";
					$mensajeSMS = "";
						
						
					}
				}
				
			}

		}
		
	}
	
	
	
	/*
	function dataToSendEmails(){
      $sql = "SELECT  * FROM Notificaciones WHERE nStatus=0 AND nTipo=2";
        return $this->db->query($sql);
    }

    function buildHTMLMessageElastic(){

        return buildHTMLMessage();
    }


    function buildHTMLMessage(){
        ob_start();
        $data = $this->dataToSendEmails(); 
        include(dirname(__DIR__)."/views/htmlMail.php");
        $pngString = ob_get_contents();
        ob_end_clean();
        return $pngString;
    }
	*/
	
    function sendEmails($para, $titulo, $mensaje)
	{
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'From: Reservaciones LCC <reservaciones.izcaraguacc@gmail.com>' . "\r\n" ;
		//$cabeceras .= 'From: Tickets Abiertos <webmaster@avaytec.com>' . "\r\n" . "CC: nortiz@avaytec.com";
		$date = date('m/d/Y h:i:s a', time());
		
		//echo date('m/d/Y h:i:s a', time()) . "<br>";
		//echo $titulo . " - " . $para . " - " . $mensaje . "<br>";
		
		$status = mail($para, $titulo, $mensaje, $cabeceras);
        
		return $status;
    }

    function sendEmailElastic($para, $titulo, $mensaje)
	{
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'From: Reservaciones LCC <reservaciones.izcaraguacc@gmail.com>' . "\r\n" ;
		//$cabeceras .= 'From: Tickets Abiertos <webmaster@avaytec.com>' . "\r\n" . "CC: nortiz@avaytec.com";
		$date = date('m/d/Y h:i:s a', time());
		
		//echo date('m/d/Y h:i:s a', time()) . "<br>";
		//echo $titulo . " - " . $para . " - "  . $mensaje . "<br>";
		
		//$mensaje = $this->buildHTMLMessage();
		$status =   sendElastic($para, $titulo, $mensaje, $cabeceras);
        
		return $status;
    }
	
	function sendElastic($para, $titulo, $mensaje, $cabeceras)
	{
		return  mail($para, $titulo, $mensaje, $cabeceras);
	}
	
	
	
	function sendSMS($phone, $mensajeSMS)
	{
		
	}
	
}


new Play();