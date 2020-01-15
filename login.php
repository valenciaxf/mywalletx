<?php
include_once ('db/dbConn.php');
$dbConnX=new dbConn();

session_start(); // Starting Session
$error=''; // Variable To Store Error Message

if (isset($_POST['submit'])) {
if (empty($_POST['username']) || empty($_POST['password'])) {
$error = "Username or Password is invalid";
}
else
{
	// Define $username and $password
	$username=$_POST['username'];
	$password=$_POST['password'];

	$authUser = $dbConnX->authUser($username, $password);
	$userRow=mysqli_num_rows($authUser);

	if ($userRow == 1) {
		$_SESSION['login_user']=$username; // init session...
		header("location: myWalletX.php"); // redirecting to home page...
	} else {
		$error = "Username or Password is invalid";
	}
		$dbConnX->closeConnX(); // Closing Connection
}
}

/*  insert into login_mwx (username, password) values ('xf', '222fee2bba344cc330967ec898eedd15d5caf2d9dad2976f5edc2019b6ac546619c5711a7fc4c44b78b9f66a185419cab2daff5f4c875f9515d405ab13ee4991');   */	
#	echo crypt("passPass32#.");
 #echo password_hash("passPass32#.", PASSWORD_DEFAULT);
#echo hash('sha512',"passPass32#.");
?>
