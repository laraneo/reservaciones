<?php 

// -1: Error de conexion
function wsConsultaSaldo($group_id)
{
	if ($group_id=='1206-10')
	{
		$balance = 0;
	}
	else
	{
		$balance = 222;	
	}
	
	return $balance;
}

//-1: Error de conexion
function wsConsultarBlackList($doc_id, $comments)
{
	//$comments = '';
	$retval = 0;
	if ($doc_id=='10000033')
	{
		$comments = 'Blacklist bloqueado prueba';
		$retval = 1;
	}
	else
	{
		$comments = '';
		$retval = 0;
	}
	
	return $retval;
}


// -1: Error de conexion
function wsConsultaSocio($doc_id, $name)
{
	$retval = 0;
	$result = "";
	if ($doc_id=='5533254')
	{
		$name = "Socio No registrado Stub";
		$retval = 0;
	}
	else
	{
		$name = "Socio registrado Stub";
		$retval = 1;	
	}
	
	return $retval;
}

// -1: Error de conexion
function wsConsultaInvitado($doc_id, $name)
{
	$retval = 0;
	$result = "";
	if ($doc_id=='12422099')
	{
		$name = "Invitado No registrado Stub";
		$retval = 0;
	}
	else
	{
		$name = "Invitado registrado Stub";
		$retval = 1;	
	}
	
	return $retval;
}




?>