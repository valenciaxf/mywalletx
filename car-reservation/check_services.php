<?php
ob_start(); // needs to be added here
?>
<!DOCTYPE html>
<html>
<head>
	<title>Check Services</title>
	<?php include_once 'dependencies.php';?>
	
<script type='text/javascript'>
function confirmDelete()
{
   return confirm("Are you sure you want to delete this?");
}
</script>

<body>
<?php
require 'db_connect.php';
include_once 'header.php';
$select_user = (int) $_SESSION['userSession'];
if (!isset($_SESSION['userSession'])) {
	header("Location: index.php");
}

$select_service = "select b.car_id, c.name, model, year, b.booking_id, first_name, last_name, email, phone, DATE_FORMAT(datet, '%d/%m/%Y %H:%i:%s') datet, 
					DATE_FORMAT(datetEnd, '%d/%m/%Y %H:%i:%s') datetEnd, b.status, f.name fileName
					from booking b, car2 c, files f
					where b.car_id = c.car_id and b.status = 0 and b.booking_id = f.booking_id";
$result2 = $con->query($select_service);

if (isset($_POST['delete_car_service'])) {
	$hidden = $_POST['hidden_service'];
	$DeleteQuery = "DELETE FROM booking WHERE
    booking_id='$hidden'";
	mysqli_query($con, $DeleteQuery);
	header("Location: check_services.php");
}

if (isset($_POST['submit_status'])) {
	$status = $_POST['checkbox'];
	if ($status) {
		$status = 1;
	}
	if (!$status) {
		$status = 0;
	}

	$hidden = $_POST['hidden_service'];
	$hidden2 = $_POST['hidden_car'];

	$EditQuery = "UPDATE `booking` SET `status` = '$status' WHERE booking_id = '$hidden';";
	mysqli_query($con, $EditQuery);

	$AddQuery = "UPDATE car2 SET status = 0 where car_id = '$hidden2'";
	mysqli_query($con, $AddQuery);
	
	header("Location: check_services.php");

}?>

<br><br><br>
<hr class="colorgraph">

<br>
  <table><caption>
  <h3>Vehículos En Renta</h3>
  <h5>Da clic en "Vehículo Reservado" para actualizar la fecha de entrega</h5>
  <h5>Da clic en "Fecha Inicio" para consultar el archivo de la reservación</h5>
  <h5>Da clic en "Actualizar" para confirmar la entrega física de la unidad</h5>
  </caption>
  
   <tr>
     <th>Vehículo</th>
     <th>Modelo</th>
     <th>Año</th>
      <th>ID de la Reserva</th>
       <th>Nombre Cliente</th>
        <th>Apellido</th>
        <th>Mail</th>
        <th>Telefóno</th>
        <th>Fecha Inicio</th>
        <th>Fecha Término</th>
        <th>Entregado?</th>
        <th>Registrar Fecha Cierre</th>
     </tr>
<?php
		while ($row2 = $result2->fetch_assoc()) {

			if ($row2['status'] == 0) {
				$msg = "Vehículo Reservado";
			} else if ($row2['status'] == 1) {
				$msg = "Vehículo entregado";
			}
			
			echo "<form action=check_services.php method=post>";
			echo "<tr>";
			//echo "<td name>" . $row2['car_id'] . " </td>";
			echo "<td>" . $row2['name'] . " </td>";
			echo "<td>" . $row2["model"] . " </td>";
			echo "<td>" . $row2["year"] . " </td>";
			echo "<td>" . $row2["booking_id"] . " </td>";
			echo "<td>" . $row2["first_name"] . " </td>";
			echo "<td>" . $row2["last_name"] . " </td>";
			echo "<td>" . $row2["email"] . " </td>";
			echo "<td>" . $row2["phone"] . " </td>";
			echo "<td><a href='uploadsPcdm/".$row2["fileName"]."'>" . $row2["datet"] . " </a></td>";
			echo "<td>" . $row2["datetEnd"] . " </td>";
			if ($row2['status'] == 0) {
				echo "<td>" . "<input type='checkbox' name='checkbox'>" . " </td>";

			}
			if ($row2['status'] == 1) {
				echo "<td>" . "<input type='checkbox' name='checkbox' checked>" . " </td>";

			}

			echo "<td> <a href='endBooking.php?booking_id=".$row2["booking_id"]."&car=". $row2['name']."_".$row2['model']."_".$row2['year']."'> 
							<h5>" . $msg . "</h5> 
					   </a> 
				</td>";

			echo "<td>" . "<input type=submit name=submit_status value='Actualizar'" . " </td>";

			echo "<input type=hidden name=hidden_service  value=" . $row2["booking_id"] . " </td>";
			echo "<input type=hidden name=hidden_car  value=" . $row2["car_id"] . " </td>";
			echo "<td>" . "<input type=submit name=delete_car_service value='Eliminar' onclick='return confirmDelete()' " . " </td>";
			echo "</tr>";
			echo "</form>";
		}
?>
</table>
<hr class="colorgraph">

<?php include_once 'footer.php';?>