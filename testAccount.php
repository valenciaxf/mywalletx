<?php
include('session.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/home.css">
<title>MyWalletX</title>
<style>

body
{
  font-family: "Helvetica Neue Bold", arial, helvetica, sans-serif;
  font-size: 100%;
  margin: 10px;
  color: #333;
  background-color: #cecece;
}

h1
{
  margin: 0;
  font-weight: normal;
}

time.icon
{
  font-size: 1em; /* change icon size */
  display: block;
  position: relative;
  width: 7em;
  height: 7em;
  background-color: #fff;
  margin: 2em auto;
  border-radius: 0.6em;
  box-shadow: 0 1px 0 #bdbdbd, 0 2px 0 #fff, 0 3px 0 #bdbdbd, 0 4px 0 #fff, 0 5px 0 #bdbdbd, 0 0 0 1px #bdbdbd;
  overflow: hidden;
  -webkit-backface-visibility: hidden;
  -webkit-transform: rotate(0deg) skewY(0deg);
  -webkit-transform-origin: 50% 10%;
  transform-origin: 50% 10%;
}

time.icon *
{
  display: block;
  width: 100%;
  font-size: 1em;
  font-weight: bold;
  font-style: normal;
  text-align: center;
}

time.icon strong
{
  position: absolute;
  top: 0;
  padding: 0.4em 0;
  color: #fff;
  background-color: #fd9f1b;
  border-bottom: 1px dashed #f37302;
  box-shadow: 0 2px 0 #fd9f1b;
}

time.icon em
{
  position: absolute;
  bottom: 0.3em;
  color: #fd9f1b;
}

time.icon span
{
  width: 100%;
  font-size: 2.8em;
  letter-spacing: -0.05em;
  padding-top: 0.8em;
  color: #2f2f2f;
}

time.icon:hover, time.icon:focus
{
  -webkit-animation: swing 0.6s ease-out;
  animation: swing 0.6s ease-out;
}

@-webkit-keyframes swing {
  0%   { -webkit-transform: rotate(0deg)  skewY(0deg); }
  20%  { -webkit-transform: rotate(12deg) skewY(4deg); }
  60%  { -webkit-transform: rotate(-9deg) skewY(-3deg); }
  80%  { -webkit-transform: rotate(6deg)  skewY(-2deg); }
  100% { -webkit-transform: rotate(0deg)  skewY(0deg); }
}

@keyframes swing {
  0%   { transform: rotate(0deg)  skewY(0deg); }
  20%  { transform: rotate(12deg) skewY(4deg); }
  60%  { transform: rotate(-9deg) skewY(-3deg); }
  80%  { transform: rotate(6deg)  skewY(-2deg); }
  100% { transform: rotate(0deg)  skewY(0deg); }
}
</style>

</head>
<body>
<?php
	include("homeAndExit.php");

require_once('db/dbConn.php');

		$isActive = $dbConnX->checkPassport(2);
		
		if ($isActive == 1) {
				echo "Is active...";
				
		} else { 
				echo "Cuenta expirada... Actualiza tu registro.";
		}

		echo $isActive.";-)";

		/*
  if(defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
    echo "CRYPT_BLOWFISH is enabled!";
  } else {
    echo "CRYPT_BLOWFISH is NOT enabled!";
  }
*/
$days = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
$months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto",
                "Septiembre","Octubre","Noviembre","Diciembre");

?>
<!-- the icon as a time element -->
<time datetime="<?php echo date('d-m-Y');   ?>" class="icon">
  <em><?php echo $days[date("w")];    ?></em>
  <strong><?php   echo $months[date('n')-1];      ?></strong>
  <span><?php echo date("d");    ?></span>
</time>


</body>
</html>

