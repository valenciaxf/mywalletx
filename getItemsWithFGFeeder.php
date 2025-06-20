<?php
require_once('session.php');
?>
<?php

include_once('db/dbConn.php');
$dbConnX = new dbConn();

$mydate1 = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
$mydate2 = isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";

// verificamos si se ha enviado
// alguna variable via GET
if (isset($_GET['cat_ID']) && isset($_GET['cat_name'])) {
    $cat_ID = $dbConnX->cleanInput($_GET['cat_ID']);
    //$category = $dbConnX->cleanInput($_GET['cat_name']);
    $whereIteCategory = " AND ite_category = '$cat_ID'";
} else {
    $category = "There is not category selected...";
    $whereIteCategory = "";
}

if (isset($mydate1) && $mydate2) {
    $whereFilterDates = " and ite_date >= '$mydate1' AND  ite_date <= '$mydate2'";
} else {
    $whereFilterDates = "";
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$page = isset($_POST['page']) ? $_POST['page'] : 1;
$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'ite_date';
$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
$query = isset($_POST['query']) ? $_POST['query'] : false;   //se deshabilitó en flexigrid para evitar LIKE...
$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false;

//Set equivalence for qtype for protect real column name...
if ($qtype = "Descripción") {
    $qtype = "ite_comment";
}

$result = $dbConnX->getDataFG($sortname, $sortorder, $whereFilterDates, $whereIteCategory, $qtype, $mydate1, $mydate2, $page, $rp, $query, $user_id_session);

$total = $dbConnX->countRec($whereFilterDates, $whereIteCategory, $user_id_session);

$sqlSumINTotal = $dbConnX->getSumInOrOutTotal($whereFilterDates, $whereIteCategory, $qtype, $query, $mydate1, $mydate2, 'IN', $user_id_session);
$sqlSumOUTTotal = $dbConnX->getSumInOrOutTotal($whereFilterDates, $whereIteCategory, $qtype, $query, $mydate1, $mydate2, 'OUT', $user_id_session);

header("Content-type: application/json");
$jsonData = array(
    'page' => $page,
    'total' => $total,
    'sqlSumINTotal' => $sqlSumINTotal,
    'sqlSumOUTTotal' => $sqlSumOUTTotal,
    'rows' => array()
);

$rows = $result;
foreach ($rows as $row) {
    //If cell's elements have named keys, they must match column names
    //Only cell's with named keys and matching columns are order independent.
    $entry = array(
        'id' => $row['ite_ID'],
        'cell' => array(
            'cat_name' => $row['cat_name'],
            'ite_totalAmount' => $row['ite_totalAmount'],
            'ite_quantity' => $row['ite_quantity'],
            'ite_date' => $row['ite_date'],
            'ite_comment' => $row['ite_comment']
        ),
    );
    $jsonData['rows'][] = $entry;
}
echo json_encode($jsonData);

?>