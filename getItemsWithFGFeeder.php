<?php
require_once('session.php');
?>
<?php

include_once ('db/dbConn.php');
$dbConnX=new dbConn();

$mydate1 = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";

$mydate2 = isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";

// verificamos si se ha enviado
// alguna variable via GET
if(isset($_GET['cat_ID']) && isset($_GET['cat_name'])){
    // asignamos los valores
    // a las variables que usaremos
    $cat_ID = $_GET['cat_ID'];
    $category = $_GET['cat_name'];
	$whereFilter2 = " AND ite_category = '$cat_ID'";
}else{
	$category = "There is not category selected...";
	$whereFilter2 = "";
}


if(isset($mydate1) && $mydate2){
	$whereFilterDates = " and ite_date >= '$mydate1' AND  ite_date <= '$mydate2'";
}else{
	$whereFilterDates = "";
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'cat_name';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
$query = isset($_POST['query']) ? $_POST['query'] : false;							//se deshabilitó para evitar LIKE...
$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false;

//Set equivalence for qtype for protect real column name...
if ($qtype="Comment") $qtype="ite_comment";

$tables = "item, category";
$where = " WHERE ite_category=cat_ID $whereFilterDates $whereFilter2";

$result = $dbConnX->getDataFG($sortname,$sortorder,$whereFilterDates,$whereFilter2,$qtype,$mydate1,$mydate2,$tables,$where,$page,$rp,$query);

$total = $dbConnX->countRec($tables,$where);

$sqlSumINTotal = $dbConnX->getSumINTotal($tables,$whereFilterDates,$whereFilter2,$qtype,$query,$mydate1,$mydate2,'IN');
$sqlSumOUTTotal = $dbConnX->getSumINTotal($tables,$whereFilterDates,$whereFilter2,$qtype,$query,$mydate1,$mydate2,'OUT');

header("Content-type: application/json");
$jsonData = array('page'=>$page,'total'=>$total,'sqlSumINTotal'=>$sqlSumINTotal,'sqlSumOUTTotal'=>$sqlSumOUTTotal,'rows'=>array());

$rows=$result;
foreach($rows AS $row){
        //If cell's elements have named keys, they must match column names
        //Only cell's with named keys and matching columns are order independent.
        $entry = array('id'=>$row['ite_ID'],
                'cell'=>array(
                        'cat_name'=>$row['cat_name'],
                        'ite_totalAmount'=>$row['ite_totalAmount'],
                        'ite_quantity'=>$row['ite_quantity'],
                        'ite_date'=>$row['ite_date'],
						'ite_comment'=>$row['ite_comment']
                ),
        );
        $jsonData['rows'][] = $entry;
}
echo json_encode($jsonData);

?>
