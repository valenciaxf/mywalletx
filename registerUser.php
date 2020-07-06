<?php
require_once('session.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bars.css">
<link rel="stylesheet" type="text/css" href="css/item.css">
<link rel="stylesheet" type="text/css" href="css/home.css">


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

if(isset($_POST['enviar']) && $_POST['enviar'] == 'Registrar'){
    // validate empty fields...
    if(!empty($_POST['userLoginFrm']) && !empty($_POST['pass1Frm']) && !empty($_POST['pass2Frm'])
		&& !empty($_POST['contactNumberFrm']) && !empty($_POST['namesInFrm']) && !empty($_POST['lnFrm1']) 
		&& !empty($_POST['lnFrm2']) && !empty($_POST['mlFrm']) && !empty($_POST['fbkFrm']) && !empty($_POST['monthsFrm'])){
        // init vars...
        $userLoginFrm = $_POST['userLoginFrm'];
		$pass1Frm = $_POST['pass1Frm'];
		$pass2Frm = $_POST['pass2Frm'];
        $contactNumberFrm = $_POST['contactNumberFrm'];
		$namesInFrm = $_POST['namesInFrm'];
		$lnFrm1 = $_POST['lnFrm1'];
        $lnFrm2 = $_POST['lnFrm2'];
		$mlFrm = $_POST['mlFrm'];
		$fbkFrm = $_POST['fbkFrm'];
		$monthsFrm = $_POST['monthsFrm'];

		$userLoginFrm = stripslashes($userLoginFrm);
		$pass1Frm = stripslashes($pass1Frm);
		$pass2Frm = stripslashes($pass2Frm);
		$contactNumberFrm = stripslashes($contactNumberFrm);
		$namesInFrm = stripslashes($namesInFrm);
		$lnFrm1 = stripslashes($lnFrm1);
		$lnFrm2 = stripslashes($lnFrm2);
		$mlFrm = stripslashes($mlFrm);
		$fbkFrm = stripslashes($fbkFrm);		
		$monthsFrm = stripslashes($monthsFrm);		
		
		
		$userLoginFrm = mysqli_real_escape_string($dbConnX->connX, $userLoginFrm);
		$pass1Frm = mysqli_real_escape_string($dbConnX->connX, $pass1Frm);
		$pass2Frm = mysqli_real_escape_string($dbConnX->connX, $pass2Frm);
		$contactNumberFrm = mysqli_real_escape_string($dbConnX->connX, $contactNumberFrm);
		$namesInFrm = mysqli_real_escape_string($dbConnX->connX, $namesInFrm);
		$lnFrm1 = mysqli_real_escape_string($dbConnX->connX, $lnFrm1);
		$lnFrm2 = mysqli_real_escape_string($dbConnX->connX, $lnFrm2);
		$mlFrm = mysqli_real_escape_string($dbConnX->connX, $mlFrm);
		$fbkFrm = mysqli_real_escape_string($dbConnX->connX, $fbkFrm);		
		$monthsFrm = mysqli_real_escape_string($dbConnX->connX, $monthsFrm);		

    mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
    try {
				if (strcmp($pass1Frm, $pass2Frm)==0)
				{
							
							$sqlInsertCat=$dbConnX->registerUser($userLoginFrm,$pass1Frm,$contactNumberFrm,$namesInFrm,$lnFrm1,$lnFrm2,$mlFrm,$fbkFrm,$monthsFrm);
						  
						  // confirm...
							  echo "<div class='alert alert-success' role='alert'>
							  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							  <strong>El usuario ha sido registrado (".$userLoginFrm.")...</strong>
							  </div>";
				} else {
							  echo "<div class='alert alert-danger' role='alert'>
							  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							  <strong>El password no coincide, favor de confirmarlo...</strong>
							  </div>";
				}
				
    } catch (mysqli_sql_exception  $e) {
                  echo "<div class='alert alert-danger' role='alert'>
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                  <strong>Ha ocurrido una excepción, favor de reportar el evento, para continuar presione el icono de Home...</strong>
                  </div>";
    }

    }else{
                echo "<div class='alert alert-warning' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong>Es necesario llenar todos los campos...</strong>
                </div>";
    }
}
?>
<br>


<form id="sform" name="categoria" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
    <p>
   <legend> Registrar Usuario</legend>
   </p>
	<p>
    Login<br>
     <input type="text" name="userLoginFrm" />
     <br>
    </p>
	
	<p>
    Password<br>
     <input type="text" name="pass1Frm" />
     <br>
    </p>
	
	<p>
    Confirmar Password<br>
     <input type="text" name="pass2Frm" />
     <br>
    </p>
	
	<p>
    Número de Contacto<br>
     <input type="text" name="contactNumberFrm" />
     <br>
    </p>

	<p>
    Nombre(s)<br>
     <input type="text" name="namesInFrm" />
     <br>
    </p>

	<p>
    Apellido Materno<br>
     <input type="text" name="lnFrm1" />
     <br>
    </p>

	<p>
    Apellido Paterno<br>
     <input type="text" name="lnFrm2" />
     <br>
    </p>
	
	<p>
    Mail<br>
     <input type="text" name="mlFrm" />
     <br>
    </p>
	
	<p>
    Facebook<br>
     <input type="text" name="fbkFrm" />
     <br>
    </p>

	<p>
    Meses a habilitar<br>
     <input type="text" name="monthsFrm" />
     <br>
    </p>
	
	<br><br>

	    <input type="submit" name="enviar" value="Registrar" class="button"/>

    </p>
</form>

</body>
</html>
