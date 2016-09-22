<?php 
require '../helper/validateHelper.php';
require '../helper/functionHelper.php';
require '../config/DBConnect.php';

sec_session_start();

$logged = "";

if (login_check(getConnection()) == true) {
	$logged = 'in';
	
} else {
	$logged = 'out';
	//sec_session_destroy();
	$_SESSION["login_error"] = "Halaman tidak dapat diakses, silahkan login terlebih dahulu.";
	header('Location: ../login/login.php?error=1');
	session_write_close();
}


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
</style>

<script type="text/javascript">

function disabledKCList(formName,elInput,elToDisable){
		
	document.getElementById(elToDisable).disabled = true;
}
function enabledKCList(formName,elInput,elToDisable){
		
	document.getElementById(elToDisable).disabled = false;
}

function submitSave(form,
					user_id,
					user_lname,
     				user_password,
     				confirmpwd,
     				user_jabatan,
     				user_email,
     				user_uker,
     				select_kanca){
	
	if(upduserformhash(form,
				user_lname,
				user_password,
				confirmpwd,
				user_jabatan,
				user_email,
				user_uker,
				select_kanca)){

		if(confirm('Anda yakin ingin menyimpan?')){
			// Create a new element input, this will be our hashed password field. 
		    var p = document.createElement("input");
		    var action = document.createElement("input");
			var saveaction = document.createElement("input");
		 
		    // Add the new element to our form. 
		    form.appendChild(p);
		    p.name = "p";
		    p.type = "hidden";
		    p.value = hex_sha512(user_password.value);
		    //alert(p.value);
		    // Make sure the plaintext password doesn't get sent. 
		    user_password.value = "";
		    confirmpwd.value = "";

			 // Add the new element to our form. 
		    form.appendChild(action);
		    action.name = "user_id";
		    action.type = "hidden";
		    action.value = user_id;

		    form.appendChild(saveaction);
		    saveaction.name = "saveaction";
		    saveaction.type = "hidden";
		    saveaction.value = "update_user_profile";
		    // Finally submit the form. 
		    form.submit();
			}
		
	}
	
}
</script>
</head>
<body onLoad="document.getElementById('user_pn').focus();" style="margin-top: 0px;margin-left: 0px;margin-right: 0px">
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
  			      | <a href="../login/logout.php" onclick="return konfirmasi('Anda yakin ingin logout?')">Logout</a> &nbsp; 
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<?php 
$branch_id=$branch_name=$branch_mbcode="";
$user_lname=
$user_pn=
$user_jabatan=
$user_uker=
$user_email=
$user_branch_id=
$user_id =
$error_msg = "";

