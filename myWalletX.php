<?php
include('session.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
  <link rel="stylesheet" type="text/css" href="css/home.css">
  <link rel="stylesheet" type="text/css" href="css/currentDay.css">
  <title>MyWalletX</title>

  <link rel="apple-touch-icon" sizes="76x76" href="ims/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="ims/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="ims/favicon-16x16.png">
  <link rel="manifest" href="ims/site.webmanifest">
  <link rel="shortcut icon" href="ims/favicon.ico">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="msapplication-config" content="ims/browserconfig.xml">
  <meta name="theme-color" content="#ffffff">

  <link rel="stylesheet" type="text/css" href="css/main.css">

</head>

<body>
<p>
  <div STYLE="position:absolute; TOP:72px; LEFT:945px" title="PDF Report">PDF</div>
  <a href="pdf.php">
    <img STYLE="position:absolute; TOP:93px; LEFT:945px;" src="ims/pdf.png" alt="PDF Report" width="27" height="27"
      title="PDF Report"></a>
  </p>

  <p>
  <div STYLE="position:absolute; TOP:72px; LEFT:990px">CSV</div>
  <a href="csv.php"><br>
    <img STYLE="position:absolute; TOP:93px; LEFT:990px" src="ims/xls.png" alt="CSV Report" width="27" height="27"
      title="CSV Report"></a>
  <br>
  </p>


  <div id="apDivBanner" class="border">  </div>




  <?php
  include("homeAndExit.php");
  ?>


  <?php
  require_once('db/dbConn.php');

  $days = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
  $months = array(
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre"
  );
  ?>

  <div id="apDivLeft" class="border">

    <?php include('getCategories.php'); ?>

  </div>

  <div id="apDivJoinRigth" class="border"></div>

  <div id="apDivMiddle">
    <br>
    <div class="dropdown">
      <button class="dropbtn"></button>
      <div class="dropdown-content">
        <a href="changeUserPass.php">Password</a>
        <a href="pdf/CrearGravatar.pdf">Avatar</a>
      </div>
    </div>

    <p>
      <a href="addItem.php"><br>
        <img id="item" src="ims/addItem.png" alt="Añadir Item..." width="39" height="39" title="Añadir Item!"></a>

      <a href="addCategory.php"><br>
        <img src="ims/addCategory.png" alt="Añadir Categoría..." width="39" height="39" title="Añadir Categoría!"></a>
      <br>
    </p>

    <p>
      <a href="addSaving.php"><br>
        <img src="ims/addSaving.png" alt="Registrar Ahorro..." width="39" height="39" title="Registrar Ahorro!"></a>
      <br>
    </p>

    <p>
      <a href="getCurrentStatus.php"><br>
        <img src="ims/currentStatus.png" alt="Obtener Status Actual..." width="39" height="39"
          title="Obtener Status Actual!"></a>
      <br>
    </p>

    <p>
      <a href="bars.php"><br>
        <img src="ims/bars.png" alt="Gráfico de Barras para todas las categorías..." width="39" height="39"
          title="Gráfico de Barras para todas las categorías!"></a>

      <a href="pieAll.php"><br>
        <img src="ims/pieAll.png" alt="Gráfico de Pie para todas las categorías..." width="39" width="39"
          title="Gráfico de Pie para todas las categorías!"></a>
      <br>

    <p>
      <a href="barSingle.php"><br>
        <img src="ims/barSingle.png" alt="Gráfico de Barras por categoría en específico..." width="39" height="39"
          title="Gráfico de Barras por categoría en específico!"></a>

      <a href="pieSingle.php"><br>
        <img src="ims/pieSingle.png" alt="Gráfico de Pie por categoría en específico..." width="39" height="39"
          title="Gráfico de Pie por categoría en específico!"></a>
    </p>
  </div>

  <div id="apDivRigth">
    <?php include('getItemsWithFG.php'); ?>

  </div>

  <div id="apDivDay">
    <time datetime="<?php echo date('d-m-Y'); ?>" class="icon">
      <em><?php echo $days[date("w")]; ?></em>
      <strong><?php echo $months[date('n') - 1]; ?></strong>
      <span><?php echo date("d"); ?></span>
    </time>
  </div>

</body>

</html>