<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

</head>

<body>
<pre>

	<?php $phones_array = ""; ?>
	<?php $emails_array = ""; ?>

	<?php echo "Recuerden deben al menos 3 participantes haber confirmado sino" + "<br>"; ?>
	<?php echo $d["package_id"] + "<br>"; ?>
	<?php echo $d["booking_date"] + " - " + $d["booking_date"] + " - " + $d["locator"]  + "<br>";  ?>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <td>Rol</td>
                <td>Accion</td>
                <td>Jugador</td>
				<td>Email</td>
				<td>Telefono</td>
                <td>Confirmado</td>
                <td>Fecha</td>
            </tr>
        </thead>
		
        <tbody>
            <?php foreach($data as $d):?>
                <tr>
                    <td><?php echo $d["rol"]?></td>
                    <td><?php echo $d["group_id"]?></td>
                    <td><?php

					$string = $d["player"]; 
					$str_arr = explode (",", $string);  
					//print_r($str_arr); 
					
					//echo $d["player"]
					echo $str_arr["0"];
					
					?></td>

					<td><?php echo $str_arr["1"];?></td>					
					<td><?php echo $str_arr["2"];?></td>					


					<?php $phones_array = $str_arr["1"] + ";" + $phones_array ; ?>
					<?php $emails_array = $str_arr["2"] + ";" + $emails_array ; ?>
					
					
                    <td><?php 
							if ($d["confirmed"]==1)
							{
								echo "<font color=\"00ff00\">Confirmado</font>";
							}
							else
							{
								echo "<b><font color=\"ff0000\">Sin Confirmar</font></b>";
							}
						?>
					
					</td>
                    <td><?php echo $d["confirmed_at"]?></td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</pre>
</body>
</html>