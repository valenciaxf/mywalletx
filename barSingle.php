<?php
require_once('session.php');
?>
<?php
include("homeAndExit.php");

require_once('datePicker/calendar/calendar/classes/tc_calendar.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html>
<head>
<link rel="stylesheet" type="text/css" href="css/bars.css">
<link rel="stylesheet" type="text/css" href="css/styleLog2.css">

<title>Pie</title>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/Chart.min.js"></script>

<link href="datePicker/calendar/calendar/calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="datePicker/calendar/calendar/calendar.js"></script>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<legend>#Select a category and then clic in the required dates</legend>
<div id="apDivLeft" class="border">
<span class="class"> 
<br>
<img src="ims/addCategory.png" alt="Categories..." width=50 height=50 title="Categories">
</span>
<?php
require_once ('db/dbConn.php');
$dbConnX=new dbConn();

$sqlQueryCat =  $dbConnX->getCategory($user_id_session);

echo "<ul>";
while($rowCat = mysqli_fetch_array($sqlQueryCat)){
    echo "<li><a href='?cat_name=$rowCat[cat_name]&amp;cat_ID=$rowCat[cat_ID]'>$rowCat[cat_name]</a></li>";
}
echo "</ul>";

if(isset($_GET['cat_ID']) && $_GET['cat_name']){
    // asignamos los valores
    // a las variables que usaremos
    $cat_ID = $_GET['cat_ID'];
    $category = $_GET['cat_name'];
	$whereFilter = " AND ite_category = '$cat_ID'";
    $titulo = "Items from category: $category";
	//echo $category." ".$cat_ID;
	//?cat_name=Food&cat_ID=1
	$myCategory=$cat_ID;
}else{
	$category = "There is not category selected...";
    $titulo = "All Items...";
	$myCategory="";
}

?>
</div>



<div id="apDivRigth">
<!--	  <form id="calendarform" name="calendarform" method="post" action="datePicker/calendar/calendar/calendar_form.php"> -->
<form id="calendarform" name="calendarform" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
              <p class="largetxt"><b>Select dates:</b></p>
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
<img width="30" height="12" src="ims/spacer.png">				
			<input type="submit" name="Submit1" value="Submit" />
			
			  
            </form>

<?php
$mydate1 = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
$mydate2 = isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";

?>

    <div id="chart-container">
        <canvas id="graphCanvas"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
            {
                $.post("dataChartSpecific.php",
 <!--					 { key1: "2018-01-11", key2: "2018-10-12" },-->
  						{ key1: "<?php echo $mydate1; ?>", key2: "<?php echo $mydate2; ?>", key3: "<?php echo $myCategory; ?>" },
                function (data)
                {
                    console.log(data);
                     var description = [];
                    var itemAmount = [];
					
                    for (var i in data) {
                        description.push(data[i].item_description);
                        itemAmount.push(data[i].amount);
                    }


                    var chartdata = {
                        labels: description,
                        datasets: [
                            {
                                label: 'Item Detail',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: itemAmount
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });
            }
        }d
        </script>

</div>

</body>
</html>