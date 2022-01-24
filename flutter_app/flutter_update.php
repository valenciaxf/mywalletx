<?php  
require_once "db_config.php";

$rolls=$_POST["_id"];
$names=$_POST["nm"];
$passw=$_POST["pss"];

$query="UPDATE flutterSample SET name='$names',pass='$passw' WHERE id='$rolls'";
$result=mysqli_query($con,$query);
if($result)
{
echo "done";
}
else{
echo "error";
}
?>
?>