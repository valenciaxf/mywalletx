<?php
include_once ('db/dbConn.php');
$dbConnX=new dbConn();

		$isActive = $dbConnX->checkPassport(2);
		
		if ($isActive == 1) {
				echo "Is active...";
				
		} else { 
				echo "Cuenta expirada... Actualiza tu registro.";
		}

		echo $isActive;
?>