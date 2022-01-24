<?php
include_once ('db/dbConn.php');
$dbConnX=new dbConn();

session_start();		//Start new or resume existing session...

if(!isset($_SESSION['login_user'])){
	$dbConnX->closeConnX(); // Closing Connection
	header('location: logout.php'); 
}

// get user from session var...
$login_session=$_SESSION['login_user'];
$user_id_session=$_SESSION['user_id'];

if(!isset($login_session)){
	$dbConnX->closeConnX(); // Closing Connection
	header('location: logout.php'); 
}
?>