try {
	if (!empty($_SESSION["user_id"])){
		$user_id = $_SESSION["user_id"];
		
	}
	
	$mysqli = getConnection();
	
	if (!empty($_POST["saveaction"])){
		$saveaction = $_POST["saveaction"];
		
		$txtPassword = mysqli_real_escape_string($mysqli,$_POST["p"]);
		// Create a random salt
		//$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
		$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
		
		// Create salted password
		$password = hash('sha512', $txtPassword . $random_salt);
	
		if ($_POST["user_uker"] == "kanca") {
			$iskanca = 1;
			$idKanca = $_POST["select_kanca"];
		}else {
			$iskanca = 0;
			$idKanca = 0;
		}
		
		//$password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
		if (strlen($password) != 128) {
			// The hashed pwd should be 128 characters long.
			// If it's not, something really odd has happened
			$error_msg .= '<p class="error">Konfigurasi password tidak valid.</p>';
		}
		
		if (empty($error_msg)) {
			// Update the data into the database
			$insert_prep = "UPDATE m_user
							SET user_lname = ?,
							  user_jabatan = ?,
							  user_uker = ?,
							  user_email = ?,
							  user_branch_id = ?,
							  user_password = ?,
							  user_salt = ?,
							  user_upddt = ?,
							  user_updusr = ?
							WHERE user_id = ? ;";
		
			$insert_stmt = $mysqli->prepare($insert_prep);
		
			if ($insert_stmt) {
		
				$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
				if (!empty($_SESSION['user_pn'])) {
					$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);;
				}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
					
				$insert_stmt->bind_param('ssisisssss',
						validateInput($_POST['user_lname']),
						validateInput($_POST['user_jabatan']),
						validateInput($iskanca),
						validateInput($_POST['user_email']),
						validateInput($idKanca),
						validateInput($password),
						validateInput($random_salt),
						validateInput($txtUpdateDt),
						validateInput($txtUpdateUser),
						$user_id);
	
// 	echo $_POST['user_lname'];
// 	echo $_POST['user_jabatan'];
// 	echo $iskanca;
// 	echo $_POST['user_email'];
//	echo $idKanca;
//	echo $password;
// 	echo $random_salt;
// 	echo $txtUpdateDt;
// 	echo $txtUpdateUser;
// 	echo $user_id;
				// Execute the prepared query.
				if (! $insert_stmt->execute()) {
					echo "<script type='text/javascript'>
						alert('Terjadi kesalahan saat menyimpan data.');
					  </script>";
				}else {
					loginAfterUpdateUser($user_id, $password, $mysqli);
					echo "<script type='text/javascript'>
										alert('Data berhasil disimpan.');
									  </script>";
					}
			}else{
				echo "<script type='text/javascript'>
						alert('Terjadi kesalahan saat menyimpan data.');
					  </script>";
				/* header('Location: ../kanwiljak3/error.php?error=1');
				 session_write_close(); */
			}
				
		}
	}
	if (!empty($_SESSION["user_id"])){
		$user_id = $_SESSION["user_id"];
		$user_lname=$_SESSION['user_name'];
		$user_pn= $_SESSION['user_pn'];
		$user_jabatan=$_SESSION['user_jabatan'];
		$user_uker=$_SESSION['user_uker'];
		$user_email=$_SESSION['user_email'];
		$user_branch_id=$_SESSION['user_branch_id'];
	
	}
	
	
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
			<td>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="frmLogin">
						<fieldset class="fieldset-login">
							<legend class="legend-login" align="left">
								<h3>User Profile</h3>
							</legend>
							<table style="margin-left: auto; margin-right: auto;">
								<tr>
									<td colspan="3" align="center">
										 <?php 
      										if (isset($_SESSION['update_user_error'])) {
      											echo '<label class="error">'.$_SESSION['update_user_error'].'</label>';
      											}
      									?>
									</td>
								</tr>
								<tr>
									<td width="125px" align="left"><span style="font-size: 13px;">Personal
											Number</span></td>
									<td width="5px"></td>
									<td width="210px"><span style="font-size: 13px;"><?php echo $user_pn;?></span>
									</td>
								</tr>
								<tr>
									<td width="105px" align="left"><span style="font-size: 13px;">Password</span>
									</td>
									<td width="5px"></td>
									<td width="210px">
									<input type="password" id="user_password" name="user_password" value="" size="25px">
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
									<input type="text" id="user_lname" name="user_lname" value="<?php echo $user_lname;?>" size="25px">
									</td>
								</tr>
								<tr>
									<td width="105px" align="left"><span style="font-size: 13px;">Jabatan</span>
									</td>
									<td width="5px"></td>
									<td width="210px">
									<input type="text" id="user_jabatan" name="user_jabatan" value="<?php echo $user_jabatan;?>" size="25px">
									</td>
								</tr>
								<tr>
									<td width="105px" align="left"><span style="font-size: 13px;">Email</span>
									</td>
									<td width="5px"></td>
									<td width="210px">
									<input type="text" id="user_email" name="user_email" value="<?php echo $user_email;?>" size="25px">
									</td>
								</tr>
								<tr>
									<td width="100px"></td>
									<td width="10px"></td>
									<td width="210px" align="left">
									<?php 
						      		$kanwilCek=$kancaCek="";
						      		if (isset($_SESSION['user_uker'])) {
						      			if ($_SESSION['user_uker'] == 1){
											$kancaCek = "checked";
											 
										}else {
											$kanwilCek = "checked";
	 
										}
						      		}					      		
						      		?>
									<input type="radio" id="user_uker" name="user_uker" value="kanwil" onclick="javascript:disabledKCList('frmLogin','user_uker','select_kanca');" 
									<?php echo $kanwilCek?>/>Kanwil
        							<input type="radio" id="user_uker" name="user_uker" value="kanca" onclick="javascript:enabledKCList('frmLogin','user_uker','select_kanca');" 
        							<?php echo $kancaCek?>/>Kanca
        	      				</td>
								</tr>
								<tr>
									<td width="105px" align="left"><span style="font-size: 13px;">Unit Kerja</span>
									</td>
									<td width="5px"></td>
									<td width="210px">
									<select name="select_kanca" id="select_kanca">
						      	    <?php
						      	    if ($branch_stmt->num_rows) {
										
										$branch_stmt->bind_result($branch_id, $branch_mbcode,$branch_name);
										
										while ($branch_stmt->fetch()){
											if ($branch_id == $user_branch_id) {
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
									<input type="button" type="button" id="commit" name="commit" value="Simpan" 
      	        						onclick="submitSave(this.form,
														<?php echo $user_id;?>,
														this.form.user_lname,
      	                                   				this.form.user_password,
      	                                   				this.form.confirmpwd,
      	                                   				this.form.user_jabatan,
      	                                   				this.form.user_email,
      	                                   				this.form.user_uker,
      	                                   				this.form.select_kanca);" class="art-button"/>
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
