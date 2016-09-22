<?php 
require '../helper/functionHelper.php';
include_once '../config/DBConnect.php';
 
sec_session_start();
 
$logged = "";

if (login_check(getConnection()) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
//echo $logged;

?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>BRI Kanwil Jakarta 3</title>
  <link rel="stylesheet" href="../css/style-login.css">
  <script type="text/JavaScript" src="../js/sha512.js"></script> 
  <script type="text/JavaScript" src="../js/forms.js"></script>
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body onLoad="document.getElementById('username').focus();">
<?php 
if ($logged == "in") {
	echo "<script type='text/javascript'>
				  	window.location.href='view_atm_activitylog.php';
				  </script>";
}
?>
  <section class="container">
    <div class="login">
      <?php 
      if (isset($_GET['error'],$_SESSION['login_error'])) {
		$errMsg = $_SESSION['login_error'];
      	echo '<h2 class="error">'.$errMsg.'</h2>';
      	sec_session_destroy();
      }
      ?>
      <h1>Login</h1>
      <form method="post" action="process_login.php" name="frmLogin">
        <p><input type="text" name="username" value="" placeholder="Personal Number"></p>
        <p><input type="password" name="password" value="" placeholder="Password"></p>
        <!-- p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Ingat saya di komputer ini
          </label>
        </p-->
        <p class="submit"><input type="button" name="commit" value="Login" onclick="formhash(this.form, this.form.password);"></p>
      </form>
    </div>

    <div class="login-help">
      <p><a href="../register/register.php">Klik disini untuk Registrasi</a></p>
    </div>
  </section>
</body>
</html>
