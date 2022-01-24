<?php
include('login.php'); // Includes Login Script

/*if(isset($_SESSION['login_user'])){
header("location: myWalletX.php");
}*/
?>
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html>
  <head>
    <title>Login MyWalletX</title>

  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" />
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

  <script language="javascript">
  window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
  }, 4000);

  </script>

  <link rel="stylesheet" type="text/css" href="css/home.css">
  <link href="css/styleLog.css" rel="stylesheet" type="text/css">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style>
h3 {text-align: center;}
p {text-align: center;}
div {text-align: center;}
</style>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<div id="main">

<div id="login">
<b>
<h2>Login</h2>
</b>

<h3>MyWalletX</h3>
<h3>Inicio de Sesión</h3>

<form action="" method="post">
  <br>
<b>Usuario: </b>
<input id="name" name="username" placeholder="Usuario" type="text">
<br>
<br>
<label>Password: </label>
<input id="password" name="password" placeholder="**********" type="password">
<br>
<br>
<input name="submit" type="submit" value=" Iniciar ">
<span><?php echo $error; ?></span>
</form>
</div>
</div>

</body>
</html>
