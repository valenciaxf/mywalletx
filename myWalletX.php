<?php
include('session.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/home.css">
<title>MyWalletX</title>
<link href="css/styleLog.css" rel="stylesheet" type="text/css">
</head>
<body>

<div id="pagHeader">
<div id="pagHeaderLogo">
<a href="logout.php"></a><img width="728" height="90" alt="MyWalletX" src="ims/banner.png">
</a>
</div>
<div>
<b id="welcome">Welcome : <i><?php echo $login_session; ?></i>
</div>

<?php require_once('db/dbConn.php'); ?>


<div id="apDivLeft" class="border">

  <?php include('getCategories.php'); ?></div>

<div id="apDivJoinRigth" class="border"></div>

<div id="apDivMiddle">

<p>
<a href="addItem.php"><br>
<img id="item" src="ims/addItem.png" alt="Add Item..." width="30" height="30" title="Add Item!"></a>
<br>
</p>


<p>
<a href="addCategory.php"><br>
<img src="ims/addCategory.png" alt="Add Category..." width="30" height="30" title="Add Category!"></a>
<br>
</p>

<p>
<a href="addSaving.php"><br>
<img src="ims/addSaving.png" alt="Register Saving..." width="30" height="30" title="Register Saving!"></a>
<br>
</p>

<p>
<a href="getCurrentStatus.php"><br>
<img src="ims/currentStatus.png" alt="Get Current Status..." width="30" height="30" title="Get Current Status!"></a>
<br>
</p>

<p>
<a href="bars.php"><br>
<img src="ims/bars.png" alt="Bars..." width="30" height="30" title="Bar Chart All Categories!"></a>
<br>

<p>
<a href="pieAll.php"><br>
<img src="ims/pieAll.png" alt="Pie All..." width="27" height="27" title="Pie Chart All Categories!"></a>
<br>

<p>
<a href="barSingle.php"><br>
<img src="ims/barSingle.png" alt="Bar..." width="30" height="30" title="Bar Chart Specific Category!"></a>
<br>

<p>
<a href="pieSingle.php"><br>
<img src="ims/pieSingle.png" alt="Pie..." width="27" height="27" title="Pie Chart Specific Category!"></a>
<br>

<p>
<a href="logout.php"><br>
<img src="ims/exit.png" alt="Exit..." width="30" height="30" title="Exit!"></a>
<br>
</div>



<div id="apDivRigth"><?php include('getItemsWithFG.php'); ?></div>

</body>
</html>

