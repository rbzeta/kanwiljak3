<?php 
require '../helper/functionHelper.php';
include_once '../config/DBConnect.php';
 
sec_session_start();
 
$logged = "";

if (login_check(getConnection()) == true) {
    $logged = 'in';
    echo "<script type='text/javascript'>
			alert('Anda sudah login.');
    		url = '../index.php';
    		var ua        = navigator.userAgent.toLowerCase(),
        	isIE      = ua.indexOf('msie') !== -1,
        	version   = parseInt(ua.substr(4, 2), 10);

		    // Internet Explorer 8 and lower
		    if (isIE && version < 9) {
		        var link = document.createElement('a');
		        link.href = url;
		        document.body.appendChild(link);
		        link.click();
		    }
		
		    // All other browsers
		    else { window.location.href = url; }
		 </script>";
    
} else {
    $logged = 'out';
}
//echo $logged;

?>
<html>
<head>
<title>BRI Kanwil Jakarta 3</title>
  <script type="text/JavaScript" src="../js/sha512.js"></script> 
  <script type="text/JavaScript" src="../js/forms.js"></script>
<style type="text/css">
.art-button
{
   	border: 0;   	
   	padding:0 10px;
   	margin:0 auto;
   	height:25px;
	font-size:12px;
	font-family: 'Trebuchet MS', Arial, Helvetica, Sans-Serif;
	background:#00699B;
	color:#FFFFFF;
	font-weight:bold;
}

.art-button button:hover
{
	background:#F00;
}

.login-help {
  margin: 20px 0;
  font-size: 14px;
  color: #00509a;
  text-align: center;
/*   text-shadow: 0 1px #ff980A; */
}
.login-help a {
  color: black;
  text-decoration: none;
}
.login-help a:hover {
  text-decoration: underline;
}

.error {
	color: red;
	font-weight: bold;
}
a {
		text-decoration: none;
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
	}
	
	a.underline {
		text-decoration: underline;
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
	}
	
body { 
 background-image: url("../resource/a.png");
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: full;
}
</style>
</head>
<body onLoad="document.getElementById('username').focus();" style="margin-top: 0px;margin-left: 0px;margin-right: 0px">


<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="left" class="style4" bgcolor="#00509a"> 
		<div style="font-size:28px;  color:#FFFFFF;font-weight:bold; ">
			<label style="padding-left: 40px;">&nbsp </label>
			</div>
		<div style="font-size:18px;  color:#FFFFFF; font-weight:bold;">
			<label style="padding-left: 40px;">&nbsp </label>
		</div>
		</td>
		
	</tr>
	<tr>
		<td>
		<table cellpadding="2" width="100%" border="0" cellspacing="0" bgcolor="ff980A">
			<tr>
				<td align="right" ><a href="../index.php">Dashboard</a>
  			      | <a href="../register/register.php">User Registrasi</a> &nbsp; 
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
	<div class="form_right">
		<table style="width: 500px; margin-left: auto; margin-right: auto;">
			<tr>
				<td align="center">
				<p><div style="font-size:28px;  color:#00509a;font-family: 'Arial Black',Tahoma, Verdana, Arial, Helvetica, Sans-Serif; font-weight:bold; ">Bank Rakyat Indonesia </div> 
	  			<div style="font-size:22px;  color:#ff980A; font-weight:bold;">Portal Kanwil Jakarta 3</div>
				</td>
			</tr>
			<tr>
			<td>
					<form method="post" action="process_login.php" name="frmLogin">
						<fieldset class="fieldset-login">
							<legend class="legend-login" align="left">
								<h3>LOGIN</h3>
							</legend>
							<table style="margin-left: auto; margin-right: auto;">
								<tr>
									<td width="105px" align="right"><span style="font-size: 13px;">Personal
											Number</span></td>
									<td width="5px"></td>
									<td width="210px">
									<input type="text" id="username" name="username" value="" size="25px" placeholder="Personal Number">
									</td>
								</tr>
								<tr>
									<td width="105px" align="right"><span style="font-size: 13px;">Password</span>
									</td>
									<td width="5px"></td>
									<td width="210px">
									<input type="password" name="password" value="" size="25px" placeholder="Password" onkeydown="if (event.keyCode == 13) document.getElementById('commit').click()">
									</td>
								</tr>
								<tr>
									<td colspan=3></td>
								</tr>
								<tr>
									<td width="100px"></td>
									<td width="10px"></td>
									<td width="210px" align="left">
									<input type="button" id="commit" name="commit" value="Login" onclick="formhash(this.form, this.form.password);" class="art-button">
									</td>
								</tr>
								<tr>
									<td colspan="3" align="center">
										<?php 
									      if (isset($_GET['error'],$_SESSION['login_error'])) {
											$errMsg = $_SESSION['login_error'];
									      	echo '<label class="error">'.$errMsg.'</label>';
									      	sec_session_destroy();
									      }
									      ?>
									</td>
								</tr>
								<tr>
<!-- 									<td colspan="3" align="center"> -->
<!-- 										<div class="login-help"> -->
<!-- 									      <p><a href="../register/register.php">Klik disini untuk Registrasi</a></p> -->
<!-- 									    </div> -->
<!-- 									</td> -->
								</tr>
							</table>
						</fieldset>
					</form>
				</td>
			</tr>
		</table>
	</div>
</body>

</html>
