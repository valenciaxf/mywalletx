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

if(isset($_POST['enviar']) && $_POST['enviar'] == 'Guardar'){
    // validate empty fields...
    if(!empty($_POST['catCategory']) && !empty($_POST['catDescription']) && !empty($_POST['catType'])){
        // init vars...
        $catCategory = $dbConnX->cleanInput($_POST['catCategory']);
		$catDescription = $dbConnX->cleanInput($_POST['catDescription']);
		$catType = $dbConnX->cleanInput($_POST['catType']);

    mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
    try {
              		$sqlInsertCat=$dbConnX->insertCategory($catCategory,$catDescription,$catType,$user_id_session);
              	  // confirm...
                  echo "<div class='alert alert-success' role='alert'>
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                  <strong>La categoría ha sido registrada (".$catCategory.")...</strong>
                  </div>";
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
   <legend> Añadir Categoría</legend>
   </p>
   <p>
    Nombre<br>
     <input type="text" size="15" name="catCategory" minlength="1" maxlength="45" title="Al menos 1 carácter, máximo 45" />
     <br><br>
    </p>
    <p>
    Descripción<br />
    <textarea name="catDescription" rows="9" cols="60" minlength="3" maxlength="99" title="Al menos tres carácteres, máximo 99"></textarea>
    </p>
    <p>

	Tipo<br>
		<select name="catType">
		<option value="OUT" name="out"> Egreso </option>
		<option value="IN" selected="selected" name="in"> Ingreso </option>
		</select><br><br>

	    <input type="submit" name="enviar" value="Guardar" class="button"/>

    </p>
</form>

</body>
</html>
