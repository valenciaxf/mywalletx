<?php
include_once ('db/dbConn.php');
$dbConnX=new dbConn();

session_start(); // Starting Session
$error=''; // Variable To Store Error Message

if (isset($_POST['submit'])) {
if (empty($_POST['username']) || empty($_POST['password'])) {
$error = "Usuario o Password inválido";
}
else
{
	// Define $username and $password
	$username=$_POST['username'];
	$password=$_POST['password'];

	$authUser = $dbConnX->authUser($username, $password);
	$userRow = mysqli_num_rows($authUser);

	//if (($userRow == 1) && ($isActive == 1) ) {
	if ($userRow == 1) {

		$rowAuthUser = mysqli_fetch_assoc($authUser);

		$_SESSION['login_user']=$rowAuthUser['username']; // init session...
		$_SESSION['user_id']=$rowAuthUser['user_id']; // init session...

		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
								$isActive = $dbConnX->checkPassport($_SESSION['user_id']);
						//echo $isActive;
								if ($isActive == 1) {
										//$dbConnX->auditLogon ($_SESSION['user_id'],$_SESSION['login_user'],0);
										header("location: myWalletX.php"); // redirecting to home page...

								} else {
										//$dbConnX->auditLogon ($_SESSION['user_id'],$_SESSION['login_user'],2);
										$error = "Cuenta expirada o inactiva... Actualiza tu registro.";
								}
			} catch (mysqli_sql_exception  $e) {
					              echo "<div class='alert alert-danger' role='alert'>
					              <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					              <strong>Ha ocurrido una excepción, favor de reportar el evento, para continuar presione el icono de Home...</strong>
					              </div>";
			}

	} else {
		//$dbConnX->auditLogon ('0',$_POST['username'],3);
		$error = "Usuario o Password inválido";
	}
		$dbConnX->closeConnX(); // Closing Connection
}
}

/*  insert into login_mwx (username, password) values ('xf', '222fee2bba344cc330967ec898eedd15d5caf2d9dad2976f5edc2019b6ac546619c5711a7fc4c44b78b9f66a185419cab2daff5f4c875f9515d405ab13ee4991');   */
/*  insert into login_mwx (username, password) values ('test', '9ff61e7eacec9337ef43eaaddc2006309252467955609b3546d258cb39a03b2ae7eb71afbc16b21a364f71e6b97f61e8565798ece982178c5b8b954480c01cbe');   */
#echo hash('sha512',"passPass32#.");
//echo hash('sha512',"testingtesting92.");
//insert into passport_mwx (start_date,end_date,active,user_id) values ('2020-02-07','2020-02-07',1,2);
?>
