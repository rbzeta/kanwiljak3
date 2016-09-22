<?php
require '/config/DBConnect.php';
require '/helper/validateHelper.php';
require '/helper/functionHelper.php';
sec_session_start();
$logged = "";
$isUker = false;
$strUker = "Team Kanwil";
$strUker2 = "Team Kanca";

if (login_check(getConnection()) == true) {
	$logged = 'in';
	//test user session
	if (isset($_SESSION['user_id'],$_SESSION['login_string'])) {
		if ($_SESSION['user_uker']) {
			$isUker = 1;
			$strUker = "Team Kanca";
			$strUker2 = "Team Kanwil";
		}
		/* echo "Welcome : ".$_SESSION['user_name'];
		echo "<br>PN : ".$_SESSION['user_pn'];
		echo "<br>Jabatan : ".$_SESSION['user_jabatan'];
		echo "<br>Level ID : ".$_SESSION['user_level_id'];
		echo "<br>Is Uker : ".$_SESSION['user_uker'];
		echo "<br>Email : ".$_SESSION['user_email'];
		echo "<br>Branch ID : ".$_SESSION['user_branch_id'];
		echo "<br>Status : ".$_SESSION['user_status'];
		echo "<br>Branch Code : ".$_SESSION['user_branch_code'];
		echo "<br>Branch Name : ".$_SESSION['user_branch_name'];
		echo "<br><a href='/kanwiljak3/input_atm_activitylog.php'>Input Aktivitas    </a>";
		echo "<a href='/kanwiljak3/view_atm_activitylog.php'>Lihat Aktivitas    </a>";
		echo "<a href='logout.php'>Log out</a>"; */
	}
} else {
	$logged = 'out';
	$_SESSION["login_error"] = "Halaman tidak dapat diakses, silahkan login terlebih dahulu.";
	header('Location: ../kanwiljak3/login.php?error=5');
	session_write_close();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BRI Kanwil Jakarta 3</title>
<script type="text/javascript" src="css/jquery-1.6.4.min.js"></script>
<script src="js/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script>
<style type="text/css">@import "css/smoothness.datepick.css";</style>
<style type="text/css">@import "css/menu.css";</style>
<style type="text/css">@import "css/form.css";</style>
<style type="text/css">@import "css/table.css";</style>
<script type="text/javascript" src="css/jquery.datepick.js"></script>
<script type="text/javascript" src="css/utils.js"></script>
<script type="text/JavaScript" src="js/forms.js"></script>
<script type="text/JavaScript" src="js/sha512.js"></script>
<script type="text/JavaScript" src="js/tes.js"></script>
<script type="text/javascript">
function disabledKCList(formName,elInput,elToDisable){
	document.getElementById(elToDisable).disabled = true;
}
function enabledKCList(formName,elInput,elToDisable){
	
	document.getElementById(elToDisable).disabled = false;
}
$(function(){
    $("input:checkbox, input:radio, input:file, select").uniform();
  });
function submitForm(form,submit){
	if(confirm('Anda yakin ingin menyimpan?')){
		submit.value = "submitted";
		form.submit();
	}
}
</script>
</head>
	
<body style="margin-top: 0px;margin-left: 0px;margin-right: 0px">
<div class="container">
<div id="header">
<?php 
include '../global/header.php';
?>
</div>
<div id="menu" class="sidebar">
<?php 
include '../atm/sidebar.php';
?>
</div>
<?php 
date_default_timezone_set("Asia/Jakarta");

$errID=$errUserPN=$errPassword=$errKonfirm=$errUserName=$errJabatan=$errEmail=$errKanwilCek=$errUserUker=$errBranch="";
$userID=$userPN=$password=$konfpassword=$username=$jabatan=$email=$kanwilCek=$kancaCek=$userUker=$userBranchID="";
$isDataValid=$isSaveSuccess = true;
			
$sqlKriteria = "";
$sqlUpdate = "";

try {
	//isi data dari session
	$userID = $_SESSION['user_id'];
	$userPN = $_SESSION['user_pn'];
	$username = $_SESSION['user_name'];
	$jabatan = $_SESSION['user_jabatan'];
	$email = $_SESSION['user_email'];
	$userUker=$_SESSION['user_uker'];
	$userBranchID = $_SESSION['user_branch_id'];
	
	if ($userUker == 1){
		$kanwilCek = "checked";
	}else $kancaCek = "checked";
	
	$con = getConnection();
	if (!empty($con)) {
		
		$lstBranch = getQueryResult($con,"select 0 as branch_id,0 as branch_mbcode,'---- Pilih Unit Kerja ----' as branch_name union all SELECT distinct branch_id ,branch_mbcode,concat(branch_mbcode,' - ',branch_mbname) as branch_name FROM m_branch order by branch_mbcode");
	
	if(isset($_POST["btnSimpan"]) || isset($_POST["actionsubmit"] )){
		if (!empty($_POST["isKanwil"])){
				
				if ($_POST["isKanwil"] == "kanwil"){
					$kanwilCek = "checked";
					$isKanwil = 0;
				}else {
					$kancaCek = "checked";	
					$isKanwil = 1;
				}
		}else{
			$$errKanwilCek = "* Field Kanwil/Kanca wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}
		
		if(empty($_POST["txtUserPN"])){
			$errUserPN = "* Field Personal Number wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtUserPN =  mysqli_real_escape_string($con,$_POST["txtUserPN"]);
		}
				
		if(empty($_POST["p"])){
			$errPassword = "* Field Password wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtPassword = mysqli_real_escape_string($con,$_POST["p"]);
			// Create a random salt
			//$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
			$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
			
			// Create salted password
			$password = hash('sha512', $txtPassword . $random_salt);
		}
		
		if(empty($_POST["txtUserName"])){
			$errUserName = "* Field Nama Lengkap wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtUserName = mysqli_real_escape_string($con,$_POST["txtUserName"]);
		}
		
		if(empty($_POST["txtJabatan"])){
			$errJabatan = "* Field Jabatan wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtJabatan = mysqli_real_escape_string($con,$_POST["txtJabatan"]);
		}
		
		if(empty($_POST["txtEmail"])){
			$errEmail = "* Field Email wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtEmail = mysqli_real_escape_string($con,validateInput($_POST["txtEmail"]));
		
		}
		
		if($isKanwil == 1){
			//$errBranch = "* Field Unit Kerja wajib diisi.";
			$txtBranch = 0;
		}else {
			$txtBranch = mysqli_real_escape_string($con,$_POST["lstBranch"]);
		}
		
		if($isDataValid){
			
			$errID=$errUserPN=$errPassword=$errKonfirm=$errUserName=$errJabatan=$errEmail=$errKanwilCek=$errUserUker=$errBranch="";

			//sementara hardcode, seharusnya dari session login
			//$txtCreateDt = mysqli_real_escape_string($con,date("Y/m/d H:i:s"));
			$txtUpdateDt = mysqli_real_escape_string($con,date("Y/m/d H:i:s"));
			//$txtCreateUser = mysqli_real_escape_string($con,"ADMIN");
			$txtUpdateUser = mysqli_real_escape_string($con,$_SESSION['user_pn']);
			
			$sqlUpdate = "UPDATE m_user SET 
						user_lname='".$txtUserName."',
						user_password='".$password."',
						user_pn='".$txtUserPN."',
						user_jabatan='".$txtJabatan."',
						user_uker=".$isKanwil.",
						user_email='".$txtEmail."',
						user_branch_id=".$txtBranch.",
						user_salt='".$random_salt."',
						user_upddt='".$txtUpdateDt."',
						user_updusr='".$txtUpdateUser."' 
						WHERE user_id=".$userID;
			
			mysqli_query($con,$sqlUpdate.$sqlKriteria);
			$isSaveSuccess = true;
			//set new login string
			loginAfterUpdateUser($txtUserPN, $password, $con);
			
			//echo $sqlUpdate.$sqlKriteria;
			echo "<script type='text/javascript'>
					alert('Data berhasil diperbaharui.');
				  	window.location.href='view_atm_activitylog.php';
				  </script>";
			
		}
		
		
		//uncomment for debuging
  		//echo $sqlUpdate.$sqlKriteria;
		
	}
	
	}
	
	mysqli_close($con);
	
}catch (Exception $e){
	echo $e->getMessage();
}
?>
<div class="content" >
<?php 
if ($isDataValid && $isSaveSuccess){
?>

<div id="panelInput">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="frmInput">
<input type="hidden" name="actionsubmit" value=""/>
	<table>
        <tr>
        	<td>
            	<label>Personal Number</label>
            </td>
            <td>
            <label>:</label>
            </td>
            <td><input class="stdFont" type="text" id="txtUserPN" name="txtUserPN" size="20" style="text-align: center;"
            	value="<?php echo $userPN ?>" onkeypress="return numbersonly(this, event)" />
            </td>
            <td>
            	<span class="error" ><font color="#FF0000"><?php echo $errUserPN ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>Password</label>
            </td>
            <td>
            <label>:</label>
            </td>
            <td>
            	<input class="stdFont" type="password" id="txtPassword" name="txtPassword" size="20" style="text-align: center;" />
            </td>
            <td>
            	<span class="error"><font color="#FF0000"><?php echo $errPassword ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>Konfirm Password</label>
            </td>
            <td>
            <label>:</label>
            </td>
            <td>
            	<input class="stdFont" type="password" id="txtConfirm" name="txtConfirm" size="20" style="text-align: center;" />
            </td>
            <td>
            	<span class="error"><font color="#FF0000"><?php echo $errKonfirm ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>Nama Lengkap</label>
            </td>
            <td>
            <label>:</label>
            </td>
            <td><input class="stdFont" type="text" id="txtUserName" name="txtUserName" value="<?php echo $username ?>" size="40"/>
            </td>
            <td>
            	<span class="error" ><font color="#FF0000"><?php echo $errUserName ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>Jabatan</label>
            </td>
            <td>
            <label>:</label>
            </td>
            <td><input class="stdFont" type="text" id="txtJabatan" name="txtJabatan" value="<?php echo $jabatan ?>" size="40"/>
            </td>
            <td>
            	<span class="error" ><font color="#FF0000"><?php echo $errJabatan ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>Email</label>
            </td>
            <td>
            <label>:</label>
            </td>
            <td><input class="stdFont" type="text" id="txtEmail" name="txtEmail" value="<?php echo $email ?>" size="40"/>
            </td>
            <td>
            	<span class="error" ><font color="#FF0000"><?php echo $errEmail ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label>Kanwil/Kanca</label></td>
            <td><label>:</label></td>
            <td><input type="radio" id="isKanwil" name="isKanwil" value="kanwil" onclick="javascript:disabledKCList('','','lstBranch');" <?php echo $kanwilCek?>/><label>Kanwil </label>
            	<input type="radio" id="isKanwil" name="isKanwil" value="kanca" onclick="javascript:enabledKCList('','','lstBranch');" <?php echo $kancaCek?>/><label>Kanca </label>
            </td>
            <td>
            	<span class="error"><font color="#FF0000"><?php echo $errKanwilCek ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label>Unit Kerja</label></td>
            <td><label>:</label></td>
            <td>
            	<select id="lstBranch" name="lstBranch" style="width: 200px">
   				<?php 
   					 while ($row = $lstBranch->fetch_assoc()){
    
						unset($id, $name);
						$id = $row['branch_id'];
						$name = $row['branch_name'];
						if($id == $userBranchID){
							echo '<option value="'.$id.'" selected>'.$name.'</option>';
						}else echo '<option value="'.$id.'">'.$name.'</option>';
						
					}
				?>
    			</select>
            </td>
            <td>
            	<span class="error"><font color="#FF0000"><?php echo $errBranch ?></font></span>
            </td>
        </tr>
        <tr>
       		<td align="right" colspan="3">
       		<p class="submit"><input type="button" id="btnSimpan" name="btnSimpan" class="button" value="Simpan" 
       		onclick="return regformhash2(this.form,
      	                                   this.form.txtUserName,
      	                                   this.form.txtPassword,this.form.txtConfirm,
      	                                   this.form.txtUserPN,this.form.txtJabatan,this.form.txtEmail,
      	                                   this.form.isKanwil,this.form.lstBranch);"/></p>
       		
       		</td>
        </tr>
    </table>
</form>
</div>
</div>
</div>
<?php 
}
?>
</body>
</html>
