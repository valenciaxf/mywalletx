<?php  
require_once "db_config.php";
$id=$_POST["id"];
$query="DELETE FROM flutterSample  WHERE id='$id'";
$result=mysqli_query($con,$query);
if($result)
{
	echo "done";
}
else{
echo "error";
}
?>

