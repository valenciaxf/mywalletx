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
if(!isset($_SESSION['POSTAX']))
{
	header("Location: index.php");
}


if (isset($_POST['save'])) {

	$bookingIdAx = $_SESSION['POSTAX'];
	unset($_SESSION['POSTAX']);

    // name of the uploaded file
    $filename = $_FILES['myfile']['name'];

    // destination of the file on the server
    $destination = 'uploadsPcdm/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
        echo "You file extension must be .zip, .pdf or .docx";
    } elseif ($_FILES['myfile']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        echo "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO files (booking_id, name, size, downloads) VALUES ($bookingIdAx, '$filename', $size, 0)";
            if (mysqli_query($con, $sql)) {
                //echo "File uploaded successfully
				header("Location: message.php");
            }
        } else {
            echo "Failed to upload file.";
        }
    }
	
	//header("Location: bookingCar.php");
}
;

?>


<div class="container">
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    	<form role="form" name="form" id="form" method="POST" enctype="multipart/form-data" >
			<h2>Cargar Archivo </h2> <br>
			<h5>El formato del nombre de archivo debe ser único, por ejemplo placasFecha.pdf </h5>
			<hr class="colorgraph">
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6">
					<div class="form-group">
						<input type="file" name="myfile">
						<br>
						<input type="submit" name="save" id="save" class="btn btn-success add_car">					
					</div>
				</div>

			</div>
			



           </div>
           </form>
           </div>
           </div>
           </div>


<?php include_once 'footer.php'; ?>

