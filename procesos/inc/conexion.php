<?php  

$servername = "10.0.0.17";
$username = "partnerLCC";
$password = "luca123456***";
$dbname = "partnersBookings";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 