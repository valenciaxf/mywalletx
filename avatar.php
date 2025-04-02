<?php
require_once('session.php');
?>
<?php
$user = $dbConnX->getMail($user_id_session);
if (empty($user)) {
     $email = '';
} else {
     $email = $user['mail'];
}

$default = "ims/settings.png";
$size = 42;

$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/home.css">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
.avatar {
  vertical-align: middle;
  width: 39px;
  height: 39px;
  border-radius: 50%;
  position:absolute; TOP:21px; LEFT:174px;
}
</style>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<img src="<?php echo $grav_url; ?>" alt="Avatar" class="avatar" />

</body>
</html>   



