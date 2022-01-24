<?php
ob_start(); // needs to be added here
?>
<!DOCTYPE html>
<html>
<head>
	<title>Book Test Drive</title>

	<?php include_once 'dependencies.php'; ?>
</head>
<body>
<?php require 'db_connect.php';

include_once 'header.php';

$select_user = (int) $_SESSION['userSession'];
if(!isset($_SESSION['userSession']))
{
	header("Location: index.php");
}

$carIdAx = 0;

if (isset($_GET['car_id'])) {
		$carIdAx = $_GET['car_id'];
} 

if (isset($_POST['disbut'])) {

	$fn = $_POST['first_name'];
	$ln = $_POST['last_name'];
	$mail = $_POST['email'];
	$ph = $_POST['phone'];
	$datet = $_POST['datepicker'];
	$timep = $_POST['timepicker1'];
	$carIdAx = $_POST['car_id'];
	
    $theDate    = strtotime($datet." ".$timep);
    $formatDate = date('Y-m-d G:i:00',$theDate);
	

	$AddQuery = "INSERT INTO booking (user_id,first_name, last_name, email, phone, datet, status, car_id)
    VALUES ('$select_user', '$fn','$ln', '$mail', '$ph', '$formatDate', 0, $carIdAx)";
	mysqli_query($con, $AddQuery);
	$bookingIdAx = $con->insert_id;
	
	$_SESSION['POSTAX'] = $bookingIdAx;
	
	$AddQuery2 = "UPDATE car2 SET status = 1 where car_id = '$carIdAx'";
	mysqli_query($con, $AddQuery2);
	
	header("Location: uploadResFile.php");
}
;


?>


<div class="container">
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    	<form role="form" name="form" id="form" method="POST" >
			<h2>Detalles de la reservación </h2>

			<hr class="colorgraph">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
                        <input type="text" name="first_name" id="first_name" class="form-control input-lg" placeholder="Nombre" tabindex="1" required="true">
					</div>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="text" name="last_name" id="last_name" class="form-control input-lg" placeholder="Apellido" tabindex="2" required="true">
					</div>
				</div>
			</div>
			<div class="form-group">
				<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" tabindex="3" required="true">
				</div>
				<div class="form-group">
				<input type="text" name="phone" id="phone" size class="form-control input-lg" placeholder="Teléfono" tabindex="4" required="true">
			</div>
			
			<div class="form-group">
			ID del Vehículo <h5><a href="account.php">(Consultar Vehículos Disponibles)</a></h5><br>
				<input type="text" name="car_id" id="car_id" size class="form-control input-lg" placeholder="Id del Vehículo" value="<?php echo $carIdAx;  ?>" tabindex="4" required="true" title="Id del Vehículo">
			</div>

			<div class="form-group">
			Fecha <br>
			<input type="date" name="datepicker" id="datepicker" required="true"><br><br>

			</div>
<div class="form-group">
			  <div class="input-group bootstrap-timepicker timepicker">
            <input id="timepicker1" name="timepicker1" type="text" class="form-control input-small" required="true">
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
        </div>
        </div>

<input type="submit" name="disbut" id="disbut" class="btn btn-success add_car">


           </div>
           </form>
           </div>
           </div>
           </div>


<?php include_once 'footer.php'; ?>

