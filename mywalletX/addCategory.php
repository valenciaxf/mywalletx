<?php
require_once('session.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" />
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script language="javascript">
  window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
  }, 4000);

</script>

<link rel="stylesheet" type="text/css" href="css/bars.css">

<link rel="stylesheet" type="text/css" href="css/category.css">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<?php
include_once ('db/dbConn.php');
$dbConnX=new dbConn();

include("homeAndExit.php");

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
    
	// confirm...
    echo "<div class='alert alert-success' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    <strong>The Category has been registered (".$catCategory.") has been registered...</strong>
    </div>";

    }else{
    echo "<div class='alert alert-success' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    <strong>You must fill all the fields...</strong>
    </div>";
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

</body>
</html>
