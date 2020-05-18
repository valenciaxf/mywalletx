<?php
require_once('session.php');
require_once('session.php');
include_once ('db/dbConn.php');
$dbConnX=new dbConn();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bars.css">

<link rel="stylesheet" type="text/css" href="css/item.css">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<?php

include("homeAndExit.php");

if(isset($_POST['enviar']) && $_POST['enviar'] == 'Save'){
    // calidate empty fields...
    if(!empty($_POST['savAmount']) && !empty($_POST['savDescription'])){
        // init vars...
        $savAmount = $_POST['savAmount'];
		$savDescription = $_POST['savDescription'];

		$savAmount = stripslashes($savAmount);
		$savDescription = stripslashes($savDescription);
		$savAmount = mysqli_real_escape_string($dbConnX->connX, $savAmount);
		$savDescription = mysqli_real_escape_string($dbConnX->connX, $savDescription);
		
        // insert...
        $sqlInsertSav = $dbConnX->insertSaving($savAmount,$savDescription,$user_id_session);
		echo "<div STYLE='position:absolute; TOP:600px; LEFT:492px'>The Saving has been registered.... (".$savDescription.")</div>";

    }else{
			echo "<div STYLE='position:absolute; TOP:600px; LEFT:492px'>You must fill all the fields...</div>";
    }
}
?>
<br>
<!-- el formulario -->
<form id="sform" name="saving" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
    <p>
   <legend> Register Saving</legend></p>
   <p>
    Specify Amount<br>
     <input type="text" name="savAmount" />
     <br><br>
    </p>
    <p>
    Description<br />
    <textarea name="savDescription" rows="10" cols="60"></textarea>
    </p>
    <p>
	
	    <input type="submit" name="enviar" value="Save" class="button"/>

    </p>

<br>
<br>
<br>

<?php
echo "";
echo "You have register following saving until now:";
?>
<br>
<?php
$sum = $dbConnX->getSavingAmount($user_id_session);

echo "Saving-> ".$sum;
?>
<br>
	
</form>

</body>
</html>


