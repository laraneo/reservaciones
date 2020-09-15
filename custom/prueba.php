<?php

			 $servername = '10.0.0.17';
			 $username=  'partnerLCC';
			 $password = 'luca123456***';
             $database = 'partnersBookings';
             
             $connectionInfo = array( 
                "Database"=> $database,
                "UID"=> $username, 
                "PWD"=> $password
                );
				
//$serverName = "serverName\instanceName";
//$connectionInfo = array( "Database"=>"dbName", "UID"=>"username", "PWD"=>"password");

$conn = sqlsrv_connect( $servername, $connectionInfo );
if( $conn === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$sql = "select opening_time, closing_time from booking_times_packages WHERE package_id=2 AND number=4";
$sql = "SELECT e.time1 as opening_time, e.time2 as closing_time from events e , draws d where e.id=d.event_id and d.id = 17";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
/*      echo $row['opening_time']."<br />";
	  echo $row['closing_time']."<br />";
*/
	  echo date_format($row["opening_time"], 'h:i A')."<br />";
	  echo  date_format($row["closing_time"], 'h:i A')."<br />";
  
}


sqlsrv_free_stmt( $stmt);
?>