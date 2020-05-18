<?php
include('session.php');
include("homeAndExit.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/home.css">
<title>MyWalletX</title>
<link href="css/styleLog.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php require_once('db/dbConn.php'); ?>

<div id="apDivLeft" class="border">

  <?php include('getCategories.php'); ?>
  
</div>

<div id="apDivJoinRigth" class="border"></div>

<div id="apDivMiddle">

<p>
<a href="addItem.php"><br>
<img id="item" src="ims/addItem.png" alt="Add Item..." width="39" height="39" title="Add Item!"></a>
<br>
</p>


<p>
<a href="addCategory.php"><br>
<img src="ims/addCategory.png" alt="Add Category..." width="39" height="39" title="Add Category!"></a>
<br>
</p>

<p>
<a href="addSaving.php"><br>
<img src="ims/addSaving.png" alt="Register Saving..." width="39" height="39" title="Register Saving!"></a>
<br>
</p>

<p>
<a href="getCurrentStatus.php"><br>
<img src="ims/currentStatus.png" alt="Get Current Status..." width="39" height="39" title="Get Current Status!"></a>
<br>
</p>

<p>
<a href="bars.php"><br>
<img src="ims/bars.png" alt="Bars..." width="39" height="39" title="Bar Chart All Categories!"></a>
<br>

<p>
<a href="pieAll.php"><br>
<img src="ims/pieAll.png" alt="Pie All..." width="39" width="39" title="Pie Chart All Categories!"></a>
<br>

<p>
<a href="barSingle.php"><br>
<img src="ims/barSingle.png" alt="Bar..." width="39" height="39" title="Bar Chart Specific Category!"></a>
<br>

<p>
<a href="pieSingle.php"><br>
<img src="ims/pieSingle.png" alt="Pie..." width="39" height="39" title="Pie Chart Specific Category!"></a>
<br>
	
</div>

<p> <div STYLE="position:absolute; TOP:90px; LEFT:74%" title="PDF Report">PDF</div>
<a href="pdf.php">
<img STYLE="position:absolute; TOP:90px; LEFT:72%" src="ims/pdf.png" alt="PDF Report" width="27" height="27" title="PDF Report"></a>
</p>

<p> <div STYLE="position:absolute; TOP:90px; LEFT:78%">CSV</div>
<a href="csv.php"><br>
<img STYLE="position:absolute; TOP:90px; LEFT:76%" src="ims/xls.png" alt="CSV Report" width="27" height="27" title="CSV Report"></a>
<br>
</p>

<div id="apDivRigth">
	<?php include('getItemsWithFG.php'); ?>
	
</div>

</body>
</html>

