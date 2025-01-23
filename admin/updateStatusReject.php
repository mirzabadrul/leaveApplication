<?php
session_start();
include("config.php");

$conn = mysqli_connect($servername, $username, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(!isset($_SESSION["email"])){
	header("Location: login.php");
  }
else{

	$email = $_GET['email'];
	$reason = $_GET['reason'];

	$add_to_db = mysqli_query($conn,"UPDATE employee_leaves SET status='Rejected' WHERE email='".$email."' AND reason='".$reason."'");
		
				if($add_to_db){	
					echo "Saved!!";
					header("Location: applicant.php");
				}
				else{
					echo "Query Error : " . "UPDATE employee_leaves SET status='Rejected' WHERE email='".$email."' AND reason='".$reason."'" . "<br>" . mysqli_error($conn);
				}
		}

	ini_set('display_errors', true);
	error_reporting(E_ALL);  
			
?>

