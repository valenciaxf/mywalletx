<?php
require_once('session.php');
?>
<style type="text/css">
.class {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-size: 18px;
	color: #666;
	text-align: left;
}
.class {
	font-weight: bold;
}
</style>

<span class="class">
<img src="ims/addCategory.png" alt="Categorías..." width=50 height=50 title="Categorías">
</span>
<?php
require_once ('db/dbConn.php');
$dbConnX=new dbConn();

$sqlQueryCat = $dbConnX->getCategory($user_id_session);

echo "<ul>";
while($rowCat = mysqli_fetch_array($sqlQueryCat)){
    echo "<li><a href='?cat_name=$rowCat[cat_name]&amp;cat_ID=$rowCat[cat_ID]'>$rowCat[cat_name]</a></li>";
}
echo "</ul>";
?>
