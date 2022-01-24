<?php
require_once('session.php');
?>
<?php
require_once('datePicker/calendar/calendar/classes/tc_calendar.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>...</title>

<link href="datePicker/calendar/calendar/calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="datePicker/calendar/calendar/calendar.js"></script>

<style type="text/css">
body { font-size: 11px; font-family: "verdana"; }

pre { font-family: "verdana"; font-size: 10px; background-color: #FFFFCC; padding: 5px 5px 5px 5px; }
pre .comment { color: #008000; }
pre .builtin { color:#FF0000;  }
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">


<!--	  <form id="calendarform" name="calendarform" method="post" action="datePicker/calendar/calendar/calendar_form.php"> -->
<form id="calendarform" name="calendarform" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
              <p class="largetxt"><b>From / To </b></p>
              <div style="float: left;">
                <div style="float: left; padding-right: 3px; line-height: 18px;">from:</div>
                <div style="float: left;">
                  <?php
				  $startYearCal=date("Y")-50;
				  $endYearCal=date("Y")+50;
				  
						$thisweek = date('W');
						$thisyear = date('Y');

						$dayTimes = getDaysInWeek($thisweek, $thisyear);
						//----------------------------------------

						$date1 = date('Y-m-d', $dayTimes[0]);
						$date2 = date('Y-m-d', $dayTimes[(sizeof($dayTimes)-1)]);

						function getDaysInWeek ($weekNumber, $year, $dayStart = 1) {
						  // Count from '0104' because January 4th is always in week 1
						  // (according to ISO 8601).
						  $time = strtotime($year . '0104 +' . ($weekNumber - 1).' weeks');
						  // Get the time of the first day of the week
						  $dayTime = strtotime('-' . (date('w', $time) - $dayStart) . ' days', $time);
						  // Get the times of days 0 -> 6
						  $dayTimes = array ();
						  for ($i = 0; $i < 7; ++$i) {
							$dayTimes[] = strtotime('+' . $i . ' days', $dayTime);
						  }
						  // Return timestamps for mon-sun.
						  return $dayTimes;
						}


					  $myCalendar = new tc_calendar("date1", true, false);
					  $myCalendar->setIcon("datePicker/calendar/calendar/images/iconCalendar.gif");
					  $myCalendar->setDate(date('d', strtotime($date1)), date('m', strtotime($date1)), date('Y', strtotime($date1)));
					  $myCalendar->setPath("datePicker/calendar/calendar/");
					  $myCalendar->setYearInterval($startYearCal, $endYearCal);
					  //$myCalendar->dateAllow('2009-02-20', "", false);
					  $myCalendar->setAlignment('left', 'bottom');
					  $myCalendar->setDatePair('date1', 'date2', $date2);
					  //$myCalendar->setSpecificDate(array("2011-04-01", "2011-04-04", "2011-12-25"), 0, 'year');
					  $myCalendar->writeScript();
					  ?>
                </div>
              </div>
              <div style="float: left;">
                <div style="float: left; padding-left: 3px; padding-right: 3px; line-height: 18px;">to</div>
                <div style="float: left;">
                  <?php
					  $myCalendar = new tc_calendar("date2", true, false);
					  $myCalendar->setIcon("datePicker/calendar/calendar/images/iconCalendar.gif");
					  $myCalendar->setDate(date('d', strtotime($date2)), date('m', strtotime($date2)), date('Y', strtotime($date2)));
					  $myCalendar->setPath("datePicker/calendar/calendar/");
					  $myCalendar->setYearInterval($startYearCal, $endYearCal);
					  //$myCalendar->dateAllow("", '2009-11-03', false);
					  $myCalendar->setAlignment('left', 'bottom');
					  $myCalendar->setDatePair('date1', 'date2', $date1);
					  //$myCalendar->setSpecificDate(array("2011-04-01", "2011-04-04", "2011-12-25"), 0, 'year');
					  $myCalendar->writeScript();
					  
					  ?>
                </div>
              </div>

				<p>
				<input type="submit" name="Submit1" value="Submit" />
				</p>
			  
            </form>


<?php
include_once ('dbConn.php');
$connX=connFncConnX();

$whereFilter = "";
$whereFilterSUM = "";


$mydate1 = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";

if ($mydate1!="") echo("Data From: ".$mydate1);
echo "<br>";

$mydate2 = isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";

if ($mydate2!="") echo(" To : ".$mydate2);

	if(($mydate1!="") && ($mydate2!="")){
		
		$whereFilter = $whereFilter."WHERE ite_date >= '$mydate1' AND  ite_date <= '$mydate2'";
		//echo $whereFilter;
		$whereFilterSUM="AND ite_date >= '$mydate1' AND  ite_date <= '$mydate2'";
		
	}

// verificamos si se ha enviado
// alguna variable via GET


if(isset($_GET['cat_ID']) && $_GET['cat_name']){
    // asignamos los valores
    // a las variables que usaremos
    $cat_ID = $_GET['cat_ID'];
    $category = $_GET['cat_name'];
    //$whereFilter = "WHERE ite_category = '$cat_ID'";
	$whereFilter = " AND ite_category = '$cat_ID'";


    $titulo = "Items from category: $category";
}else{
    // de lo contrario
    // el titulo sera general
	$category = "There is not category selected...";
    $titulo = "All Items...";
}
// get Data...
$sqlQueryItem = mysqli_query($connX, "SELECT ite_totalAmount, ite_quantity, ite_date, ite_comment FROM item $whereFilter order by ite_category, ite_date")
                            or die(mysqli_error($connX));
echo "<h1>$titulo</h1>";
while($rowCat = mysqli_fetch_array($sqlQueryItem)){
    echo "Total Amount: <h1>$ $rowCat[ite_totalAmount]</h1>";
    echo "Quantity: $rowCat[ite_quantity] <br>";
    echo "Date: $rowCat[ite_date] <br>";
    echo "Comment: $rowCat[ite_comment] <br><hr><br>";
}	

if ($whereFilter != "") {
$sqlQueryItem = mysqli_query($connX, "SELECT IFNULL(sum(ite_totalAmount), 0) as SumTotalAmounts FROM item $whereFilter")
                            or die(mysqli_error($connX));
$rowCat = mysqli_fetch_assoc($sqlQueryItem); 
echo "<h1><br><br><hr>SUM Total Amount ($category): $ $rowCat[SumTotalAmounts]<br><hr></h1>";
}

if ($whereFilter != "") {
}


$sumIN="SELECT sum(IFNULL(ite_totalAmount, 0)) as SumTotalAmountsIn FROM item, category WHERE ite_category=cat_ID AND cat_type='IN' $whereFilterSUM";
$sumOUT="SELECT sum(IFNULL(ite_totalAmount, 0)) as SumTotalAmountsOut FROM item, category WHERE ite_category=cat_ID AND cat_type='OUT' $whereFilterSUM";
$sumBalance="SELECT SumTotalAmountsIn-SumTotalAmountsOut as SumBalance FROM ($sumIN) inAX, ($sumOUT) outAX";

$sqlQueryItem = mysqli_query($connX, $sumIN)
                            or die(mysqli_error($connX));
$rowCat = mysqli_fetch_assoc($sqlQueryItem); 
echo "<h1><br><br><hr>SUM Total Amount (IN): $ $rowCat[SumTotalAmountsIn]<br>";

$sqlQueryItem = mysqli_query($connX, $sumOUT)
                            or die(mysqli_error($connX));
$rowCat = mysqli_fetch_assoc($sqlQueryItem); 
echo "SUM Total Amount (OUT): $ $rowCat[SumTotalAmountsOut]<br><hr></h1>";


$sqlQueryItem = mysqli_query($connX, $sumBalance)
                            or die(mysqli_error($connX));
$rowCat = mysqli_fetch_assoc($sqlQueryItem); 
echo "Balance: $ $rowCat[SumBalance]<br><hr></h1>";

?>

<hr>
  
</body>
</html>
