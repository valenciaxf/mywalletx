<?php
require_once('session.php');
?>
<style type="text/css">
.class {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-size: 13px;
	color: #666;
	text-align: left;
}
.class {
	font-weight: bold;
}
</style>

<span class="class"> 
<br>
<img src="ims/addCategory.png" alt="Categories..." width=50 height=50 title="Categories">
</span>
<?php
require_once ('db/dbConn.php');
$dbConnX=new dbConn();

$sqlQueryCat = $dbConnX->getCategory();
 
echo "<ul>";
while($rowCat = mysqli_fetch_array($sqlQueryCat)){
    echo "<li><a href='?cat_name=$rowCat[cat_name]&amp;cat_ID=$rowCat[cat_ID]'>$rowCat[cat_name]</a></li>";
}
echo "</ul>";
?>

