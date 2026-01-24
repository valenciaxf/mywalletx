<?php
require_once('session.php');
?>
<?php
$error_message = '';
$success_message = '';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/home.css">

<link href="datePicker/calendar/calendar/calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="datePicker/calendar/calendar/calendar.js"></script>

<script src="js/jquery.min.js"></script>
<link href="bootstrap/bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="bootstrap/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>

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
if(isset($_POST['enviar']) && $_POST['enviar'] == 'Cambiar'){
    $user = $dbConnX->getUserDetails($user_id_session);

        if ($_POST['current_password'] == '') {
            $error_message = 'El password actual es requerido!';
        } elseif ($_POST['new_password'] == '') {
            $error_message = 'El nuevo password es requerido!';
        } elseif ($_POST['confirm_new_password'] == '') {
            $error_message = 'Por favor confirma tu nuevo password!';
        } elseif ($_POST['new_password'] != $_POST['confirm_new_password']) {
            $error_message = 'La confirmación no fue exitosa, introduce el nuevo password correctamente!';
        } elseif ($_POST['current_password'] == $_POST['new_password']) {
            $error_message = 'El nuevo password y el anterior no pueden ser el mismo!';
        } elseif (!$dbConnX->checkCurrentPassword($_POST['current_password'], $user['password'])) {
            $error_message = 'El password introducido no coincide con tu password actual, introduce un password válido!';
        } elseif ($dbConnX->checkCurrentPassword($_POST['current_password'], $user['password'])) {
            // update the current password and ask user to login again
            if ($dbConnX->setNewPass($user_id_session, $_POST['new_password'])) {
                $success_message = 'Password cambiado, por favor cierra tu sesión y conecta de nuevo.';
            } else {
                $error_message = 'SERVER ERROR!!!';
            }
        }
}
?>    


<div class="container">
    <div class="row">
    </div>
    <div class="form-group">
    </div>

                <?php
                    if ($error_message != '') {
                        echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $error_message . '</div>';
                    }
                    if ($success_message != '') {
                        echo '<div class="alert alert-success"><strong>Success: </strong> ' . $success_message . '</div>';
                    }
                    ?>

 <form action="changeUserPass.php" method="post">
<legend>
Introduce el password actual:
</legend>
 <input type="password" name="current_password" class="form-control" placeholder="Password Actual">
 <br> <br>
 <legend>
Nuevo password (introduce el nuevo password dos veces para confirmar que sea correcto):  </legend>

 <input type="password" name="new_password" class="form-control" placeholder="Nuevo Password"
       title="El password debe contener al menos 6 carácteres, incluyendo MAYÚSCULAS/minúsculas y números." type="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" >

 <input type="password" name="confirm_new_password" class="form-control" placeholder="Confirma el nuevo Password"
       title="Por favor introduce el mismo password que arriba." type="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}">
 <br><br>
 <input type="submit" name="enviar" class="btn btn-primary" value="Cambiar"/>

</form>
</body>
</html>