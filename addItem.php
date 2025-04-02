<?php
require_once('session.php');
?>
<?php
require_once('datePicker/calendar/calendar/classes/tc_calendar.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/home.css">

<link href="datePicker/calendar/calendar/calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="datePicker/calendar/calendar/calendar.js"></script>

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
<link rel="stylesheet" type="text/css" href="css/item.css">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<?php
include_once ('db/dbConn.php');
$dbConnX=new dbConn();
include("homeAndExit.php");

// recibimos el formulario
if(isset($_POST['enviar']) && $_POST['enviar'] == 'Guardar'){
    // comprobamos que el formulario no envie campos vacios
    if(!empty($_POST['iteCategory']) && $_POST['iteTotalAmount'] &&
    $_POST['iteQuantity'] && $_POST['iteDate'] && $_POST['iteComment']){
        // creamos las variables y les asignamos los valores a insertar
        $iteCategory = $dbConnX->cleanInput($_POST['iteCategory']);
        $iteTotalAmount = $dbConnX->cleanInput($_POST['iteTotalAmount']);
        $iteQuantity = $dbConnX->cleanInput($_POST['iteQuantity']);
		    $iteDate = $dbConnX->cleanInput($_POST['iteDate']);
        $iteComment = $dbConnX->cleanInput($_POST['iteComment']);

    //Alerts are created with the .alert class, followed by one of the four contextual classes .alert-success, .alert-info, .alert-warning or .alert-danger:
    mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
    try {
      		    $sqlInsertIte=$dbConnX->insertItem($iteCategory,$iteTotalAmount,$iteQuantity,$iteDate,$iteComment,$user_id_session);
              // confirm...
              //echo "<div STYLE='position:absolute; TOP:600px; LEFT:480px'>The item (".$iteComment.") has been registered....</div>";
              echo "<div class='alert alert-success' role='alert'>
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
              <strong> Registro de item (".$iteComment.") completado...</strong>
              </div>";
    } catch (mysqli_sql_exception  $e) {
              echo "<div class='alert alert-danger' role='alert'>
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
              <strong>Ha ocurrido una excepción, favor de reportar el evento, para continuar presione el icono de Home...</strong>
              </div>";
	  }

	}else{
		//echo "<div STYLE='position:absolute; TOP:600px; LEFT:480px'>You must fill all the fields...</div>";

          		echo "<div class='alert alert-warning' role='alert'>
          		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
          		<strong>Es necesario llenar todos los campos...</strong>
          		</div>";

    }
}
?>

<!-- form... -->
<br>
<form id="sform" name="item" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
<legend>Registrar Item  </legend>
<p>
    Monto<br />
    <input type="text" name="iteTotalAmount" size="60" pattern="\d+(\.\d{2})?" title="Formato: 9999999999.99 (dos decimales)"/>
    </p>
	<p>
    Cantidad<br />
    <input type="number" value=1 min="1" max="9999999999" name="iteQuantity" size="60" pattern="\d?" title="Formato: 9999999999 (Números)"/>
    </p>
    <p>
	Fecha<br />
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
  <p>Descripción<br />
    <textarea name="iteComment" rows="9" cols="60" minlength="3" maxlength="99" 
                        title="Al menos tres carácteres, máximo 99"></textarea>
  </p>
    <p>
    Categoría
      <select name="iteCategory">
        <option value="">Seleccionar Categoría</option>
        <?php
    //check for get item Category from DB...

    $sqlQueryCat = $dbConnX->getCategory($user_id_session);

    //show categories...
    while ($rowCat = mysqli_fetch_array($sqlQueryCat)) {
        echo "<option value='$rowCat[cat_ID]'>$rowCat[cat_name]</option>";
    }


    ?>
      </select>
      <br />
    </p>
    <p>
    <input type="submit" name="enviar" value="Guardar" class="button"/>
    </p>
</form>
<br>
<?php
$mydate = isset($_REQUEST["iteDate"]) ? $_REQUEST["iteDate"] : "";

if ($mydate!="") {
    echo "";
}//echo("value of date submit = ".$mydate);

?>


</body>
</html>