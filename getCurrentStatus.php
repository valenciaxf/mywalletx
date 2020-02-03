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


<link href="datePicker/calendar/calendar/calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="datePicker/calendar/calendar/calendar.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="pagHeader">
<div id="pagHeaderLogo">
<a href="logout.php"></a><img width="728" height="90" alt="MyWalletX" src="ims/banner.png">
</a>
</div>

<div>
<b id="welcome">Welcome : <i><?php echo $login_session; ?></i>
</div>

<br>

<?php
// include db connection...
require_once ('db/dbConn.php');
$dbConnX=new dbConn();
?>
<br>

<form name="categoria" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    <p>
   <legend> #Current Status</legend>
   </p>

<?php
	echo "You got this month: ";
	$sum1=$dbConnX->getAvailableAmountCurrentMonth($user_id_session);
?>
	<i>
	<?php
		echo $sum1;
	?>
	</i>
<br>
<?php
echo "You have spent this month (until now): ";
	$sum2=$dbConnX->getSpentCurrentMonth($user_id_session);
?>
	<i>
	<?php
		echo $sum2;
	?>
	</i>
<br>
<?php
$available=$sum1-$sum2;
echo "You have available: ";
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

$restDays=(int)$lastDay-$currentDay;
$avgAvailable=$available/$restDays;

echo "This month have: ".$lastDay." days, so You can use daily aprox. for next ". $restDays." days: ";
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
   <legend> #Current Status (With Savings)</legend>
   </p>

<?php
$sumMonthSavings = $dbConnX->getSavingAmount($user_id_session);
$availableAfterSavings=($available-$sumMonthSavings);
$avgAvailable=$availableAfterSavings/$restDays;

echo "You can use aprox. for next ".$restDays." days: ";
?>
	<i>
	<?php
		echo number_format((float)$avgAvailable, 2, '.', '');
	?>
	</i>
<br>

<?php
echo "Available after savings: "
?>
   <i>
   <?php
		echo $availableAfterSavings;
   ?>
   </i>
    </p>
</form>

<p> <div STYLE="position:absolute; TOP:72px; LEFT:905px">Home...</div>
<a href="index.php">
<img STYLE="position:absolute; TOP:21px; LEFT:890px" src="ims/home.png" alt="Home..."></a>
</p>

<p> <div STYLE="position:absolute; TOP:72px; LEFT:990px">Exit...</div>
<a href="logout.php"><br>
<img STYLE="position:absolute; TOP:21px; LEFT:980px" src="ims/exit.png" alt="Exit..." width="48" height="48" title="Exit!"></a>
<br>
</p>


</body>
</html>