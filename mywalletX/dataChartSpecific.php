<?php
require_once('session.php');
?>
<?php
//setting header to json
header('Content-Type: application/json');

$axStartDate = $_POST["key1"];
$axEndDate = $_POST["key2"];
$axCategory = $_POST["key3"];


//get connection
require_once ('db/dbConn.php');
$dbConnX=new dbConn();

//query to get data from the table
$res = $dbConnX->getDataChartSingleCat($axStartDate,$axEndDate,$axCategory,$user_id_session);

if (FALSE === $res) die("Select detail failed: ".mysqli_error);

//loop through the returned data
$data = array();
foreach ($res as $row) {
	$data[] = $row;
}

//free memory associated with result
$res->close();

//now print the data
print json_encode($data);
