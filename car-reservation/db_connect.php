<?php
date_default_timezone_set('America/Mexico_City');

/*define('DB_SERVER','sql10.freemysqlhosting.net');
define('DB_PASS' ,'ElcnAy3tu7');
define('DB_USER','sql10390676');
define('DB_NAME', 'sql10390676');
*/

$host = "sql10.freemysqlhosting.net";
$user = "sql10390676";
$password = "ElcnAy3tu7";
$dbname = "sql10390676";
/*

$host = "localhost";
$user = "root";
$password = "";
$dbname = "cars";*/

$con = mysqli_connect($host, $user,$password,$dbname);

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>

