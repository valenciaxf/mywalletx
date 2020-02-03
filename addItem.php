<?php
require_once('session.php');
?>
<?php
require_once('datePicker/calendar/calendar/classes/tc_calendar.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
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
include_once ('db/dbConn.php');
$dbConnX=new dbConn();

// recibimos el formulario
if(isset($_POST['enviar']) && $_POST['enviar'] == 'Save'){
    // comprobamos que el formulario no envie campos vacios
    if(!empty($_POST['iteCategory']) && $_POST['iteTotalAmount'] &&
    $_POST['iteQuantity'] && $_POST['iteDate'] && $_POST['iteComment']){
        // creamos las variables y les asignamos los valores a insertar
        $iteCategory = $_POST['iteCategory'];
        $iteTotalAmount = $_POST['iteTotalAmount'];
        $iteQuantity = $_POST['iteQuantity'];
		$iteDate = $_POST['iteDate'];
        $iteComment = $_POST['iteComment'];
		$iteCategory = stripslashes($iteCategory);
		$iteTotalAmount = stripslashes($iteTotalAmount);
		$iteQuantity = stripslashes($iteQuantity);
		$iteDate = stripslashes($iteDate);
		$iteComment = stripslashes($iteComment);
		$iteCategory = mysqli_real_escape_string($dbConnX->connX,$iteCategory);
		$iteTotalAmount = mysqli_real_escape_string($dbConnX->connX,$iteTotalAmount);
		$iteQuantity = mysqli_real_escape_string($dbConnX->connX,$iteQuantity);
		$iteDate = mysqli_real_escape_string($dbConnX->connX,$iteDate);
		$iteComment = mysqli_real_escape_string($dbConnX->connX,$iteComment);
		
		$sqlInsertIte=$dbConnX->insertItem($iteCategory,$iteTotalAmount,$iteQuantity,$iteDate,$iteComment,$user_id_session);
		
        // confirm...
		echo "<div STYLE='position:absolute; TOP:600px; LEFT:480px'>The item (".$iteComment.") has been registered....</div>";
    }else{
		echo "<div STYLE='position:absolute; TOP:600px; LEFT:480px'>You must fill all the fields...</div>";
    }
}
?>

<!-- form... -->
<br>
<form id="sform" name="item" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
<legend>Add Item  </legend>
<p>
    Amount<br />
    <input type="text" name="iteTotalAmount" size="10" />
    </p>
	<p>
    Quantity<br />
    <input type="text" name="iteQuantity" size="10" />
    </p>
    <p>
	Date<br />
<?php
				  $startYearCal=date("Y")-50;
				  $endYearCal=date("Y")+50;
				  
	  $myCalendar = new tc_calendar("iteDate", true);
	  $myCalendar->setIcon("datePicker/calendar/calendar/images/iconCalendar.gif");
	  
          $myCalendar->setDate(date("d"), date("m"), date("Y"));
          $myCalendar->setPath("datePicker/calendar/calendar/");
	  $myCalendar->setYearInterval($startYearCal, $endYearCal);
	  $myCalendar->writeScript();
	  
	?>
	<br>
</p>
  <p>Description<br />
    <textarea name="iteComment" rows="10" cols="60"></textarea>
  </p>
    <p>
    Category          
      <select name="iteCategory">
        <option value="">Choose Category...</option>
        <?php
	//check for get item Category from DB...
    $sqlQueryCat = $dbConnX->getCategory($user_id_session);
    
	//show categories...
    while($rowCat = mysqli_fetch_array($sqlQueryCat)){
		echo "<option value='$rowCat[cat_ID]'>$rowCat[cat_name]</option>";
    }
    ?>
      </select>
      <br />
    </p>
    <p>
    <input type="submit" name="enviar" value="Save" class="button"/>
    </p>
</form>
<br>
<?php
$mydate = isset($_REQUEST["iteDate"]) ? $_REQUEST["iteDate"] : "";

if ($mydate!="") echo "";//echo("value of date submit = ".$mydate);

?>


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