<?php
require_once('session.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

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
	line-height: 24px;
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
	font-weight: bold;
	text-align: justify;
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
// include db connection...
include_once ('db/dbConn.php');
$connX=connFncConnX();

if(isset($_POST['enviar']) && $_POST['enviar'] == 'Save'){
    // calidate empty fields...
    if(!empty($_POST['savAmount']) && !empty($_POST['savDescription'])){
        // init vars...
        $savAmount = $_POST['savAmount'];
		$savDescription = $_POST['savDescription'];

		$savAmount = stripslashes($savAmount);
		$savDescription = stripslashes($savDescription);
		$savAmount = mysqli_real_escape_string($connX, $savAmount);
		$savDescription = mysqli_real_escape_string($connX, $savDescription);
		
		#echo " ".$savAmount." ".$savDescription
        // insert...
        $sqlInsertCat = mysqli_query($connX, "INSERT INTO saving (sav_amount, sav_desc)
                                    VALUES ('$savAmount', '$savDescription')")
                                    or die(mysqli_error($connX));
        #echo "The Saving has been registered...";
				echo "<div STYLE='position:absolute; TOP:550px; LEFT:400px'>The Saving has been registered....</div>";

    }else{
        #echo "You must fill all the fields...";
						echo "<div STYLE='position:absolute; TOP:550px; LEFT:400px'>You must fill all the fields...</div>";

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
$connX=connFncConnX();

$sql = "SELECT SUM(sav_amount) FROM saving"; #when multi user is going to be enabled it must add user_id or username...
$res = mysqli_query($connX,$sql);
if (FALSE === $res) die("Select sum (savings) failed: ".mysqli_error);
$row = mysqli_fetch_row($res);
$sum = $row[0];

echo "Saving-> ".$sum;
?>
<br>
	
</form>

<p> <div STYLE="position:absolute; TOP:80px; LEFT:905px">Home...</div>
<a href="index.php">
<img STYLE="position:absolute; TOP:25px; LEFT:890px" src="ims/home.png" alt="Home..."></a>

</p>