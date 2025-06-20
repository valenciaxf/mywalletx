<?php
require_once('datePicker/calendar/calendar/classes/tc_calendar.php');
require_once('session.php');
include_once('db/dbConn.php');
$dbConnX = new dbConn();
?>
<?php
$mydate1 = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
$mydate2 = isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";
?>
<?php
//$mydate1,$mydate2
//$mydate1='2020-01-13';
//$mydate2='2020-01-19';

if (array_key_exists('Submit1', $_POST)) {
	require('fpdf/fpdf.php');
	$result = $dbConnX->fetchData2PdfAndCsv($mydate1, $mydate2, $user_id_session);
	$pdf = new FPDF();
	$pdf->AddPage();
	// Colors of frame, background and text
	$pdf->SetDrawColor(0, 80, 180);
	$pdf->Image("ims/addItem.png", 10, -1, 25);
	$pdf->SetFont('Arial', 'B', 10);
	// Move to the right
	$pdf->Cell(60);
	// Title
	$pdf->Cell(60, 6, 'Reporte PDF       Desde:       ' . $mydate1 . '       Hasta:       ' . $mydate2, 0, 0, 'C');
	// Line break
	$pdf->Ln(12);

	$header = array(
		'cat_name' => 'Categoría',
		'ite_totalAmount' => 'Monto',
		'ite_quantity' => 'Cantidad',
		'ite_date' => 'Fecha',
		'ite_comment' => 'Descripción'
	);

	$pdf->Ln();
	$pdf->SetTextColor(0, 80, 180);
	$pdf->SetFont('Times', 'BIU', 12);
	$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', $header['cat_name']), 1);
	$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', $header['ite_totalAmount']), 1);
	$pdf->Cell(18, 10, $header['ite_quantity'], 1);
	$pdf->Cell(24, 10, iconv('UTF-8', 'windows-1252', $header['ite_date']), 1);
	$pdf->Cell(87, 10, iconv('UTF-8', 'windows-1252', $header['ite_comment']), 1);
	$pdf->SetTextColor(0, 0, 0);


	foreach ($result as $row) {
		$pdf->SetFont('Arial', '', 10);
		$pdf->Ln();
		foreach ($row as $row => $column)
			if ($row == 'ite_quantity') {
				$pdf->Cell(18, 10, $column, 1);
			} else if ($row == 'cat_name') {
				$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', substr($column, 0, 15)), 1);
			} else if ($row == 'ite_date') {
				$pdf->Cell(24, 10, iconv('UTF-8', 'windows-1252', $column), 1);
			} else if ($row == 'ite_comment') {
				$pdf->Cell(87, 10, iconv('UTF-8', 'windows-1252', substr($column, 0, 84)), 1);
			} else if ($row == 'ite_totalAmount') {
				$pdf->Cell(30, 10, iconv('UTF-8', 'windows-1252', $column), 1);
			} else {
				$pdf->Cell(42, 10, iconv('UTF-8', 'windows-1252', $column), 1);
			}
	}// cat_name,ite_totalAmount,ite_quantity,DATE_FORMAT(ite_date,'%d-%m-%Y') ite_date,ite_comment

	//$pdf->Output();
	$pdf->Output('report.pdf', 'D');
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/styleLog2.css">

	<title>Reporte PDF</title>

	<link href="datePicker/calendar/calendar/calendar.css" rel="stylesheet" type="text/css" />
	<script language="javascript" src="datePicker/calendar/calendar/calendar.js"></script>
	<link rel="stylesheet" type="text/css" href="css/home.css">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

	<?php
	include("homeAndExit.php");
	?>
	<!--	  <form id="calendarform" name="calendarform" method="post" action="datePicker/calendar/calendar/calendar_form.php"> -->
	<div style="display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column;">
		<form id="sform" name="calendarform" method="post" action="<?php $_SERVER['PHP_SELF'] ?>"
			style="text-align: center; max-width: 500px; width: 100%;">
			<p class="largetxt"><b>Select dates:</b></p>
			<div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
				<div style="text-align: left;">
					<div style="padding-right: 3px; line-height: 18px;">Desde: </div>
					<div>
						<?php
						$startYearCal = date("Y") - 50;
						$endYearCal = date("Y") + 50;

						$thisweek = date('W');
						$thisyear = date('Y');

						$dayTimes = getDaysInWeek($thisweek, $thisyear);
						//----------------------------------------
						
						$date1 = date('Y-m-d', $dayTimes[0]);
						$date2 = date('Y-m-d', $dayTimes[(sizeof($dayTimes) - 1)]);

						function getDaysInWeek($weekNumber, $year, $dayStart = 1)
						{
							$time = strtotime($year . '0104 +' . ($weekNumber - 1) . ' weeks');
							$dayTime = strtotime('-' . (date('w', $time) - $dayStart) . ' days', $time);
							$dayTimes = array();
							for ($i = 0; $i < 7; ++$i) {
								$dayTimes[] = strtotime('+' . $i . ' days', $dayTime);
							}
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
				<div style="text-align: left;">
					<div style="padding-left: 3px; padding-right: 3px; line-height: 18px;"> Hasta: </div>
					<div>
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
			</div>
			<img width="30" height="12" src="ims/spacer.png">
			<input type="submit" name="Submit1" value="Reporte PDF" />
		</form>
	</div>
</body>

</html>