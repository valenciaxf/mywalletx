<?php
require_once('session.php');
include_once('db/dbConn.php');
$dbConnX = new dbConn();

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
        window.setTimeout(function () {
            $(".alert").fadeTo(500, 0).slideUp(500, function () {
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

    include("homeAndExit.php");

    if (isset($_POST['enviar']) && $_POST['enviar'] == 'Guardar') {
        // calidate empty fields...
        if (!empty($_POST['savAmount']) && !empty($_POST['savDescription'])) {
            // init vars...
            $savAmount = $dbConnX->cleanInput($_POST['savAmount']);
            $savDescription = $dbConnX->cleanInput($_POST['savDescription']);

            mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
            try {
                $sqlInsertSav = $dbConnX->insertSaving($savAmount, $savDescription, $user_id_session);
                //echo "<div STYLE='position:absolute; TOP:600px; LEFT:492px'>The Saving has been registered.... (".$savDescription.")</div>";
                echo "<div class='alert alert-success' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                        <strong> Registro de ahorro (" . $savDescription . ") completado...</strong>
                        </div>";
            } catch (mysqli_sql_exception $e) {
                echo "<div class='alert alert-danger' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                        <strong>Ha ocurrido una excepción, favor de reportar el evento, para continuar presione el icono de Home...</strong>
                        </div>";
            }

        } else {
            //echo "<div STYLE='position:absolute; TOP:600px; LEFT:492px'>You must fill all the fields...</div>";
            echo "<div class='alert alert-warning' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                        <strong>Es necesario llenar todos los campos...</strong>
                        </div>";

        }
    }
    ?>
    <br>
    <!-- el formulario -->
    <form id="sform" name="saving" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        <p>
            <legend> Registrar Ahorro</legend>
        </p>
        <p>
            Especifica el monto del ahorro (mensual o quincenal según tus percepciones)<br>
            <input type="text" name="savAmount" pattern="\d+(\.\d{2})?"
                title="Formato: 9999999999.99 (dos decimales)" />
            <br>
        </p>
        <p>
            Descripción<br />
            <textarea name="savDescription" rows="10" cols="60" minlength="3" maxlength="99"
                title="Al menos tres carácteres, máximo 99"></textarea>
        </p>
        <p>

            <input type="submit" name="enviar" value="Guardar" class="button" />

        </p>

        <?php
        echo "El registro de ahorro en esta sección es únicamente informativo.";
        echo "<br>";
        echo "Este dato se utiliza en el cálculo de status de efectivo diario:";
        echo "<p>
<a href='getCurrentStatus.php'><img src='ims/currentStatus.png' alt='Get Current Status...'' width='39' height='39'
title=Get Current Status!''></a>
</p>";
        echo "<br>";
        echo "Hasta el momento se tiene el registro de ahorro siguiente:";
        echo "<br>";

        ?>
        <?php
        mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
        try {
            $sum = $dbConnX->getSavingAmount($user_id_session);
            echo "<span style='color: green; font-weight: bold; font-size: 120%;'>_________ " . $sum . "_________</span>";
        } catch (mysqli_sql_exception $e) {
            echo "<div class='alert alert-danger' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    <strong>Ha ocurrido una excepción, favor de reportar el evento, para continuar presione el icono de Home...</strong>
                    </div>";
        }

        ?>
    </form>

</body>

</html>