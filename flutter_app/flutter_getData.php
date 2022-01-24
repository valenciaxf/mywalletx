 <?php
require_once('db_config.php');
 $sql = "SELECT * FROM flutterSample";
 $r = mysqli_query($con,$sql);
 $result = array();
 while ($row = mysqli_fetch_array($r)) {
  array_push($result,array("id"=>$row['0'],"name"=>$row['1'],"pass"=>$row['2']));
}
echo json_encode(array("result"=>$result));

mysqli_close($con);
?>