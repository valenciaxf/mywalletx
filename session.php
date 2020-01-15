<?php
include_once ('db/dbConn.php');
$dbConnX=new dbConn();

session_start();		//Start new or resume existing session...

if(!isset($_SESSION['login_user'])){
	$dbConnX->closeConnX(); // Closing Connection
	header('location: logout.php'); 
}

// get user from session var...
$currentUser=$_SESSION['login_user'];

// fetch information...
$sesSql=$dbConnX->getAuthUser($currentUser);

$rowAuthUser = mysqli_fetch_assoc($sesSql);
$login_session=$rowAuthUser['username'];

if(!isset($login_session)){
	$dbConnX->closeConnX(); // Closing Connection
	header('location: logout.php'); 
}
?>

