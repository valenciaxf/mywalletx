<?php
require_once('session.php');
?>
<?php
require_once('datePicker/calendar/calendar/classes/tc_calendar.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="css/styleLog.css" rel="stylesheet" type="text/css">
<link href="css/status.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/bars.css">
<link rel="stylesheet" type="text/css" href="css/item.css">
<link rel="stylesheet" type="text/css" href="css/home.css">


<link href="datePicker/calendar/calendar/calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="datePicker/calendar/calendar/calendar.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<?php
// include db connection...
require_once ('db/dbConn.php');
$dbConnX=new dbConn();

include("homeAndExit.php");

?>
<br>

<form name="categoria" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    <p>
   <legend> Status actual</legend>
   </p>

<?php
	echo "Ingresos de la quincena actual (iniciando el ";
	$startAx=date('01-m-Y');
	echo $startAx;
	echo ")";
	$sum1=$dbConnX->getAvailableAmountCurrent15($user_id_session);
?>
	<i>
	<?php
		echo $sum1;
	?>
	</i>
<?php
echo " y ocupado (hasta ahora): ";
	$sum2=$dbConnX->getSpentCurrent15($user_id_session);
?>
	<i>
	<?php
		echo $sum2;
	?>
	</i>
<br>
<?php
$available=$sum1-$sum2;
echo "Disponible actualmente: ";
?>
	<i>
	<?php
		echo $available;
	?>
	</i>
<br>
<?php


$lastDay=$dbConnX->getMonthLastDay();
$currentDay=(int)date("d");

if (($currentDay >= 1) and ($currentDay<=14))
{ 
	$restDays=15-$currentDay;
} else {
	$restDays=$lastDay-$currentDay;
}


if ($restDays==0) {
        echo "Hoy es el último día de la quincena, puedes usar: ";
        $avgAvailable=$available;
} else {
        $avgAvailable=$available/$restDays;
        echo "Puedes usar diariamente por los próximos ". $restDays." días: ";
}

?>
<i>
<?php
   echo number_format((float)$avgAvailable, 2, '.', '');
?>
</i>

<br>
<br>
<br>
   <p>
   <legend> Status actual (contemplando ahorro)</legend>
   </p>

<?php
$sumMonthSavings = $dbConnX->getSavingAmount($user_id_session);
$availableAfterSavings=($available-$sumMonthSavings);
$avgAvailable=$availableAfterSavings/$restDays;

echo "Puedes usar aproximadamente por los siguientes ".$restDays." días: ";
?>
<i>
<?php
   echo number_format((float)$avgAvailable, 2, '.', '');
?>
</i>
<br>

<?php
echo "Disponible después de ahorro: "
?>
<i>
<?php
   echo $availableAfterSavings;
?>
</i>

</p>
</form>

</body>
</html>
