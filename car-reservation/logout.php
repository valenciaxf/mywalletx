<?php
ob_start(); // needs to be added here
?>
<?php
session_start();
session_unset();
session_destroy();

header("location:index.php");
exit();
?>