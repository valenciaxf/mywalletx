<?php
require_once('session.php');
?>
<?php
require_once('datePicker/calendar/calendar/classes/tc_calendar.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<link href="datePicker/calendar/calendar/calendar.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="datePicker/calendar/calendar/calendar.js"></script>

<style type="text/css">
body { font-size: 11px; font-family: "verdana"; }

pre { font-family: "verdana"; font-size: 10px; background-color: #FFFFCC; padding: 5px 5px 5px 5px; }
pre .comment { color: #008000; }
pre .builtin { color:#FF0000;  }



form    {
	background: -webkit-gradient(linear, bottom, left 175px, from(#CCCCCC), to(#EEEEEE));
	background: -moz-linear-gradient(bottom, #CCCCCC, #EEEEEE 175px);
	margin: auto;
	position: relative;
	width: 550px;
	height: 500px;
#font-family: Tahoma, Geneva, sans-serif;
	font-size: 10px;
	font-style: normal;
	line-height: 24px;
	font-weight: bold;
	text-decoration: none;
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
	padding: 10px;
	border: 1px solid #999;
	border: inset 1px solid #333;
	-webkit-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
	-moz-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
	box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
}

legend
{
color: #09C;
font-size: 13px;
font-style: normal;
}


textarea:focus, input:focus {
border: 1px solid #09C;
}


input.button {
width:100px;
position:absolute;
right:20px;
bottom:20px;
background:#09C;
color:#fff;
font-family: Tahoma, Geneva, sans-serif;
height:30px;
-webkit-border-radius: 15px;
-moz-border-radius: 15px;
border-radius: 15px;
border: 1p solid #999;
font-weight: bold;
}
input.button:hover {
background:#fff;
color:#09C;
}

body {
    background-image: url("ims/noiseBg.png");
}

</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<?php
include_once ('db/dbConn.php');
$connX=connFncConnX();

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
		$iteCategory = mysqli_real_escape_string($connX,$iteCategory);
		$iteTotalAmount = mysqli_real_escape_string($connX,$iteTotalAmount);
		$iteQuantity = mysqli_real_escape_string($connX,$iteQuantity);
		$iteDate = mysqli_real_escape_string($connX,$iteDate);
		$iteComment = mysqli_real_escape_string($connX,$iteComment);
		
        $sqlInsertNot = mysqli_query($connX, "INSERT INTO item
                                     (ite_category, ite_totalAmount, ite_quantity, ite_date, ite_comment)
                                     VALUES ('$iteCategory', '$iteTotalAmount', '$iteQuantity', '$iteDate', '$iteComment')") or die(mysqli_error($connX));
        // confirm...
        //echo "The Item has been registered... (".$iteComment.")"; here...
		echo "<div STYLE='position:absolute; TOP:550px; LEFT:400px'>The item (".$iteComment.") has been registered....</div>";
    }else{
        #echo "You must fill in all the fields...";
								echo "<div STYLE='position:absolute; TOP:550px; LEFT:400px'>You must fill all the fields...</div>";
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
	  //$myCalendar->setDate(01, 03, 1960);
	  
          $myCalendar->setDate(date("d"), date("m"), date("Y"));
          $myCalendar->setPath("datePicker/calendar/calendar/");
	  $myCalendar->setYearInterval($startYearCal, $endYearCal);
	  //$myCalendar->dateAllow('1960-01-01', '2015-03-01');
	  //$myCalendar->setSpecificDate(array("2011-04-01", "2011-04-13", "2011-04-25"), 0, 'month');
	  //$myCalendar->setOnChange("myChanged('...')");
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
    $sqlQueryCat = mysqli_query($connX, "SELECT cat_ID,cat_name FROM category order by 2")   
                                or die(mysqli_error($connX));
    
	//show categories...
    while($rowCat = mysqli_fetch_array($sqlQueryCat)){
        //echo "<option value='$rowCat[cat_ID]'>$rowCat[cat_name] - $rowCat[cat_ID]</option>";
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

<?php
$mydate = isset($_REQUEST["iteDate"]) ? $_REQUEST["iteDate"] : "";

if ($mydate!="") echo "";//echo("value of date submit = ".$mydate);

?>

<p> <div STYLE="position:absolute; TOP:80px; LEFT:905px">Home...</div>
<a href="index.php">
<img STYLE="position:absolute; TOP:25px; LEFT:890px" src="ims/home.png" alt="Home..."></a>


</p>