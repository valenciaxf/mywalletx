<?php
require_once('session.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bars.css">

<link rel="stylesheet" type="text/css" href="css/category.css">

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

<?php
include_once ('db/dbConn.php');
//$connX=connFncConnX();
$dbConnX=new dbConn();

if(isset($_POST['enviar']) && $_POST['enviar'] == 'Save'){
    // validate empty fields...
    if(!empty($_POST['catCategory']) && !empty($_POST['catDescription']) && !empty($_POST['catType'])){
        // init vars...
        $catCategory = $_POST['catCategory'];
		$catDescription = $_POST['catDescription'];
		$catType = $_POST['catType'];

		//echo " ".$catCategory." ".$catDescription." ".$catType;

		$catCategory = stripslashes($catCategory);
		$catDescription = stripslashes($catDescription);
		$catType = stripslashes($catType);
		$catCategory = mysqli_real_escape_string($dbConnX->connX, $catCategory);
		$catDescription = mysqli_real_escape_string($dbConnX->connX, $catDescription);
		$catType = mysqli_real_escape_string($dbConnX->connX, $catType);
		
       // insert...
		$sqlInsertCat=$dbConnX->insertCategory($catCategory,$catDescription,$catType,$user_id_session);
		echo "<div STYLE='position:absolute; TOP:600px; LEFT:480px'>The Category has been registered.... (".$catCategory.")</div>";

    }else{
		echo "<div STYLE='position:absolute; TOP:600px; LEFT:480px'>You must fill all the fields...</div>";

    }
}
?>
<br>

<form id="sform" name="categoria" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
    <p>
   <legend> Add Category</legend>
   </p>
   <p>
    Name<br>
     <input type="text" name="catCategory" />
     <br><br>
    </p>
    <p>
    Description<br />
    <textarea name="catDescription" rows="10" cols="60"></textarea>
    </p>
    <p>
	
	Type<br> 
		<select name="catType">
		<option value="OUT" name="out"> OUT </option>
		<option value="IN" selected="selected" name="in"> IN </option>
		</select><br><br>

	    <input type="submit" name="enviar" value="Save" class="button"/>

    </p>
</form>

<p> <div STYLE="position:absolute; TOP:72px; LEFT:905px">Home...</div>
<a href="myWalletX.php">
<img STYLE="position:absolute; TOP:21px; LEFT:890px" src="ims/home.png" alt="Home..."></a>
</p>

<p> <div STYLE="position:absolute; TOP:72px; LEFT:990px">Exit...</div>
<a href="logout.php"><br>
<img STYLE="position:absolute; TOP:21px; LEFT:980px" src="ims/exit.png" alt="Exit..." width="48" height="48" title="Exit!"></a>
<br>
</p>


</body>
</html>
