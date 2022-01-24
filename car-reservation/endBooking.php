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

$bookingIdAx = 0;
$car = '.';

if (isset($_GET['booking_id'])) {
		$bookingIdAx = $_GET['booking_id'];
} 
if (isset($_GET['car'])) {
		$car = $_GET['car'];
} 

if (isset($_POST['disbut'])) {

	$datet = $_POST['datepicker'];
	$timep = $_POST['timepicker1'];
	$bookingIdAx = $_POST['booking_id'];
	
    $theDate    = strtotime($datet." ".$timep);
    $formatDate = date('Y-m-d G:i:00',$theDate);
	

	$AddQuery = "UPDATE booking SET datetEnd = '$formatDate' where booking_id = '$bookingIdAx'";
	mysqli_query($con, $AddQuery);
	
	header("Location: check_services.php");
}
;


?>


<div class="container">
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    	<form role="form" name="form" id="form" method="POST" >
			<h2>Fecha de entrega </h2>
			<hr class="colorgraph">
			<div class="row">

			<div class="form-group">
				<div class="form-group">
				<input type="text" name="Car" id="car" size class="form-control input-lg" tabindex="4"   value="<?php echo $car;  ?>" tabindex="4" required="true" title="Vehículo" readonly>
			</div>
			
			<div class="form-group">
				<input type="text" name="booking_id" id="booking_id" size class="form-control input-lg" placeholder="Id del Vehículo" value="<?php echo $bookingIdAx;  ?>" tabindex="4" required="true" title="Id del Vehículo">
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

