<?php 
//include_once 'register.inc.php';
require '../helper/functionHelper.php';
require '../config/DBConnect.php';

 
sec_session_start();
 
$logged = "";

if (login_check(getConnection()) == true) {
    $logged = 'in';
    // Unset all session values
    $_SESSION = array();
    
    // get session parameters
    $params = session_get_cookie_params();
    
    // Delete the actual cookie.
    setcookie(session_name(),
    '', time() - 42000,
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]);
    
    // Destroy session
    session_destroy();
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
<!--   <link rel="stylesheet" href="../css/style-login.css"> -->
<script type="text/JavaScript" src="../js/sha512.js"></script> 
<script type="text/javascript" src="../css/utils.js"></script>
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

<script type="text/javascript">

function disabledKCList(formName,elInput,elToDisable){
		
	document.getElementById(elToDisable).disabled = true;
}
function enabledKCList(formName,elInput,elToDisable){
		
	document.getElementById(elToDisable).disabled = false;
}
</script>
</head>
<body onLoad="document.getElementById('pn').focus();" style="margin-top: 0px;margin-left: 0px;margin-right: 0px">
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
  			      | <a href="../login/login.php">Login</a> &nbsp; 
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<?php 
$branch_id=$branch_name=$branch_mbcode="";

try {
	$mysqli = getConnection();
	
	$branch_prep = "select 0 as branch_id,0 as branch_mbcode,'---- Pilih Unit Kerja ----' as branch_name 
					union all 
					SELECT distinct branch_id ,branch_mbcode,concat(branch_mbcode,' - ',branch_mbname) as branch_name 
					FROM m_branch WHERE branch_mbcode = branch_code order by branch_mbcode";
	
	$branch_stmt = $mysqli->prepare($branch_prep);
	
	if ($branch_stmt) {

		$branch_stmt->execute();
		$branch_stmt->store_result();

	}
}catch (Exception $e){

}

?>
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
					<form method="post" action="register.inc.php" name="frmLogin">
						<fieldset class="fieldset-login">
							<legend class="legend-login" align="left">
								<h3>Form Registrasi</h3>
							</legend>
							<table style="margin-left: auto; margin-right: auto;">
								<tr>
									<td colspan="3" align="center">
										 <?php 
      										if (isset($_GET['error'],$_SESSION['registration_error'])) {
      											echo '<label class="error">'.$_SESSION['registration_error'].'</label>';
      											}
      									?>
									</td>
								</tr>
								<tr>
									<td width="125px" align="left"><span style="font-size: 13px;">Personal
											Number</span></td>
									<td width="5px"></td>
									<td width="210px">
									<input type="text" id="pn" name="pn" value="<?php echo (!empty($_SESSION['reg_pn']) ? $_SESSION['reg_pn'] : "");?>"  onkeypress="return numbersonly(this, event)" size="25px">
									</td>
								</tr>
								<tr>
									<td width="105px" align="left"><span style="font-size: 13px;">Password</span>
									</td>
									<td width="5px"></td>
									<td width="210px">
									<input type="password" id="password" name="password" value="" size="25px">
									</td>
								</tr>
								<tr>
									<td width="105px" align="left"><span style="font-size: 13px;">Konfirmasi Password</span>
									</td>
									<td width="5px"></td>
									<td width="210px">
									<input type="password" name="confirmpwd" name="confirmpwd" id="confirmpwd" value="" size="25px">
									</td>
								</tr>
								<tr>
									<td width="105px" align="left"><span style="font-size: 13px;">Nama Lengkap</span>
									</td>
									<td width="5px"></td>
									<td width="210px">
									<input type="text" id="userlname" name="userlname" value="<?php echo (!empty($_SESSION['reg_username']) ? $_SESSION['reg_username'] : "");?>" size="25px">
									</td>
								</tr>
								<tr>
									<td width="105px" align="left"><span style="font-size: 13px;">Jabatan</span>
									</td>
									<td width="5px"></td>
									<td width="210px">
									<input type="text" id="jabatan" name="jabatan" value="<?php echo (!empty($_SESSION['reg_jabatan']) ? $_SESSION['reg_jabatan'] : "");?>" size="25px">
									</td>
								</tr>
								<tr>
									<td width="105px" align="left"><span style="font-size: 13px;">Email</span>
									</td>
									<td width="5px"></td>
									<td width="210px">
									<input type="text" id="email" name="email" value="<?php echo (!empty($_SESSION['reg_email']) ? $_SESSION['reg_email'] : "");?>" size="25px">
									</td>
								</tr>
								<tr>
									<td width="100px"></td>
									<td width="10px"></td>
									<td width="210px" align="left">
									<?php 
						      		$kanwilCek=$kancaCek="";
						      		if (!empty($_SESSION['reg_iskanca'])) {
						      			if ($_SESSION['reg_iskanca'] == 1){
											$kancaCek = "checked";
											 
										}else {
											$kanwilCek = "checked";
	 
										}
						      		}					      		
						      		?>
									<input type="radio" id="uker" name="uker" value="kanwil" onclick="javascript:disabledKCList('frmLogin','uker','lstKC');" 
									<?php echo $kanwilCek?>/>Kanwil
        							<input type="radio" id="uker" name="uker" value="kanca" onclick="javascript:enabledKCList('frmLogin','uker','lstKC');" 
        							<?php echo $kancaCek?>/>Kanca
        	      				</td>
								</tr>
								<tr>
									<td width="105px" align="left"><span style="font-size: 13px;">Unit Kerja</span>
									</td>
									<td width="5px"></td>
									<td width="210px">
									<select name="lstKC" id="lstKC">
						      	    <?php
						      	    if ($branch_stmt->num_rows) {
										
										$branch_stmt->bind_result($branch_id, $branch_mbcode,$branch_name);
										
										while ($branch_stmt->fetch()){
											if (!empty($_SESSION['reg_idkanca']) && $branch_id == $_SESSION['reg_idkanca']) {
												echo '<option value="'.$branch_id.'" selected>'.$branch_name.'</option>';
											}else
												echo '<option value="'.$branch_id.'">'.$branch_name.'</option>';
										}
						      	    	
						      	    }
						      	    
						      		?>
						      		</select>
									</td>
								</tr>
								<tr>
									<td colspan=3></td>
								</tr>
								<tr>
									<td width="100px"></td>
									<td width="10px"></td>
									<td width="210px" align="left">
									<input type="button" type="button" id="commit" name="commit" value="Register" 
      	        						onclick="return regformhash(this.form,
      	                                   this.form.userlname,
      	                                   this.form.password,this.form.confirmpwd,
      	                                   this.form.pn,this.form.jabatan,this.form.email,
      	                                   this.form.uker,this.form.lstKC);" class="art-button">
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
							</table>
						</fieldset>
					</form>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
