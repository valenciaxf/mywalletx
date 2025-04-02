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


<script type="text/javascript">

  document.addEventListener("DOMContentLoaded", function() {

    // JavaScript form validation

    var checkPassword = function(str)
    {
      var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
      return re.test(str);
    };

    var checkForm = function(e)
    {
      if(this.username.value == "") {
        alert("Error: El login no puede estar vacío!");
        this.username.focus();
        e.preventDefault(); // equivalent to return false
        return;
      }
      re = /^\w+$/;
      if(!re.test(this.username.value)) {
        alert("Error: El login debe contenener únicamente letras, números y guiones bajos!");
        this.username.focus();
        e.preventDefault();
        return;
      }
      if(this.pwd1.value != "" && this.pwd1.value == this.pwd2.value) {
        if(!checkPassword(this.pwd1.value)) {
          alert("El password introducido no es válido!");
          this.pwd1.focus();
          e.preventDefault();
          return;
        }
      } else {
        alert("Error: Favor de revisar que hayas introducido y confirmado el password!");
        this.pwd1.focus();
        e.preventDefault();
        return;
      }
      alert("El login y el password son VÁLIDOS!");
    };

    var myForm = document.getElementById("myForm");
    myForm.addEventListener("submit", checkForm, true);

    // HTML5 form validation

    var supports_input_validity = function()
    {
      var i = document.createElement("input");
      return "setCustomValidity" in i;
    }

    if(supports_input_validity()) {
      var usernameInput = document.getElementById("field_username");
      usernameInput.setCustomValidity(usernameInput.title);

      var pwd1Input = document.getElementById("field_pwd1");
      pwd1Input.setCustomValidity(pwd1Input.title);

      var pwd2Input = document.getElementById("field_pwd2");

      // input key handlers

      usernameInput.addEventListener("keyup", function(e) {
        usernameInput.setCustomValidity(this.validity.patternMismatch ? usernameInput.title : "");
      }, false);

      pwd1Input.addEventListener("keyup", function(e) {
        this.setCustomValidity(this.validity.patternMismatch ? pwd1Input.title : "");
        if(this.checkValidity()) {
          pwd2Input.pattern = RegExp.escape(this.value);
          pwd2Input.setCustomValidity(pwd2Input.title);
        } else {
          pwd2Input.pattern = this.pattern;
          pwd2Input.setCustomValidity("");
        }
      }, false);

      pwd2Input.addEventListener("keyup", function(e) {
        this.setCustomValidity(this.validity.patternMismatch ? pwd2Input.title : "");
      }, false);

    }

  }, false);

</script>

<script type="text/javascript">

  // polyfill for RegExp.escape
  if(!RegExp.escape) {
    RegExp.escape = function(s) {
      return String(s).replace(/[\\^$*+?.()|[\]{}]/g, '\\$&');
    };
  }

</script>


<link rel="stylesheet" type="text/css" href="css/misc.css">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">


<?php
include_once ('db/dbConn.php');
$dbConnX=new dbConn();

		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
								$isActive = $dbConnX->checkIsAdmin($user_id_session);
						//echo "<br><br><br><br><br><br><br><br><br><br>".$isActive;
								if ($isActive == 0) {
										header("location: myWalletX.php"); // redirecting to home page...

								} 
			} catch (mysqli_sql_exception  $e) {
					              echo "<div class='alert alert-danger' role='alert'>
					              <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
					              <strong>Ha ocurrido una excepción, favor de reportar el evento, para continuar presione el icono de Home...</strong>
					              </div>";
			}
			
