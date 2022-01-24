<?php
require_once('datePicker/calendar/calendar/classes/tc_calendar.php');
require_once('session.php');
include_once ('db/dbConn.php');
$dbConnX=new dbConn();
?>
<?php
if(array_key_exists('Submit1', $_POST)) {
$mydate1 = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
$mydate2 = isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";
$filename = 'csvReport.csv';

    $result = $dbConnX->fetchData2PdfAndCsv($mydate1,$mydate2,$user_id_session);
    $user_arr = array();
    while($row = mysqli_fetch_array($result)){
		  $cat_name = iconv('UTF-8', 'windows-1252',$row['cat_name']);;
		  $ite_totalAmount = $row['ite_totalAmount'];
		  $ite_quantity = $row['ite_quantity'];
		  $ite_date = $row['ite_date'];
		  $ite_comment = iconv('UTF-8', 'windows-1252',$row['ite_comment']);
		  $user_arr[] = array($cat_name,$ite_totalAmount,$ite_quantity,$ite_date,$ite_comment);
    }

// file creation
$file = fopen($filename,"w");

$headerRows=array("CATEGORIA","MONTO","CANTIDAD","FECHA","DESCRIPCION");
fputcsv($file, $headerRows);

foreach ($user_arr as $line){
 fputcsv($file,$line);
}

fclose($file);

// download
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=".$filename);
header("Content-Type: application/csv; ");

readfile($filename);

// deleting file
unlink($filename);
exit();

}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/styleLog2.css">
  <link rel="stylesheet" type="text/css" href="css/home.css">


<title>Reporte CSV</title>

<link href="datePicker/calendar/calendar/calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="datePicker/calendar/calendar/calendar.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php
  include("homeAndExit.php");
?>
<!--	  <form id="calendarform" name="calendarform" method="post" action="datePicker/calendar/calendar/calendar_form.php"> -->
<form id="sform" name="calendarform" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
              <p class="largetxt"><b>Select dates:</b></p>
              <div style="float: left;"><br><br>
                <div style="float: left; padding-right: 3px; line-height: 18px;">Desde:</div>
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
					  $myCalendar->setAlignment('left', 'bottom');
					  $myCalendar->setDatePair('date1', 'date2', $date2);
					  $myCalendar->writeScript();
					  ?>
                </div>
              </div>
              <div style="float: left;"><br><br>
                <div style="float: left; padding-left: 3px; padding-right: 3px; line-height: 18px;">Hasta:</div>
                <div style="float: left;">
                  <?php
					  $myCalendar = new tc_calendar("date2", true, false);
					  $myCalendar->setIcon("datePicker/calendar/calendar/images/iconCalendar.gif");
					  $myCalendar->setDate(date('d', strtotime($date2)), date('m', strtotime($date2)), date('Y', strtotime($date2)));
					  $myCalendar->setPath("datePicker/calendar/calendar/");
					  $myCalendar->setYearInterval($startYearCal, $endYearCal);
					  $myCalendar->setAlignment('left', 'bottom');
					  $myCalendar->setDatePair('date1', 'date2', $date1);
					  $myCalendar->writeScript();

				  ?>
                </div>
              </div>
			<img width="30" height="12" src="ims/spacer.png">

			<input type="submit" name="Submit1" value="Reporte CSV"/>

</form>

</body>
</html>
