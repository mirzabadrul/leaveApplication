<?php
$servername="localhost";
$username="root";
$password="";
$database="leaveApplication";
$port = 3306;

$conn = mysqli_connect($servername, $username, $password, $database, $port);

// Check the connection
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

?>