include("homeAndExit.php");

			
if(isset($_POST['enviar']) && $_POST['enviar'] == 'Registrar'){
    // validate empty fields...
    if(!empty($_POST['username']) && !empty($_POST['pwd1']) && !empty($_POST['pwd2'])
		&& !empty($_POST['contactNumberFrm']) && !empty($_POST['namesInFrm']) && !empty($_POST['lnFrm1'])
		&& !empty($_POST['lnFrm2']) && !empty($_POST['mlFrm']) && !empty($_POST['fbkFrm']) && !empty($_POST['monthsFrm'])){

        // init vars...
        $username = $dbConnX->cleanInput($_POST['username']);
		$pwd1 = $dbConnX->cleanInput($_POST['pwd1']);
		$pwd2 = $dbConnX->cleanInput($_POST['pwd2']);
        $contactNumberFrm = $dbConnX->cleanInput($_POST['contactNumberFrm']);
		$namesInFrm = $dbConnX->cleanInput($_POST['namesInFrm']);
		$lnFrm1 = $dbConnX->cleanInput($_POST['lnFrm1']);
        $lnFrm2 = $dbConnX->cleanInput($_POST['lnFrm2']);
		$mlFrm = $dbConnX->cleanInput($_POST['mlFrm']);
		$fbkFrm = $dbConnX->cleanInput($_POST['fbkFrm']);
        $monthsFrm = $dbConnX->cleanInput($_POST['monthsFrm']);
        
    mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);

    try {
				if (strcmp($pwd1, $pwd2)==0)
				{
    						$sqlInsertCat=$dbConnX->registerUser($user_id_session,$username,$pwd1,$contactNumberFrm,$namesInFrm,$lnFrm1,$lnFrm2,$mlFrm,$fbkFrm,$monthsFrm);

						  // confirm...
							  echo "<div class='alert alert-success' role='alert'>
							  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							  <strong>El usuario ha sido registrado (".$username.")...</strong>
							  </div>";
				} else {
    						  echo "<div class='alert alert-danger' role='alert'>
							  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
							  <strong>El password no coincide, favor de confirmarlo...</strong>
							  </div>";
				}

    } catch (mysqli_sql_exception  $e) {
        if($e->getCode() == 1062){
            echo "<div class='alert alert-danger' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            <strong>El usuario ya existe...</strong>
            </div>";

        }    else {
                  echo "<div class='alert alert-danger' role='alert'>
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                  <strong>Ha ocurrido una excepción, favor de reportar el evento, para continuar presione el icono de Home...</strong>
                  </div>";
        }
    }

    } else {
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
     <input id="field_username" type="text" name="username" minlength="3" maxlength="30" title="Introducir el username que se usará para el login. Al menos 3 carácteres, máximo 30. (Letras, números, guiones bajos son válidos)"/>
     <br>
    </p>
	<p>
    Password<br>
     <input id="field_pwd1" title="El password debe contener al menos 6 carácteres, incluyendo MAYÚSCULAS/minúsculas y números." type="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" name="pwd1"/>
     <br>
    </p>
	<p>
    Confirmar Password<br>
     <input id="field_pwd2" title="Por favor introduce el mismo password que arriba." type="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" name="pwd2" />
     <br>
    </p>
	<p>
    Número de Contacto<br>
     <input type="text" name="contactNumberFrm" minlength="3" maxlength="30" title="Al menos tres carácteres, máximo 30"/>
     <br>
    </p>
	<p>
    Nombre(s)<br>
     <input type="text" name="namesInFrm" minlength="3" maxlength="30" title="Al menos tres carácteres, máximo 30" />
     <br>
    </p>
	<p>
    Apellido Materno<br>
     <input type="text" name="lnFrm1" minlength="3" maxlength="30" title="Al menos tres carácteres, máximo 30" />
     <br>
    </p>
	<p>
    Apellido Paterno<br>
     <input type="text" name="lnFrm2" minlength="3" maxlength="30" title="Al menos tres carácteres, máximo 30" />
     <br>
    </p>
	<p>
    Mail<br>
     <input type="text" name="mlFrm" type="email" minlength="3" maxlength="60" required placeholder="Introduce un mail válido. Máximo 60 carácteres"/>
     <br>
    </p>
	<p>
    Facebook<br>
     <input type="text" name="fbkFrm" minlength="3" maxlength="60" title="Al menos tres carácteres, máximo 60" />
     <br>
    </p>
	<p>
    Meses a habilitar<br>
     <input type="text" name="monthsFrm" type="number" min="1" max="60" value="1"/>
     <br>
    </p>
	<br><br>
    <input type="submit" name="enviar" value="Registrar" class="button"/>
    </p>
</form>

</body>
</html>
