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

  <script src="js/jquery.min.js"></script>
  <link href="bootstrap/bootstrap-4.4.1-dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="bootstrap/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>

  <script language="javascript">
    window.setTimeout(function () {
      $(".alert").fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
      });
    }, 4000);

  </script>

  <link rel="stylesheet" type="text/css" href="css/home.css">
  <link href="css/styleLog.css" rel="stylesheet" type="text/css">

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <style>
    h3 {
      text-align: center;
    }

    p {
      text-align: center;
    }

    div {
      text-align: center;
    }
  </style>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<div class="container d-flex align-items-center justify-content-center min-vh-100">
  <div class="row w-100">
    <div class="col-12 col-sm-8 col-md-6 col-lg-4 mx-auto">
      <div id="main">
        <div id="login" class="card p-4 shadow-sm">
          <h2 class="text-center mb-4">Login</h2>
          <div class="text-center mb-3">
            <img src="ims/logoMWX_a.png" style="width:207px;height:93px;" alt="Logo" class="img-fluid" />
          </div>
          <form action="" method="post">
            <div class="form-group mb-3">
              <label for="name"><b>Usuario:</b></label>
              <input id="name" name="username" placeholder="Usuario" type="text" class="form-control">
            </div>
            <div class="form-group mb-3">
              <label for="password">Password:</label>
              <input id="password" name="password" placeholder="**********" type="password" class="form-control">
            </div>
            <div class="d-grid mb-2">
              <input name="submit" type="submit" value="Iniciar" class="btn btn-primary btn-block">
            </div>
            <span class="text-danger"><?php echo $error; ?></span>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</body>

</html>