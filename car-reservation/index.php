<!DOCTYPE html>
<html>
<head>
	<title>Car Reservation System</title>
	<?php include_once 'dependencies.php';?>


<body>
<?php require 'db_connect.php';
 include_once'header.php';



?>

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="images/1.jpg" alt="First slide" height="500px" width="100%">
			<div class="carousel-caption d-none d-md-block">
		    <h5 style="font-size:40px; color:white">Bienvenido al Sistema de Reservación de Vehículos</h5>
		    <p>...</p>
		  </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class="table-responsive">
<table class="table">


</table>
</div>



<?php include_once 'footer.php'; ?>
