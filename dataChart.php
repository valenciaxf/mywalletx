<?php
require_once('session.php');
?>
<?php
//setting header to json...
header('Content-Type: application/json');

$axStartDate = $_POST["key1"];
$axEndDate = $_POST["key2"];

//get connection...
require_once ('db/dbConn.php');
$dbConnX=new dbConn();

$res = $dbConnX->getDataChart($axStartDate,$axEndDate,$user_id_session);

//loop through the returned data...
$data = array();
foreach ($res as $row) {
	$data[] = $row;
}

//free memory associated with result...
$res->close();

//now print the data
print json_encode($data);