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
	header('Location: ../kanwiljak3/login.php?error=1');
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
<script type="text/javascript">
$(function() {
	
	$('#popupDatepicker').datepick({dateFormat: 'dd/mm/yyyy'});
	$('#popupDatepicker2').datepick({dateFormat: 'dd/mm/yyyy'});
	
});

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
include 'header.php';
?>
</div>
<div id="menu" class="sidebar">
<?php 
include 'sidebar.php';
?>
</div>
<?php 
date_default_timezone_set("Asia/Jakarta");

$errTID=$errTanggal=$errBrand=$errCRO=$errKC=$errLokasi=$errProblem=$errAction=$errStatus=$errTeamKW=$errOnsite=$errGaransi="";
$onsiteCek=$offsiteCek="";
$garansiCek=$nongaransiCek="";

$isDataValid=$isSaveSuccess = true;

$sqlInsert = "insert into m_atm_activitylog (atm_act_date,atm_act_tid,atm_act_brand_id,atm_act_cro_id,atm_act_branch_id,
			atm_act_loc,atm_act_probcat_id,atm_act_pmaction,atm_act_pmdesc,atm_act_status_id,atm_act_pmteamkw_id,atm_act_pmteamkc,atm_act_isonsite,
			atm_act_isgaransi,atm_act_creadt,atm_act_upddt,atm_act_creausr,atm_act_updusr) ";
			
$sqlKriteria = "";

try {
	$con = getConnection();
	if (!empty($con)) {
		
		$lstAtmBrand = getQueryResult($con,"select 0 as atm_brand_id,'---- Pilih Merek ATM ----' as atm_brand_sname union all SELECT distinct atm_brand_id,atm_brand_sname FROM m_atm_brand order by atm_brand_sname");
		$lstCRO = getQueryResult($con,"select 0 as atm_cro_id,'---- Pilih CRO ----' as atm_cro_name union all SELECT distinct atm_cro_id,atm_cro_name FROM m_atm_cro order by atm_cro_name");
		$lstBranch = getQueryResult($con,"select 0 as branch_id,0 as branch_mbcode,'---- Pilih Unit Kerja ----' as branch_name union all SELECT distinct branch_id ,branch_mbcode,concat(branch_mbcode,' - ',branch_mbname) as branch_name FROM m_branch order by branch_mbcode");
		$lstStatus = getQueryResult($con,"select 0 as status_id,'---- Pilih Status ----' as status_name union all SELECT distinct status_id,status_name FROM m_status order by status_name");
		$lstProblem = getQueryResult($con,"select 0 as problem_id,'---- Pilih Problem ----' as problem_name union all SELECT distinct problem_id,problem_name FROM m_problem_cat order by problem_name ");
		//$lstTeamKW = getQueryResult($con,"select 0 as team_kanwil_id,'---- Pilih Team----' as team_kanwil_name union all SELECT distinct team_kanwil_id,team_kanwil_name FROM m_team_kanwil order by team_kanwil_id");
		if ($isUker) {
			$lstTeamKW = getQueryResult($con,"select 0 as user_id,'---- Pilih Team----' as user_lname union all SELECT distinct user_id,user_lname FROM m_user where user_uker = 1 order by user_lname");
		}else 
			$lstTeamKW = getQueryResult($con,"select 0 as user_id,'---- Pilih Team----' as user_lname union all SELECT distinct user_id,user_lname FROM m_user where user_uker = 0 order by user_lname");
	if(isset($_POST["btnSimpan"]) || isset($_POST["actionsubmit"])){
		
		if (!empty($_POST["isOnsite"])){
			
			if ($_POST["isOnsite"] == "onsite"){
				$onsiteCek = "checked";
				$isOnsite = 1;
			}else {
				$offsiteCek = "checked";	
				$isOnsite = 0;
			}
			
		}else{
			$errOnsite = "* Field Onsite/Offsite wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}
		
		if (!empty($_POST["isGaransi"])){
				
			if ($_POST["isGaransi"] == "garansi"){
				$garansiCek = "checked";
				$isGaransi = 1;
			}else {
				$nongaransiCek = "checked";
				$isGaransi = 0;
			}
				
		}else{
			$errGaransi = "* Field Garansi/Non Garansi wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}
		
		if(empty($_POST["txtTanggal"])){
			$errTanggal = "* Field Tanggal wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$varDate = str_replace('/', '-', $_POST["txtTanggal"]);
			$txtDate = date('Y/m/d', strtotime($varDate));
			$txtDate = mysqli_real_escape_string($con,$txtDate);
		}
		
		if(empty($_POST["txtTID"])){
			$errTID = "* Field TID wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtTID = mysqli_real_escape_string($con,$_POST["txtTID"]);
		}
		
		if($_POST["lstBrand"] == 0){
			$errBrand = "* Field Merek ATM wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtBrand = mysqli_real_escape_string($con,$_POST["lstBrand"]);
		}
		
		if($_POST["lstCRO"] == 0){
			$errCRO = "* Field CRO wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtCRO = mysqli_real_escape_string($con,$_POST["lstCRO"]);
		}
		
		if($_POST["lstKC"] == 0){
			$errKC = "* Field KC Supervisi wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtBranch = mysqli_real_escape_string($con,$_POST["lstKC"]);
		}
		
		if(empty($_POST["txtLokasi"])){
			$errLokasi = "* Field Lokasi wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtLokasi = mysqli_real_escape_string($con,validateInput($_POST["txtLokasi"]));
		
		}
		
		if($_POST["lstProblem"] == 0){
			$errProblem = "* Field Problem wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtProblem = mysqli_real_escape_string($con,$_POST["lstProblem"]);
		
		}
		
		if(empty($_POST["txtAction"])){
			$errAction = "* Field Action wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtAction = mysqli_real_escape_string($con,validateInput($_POST["txtAction"]));
		
		}
		
		if($_POST["lstStatus"] == 0){
			$errStatus = "* Field Status wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtStatus = mysqli_real_escape_string($con,$_POST["lstStatus"]);
		
		}
		
		if($_POST["lstTeamKW"] == 0){
			$errTeamKW = "* Field Team Kanwil wajib diisi.";
			$isDataValid = $isSaveSuccess =false;
		}else {
			$txtTeamKW = mysqli_real_escape_string($con,$_POST["lstTeamKW"]);
		
		}
		
		if($isDataValid){
			
			$errTID=$errTanggal=$errBrand=$errCRO=$errKC=$errLokasi=$errProblem=$errAction=$errStatus=$errTeamKW=$errOnsite=$errGaransi="";
			
			$txtDescription = mysqli_real_escape_string($con,validateInput($_POST["txtDescription"]));
			$txtTeamKC = mysqli_real_escape_string($con,validateInput($_POST["txtTeamKC"]));
			//sementara hardcode, seharusnya dari session login
			$txtCreateDt = mysqli_real_escape_string($con,date("Y/m/d H:i:s"));
			$txtUpdateDt = mysqli_real_escape_string($con,date("Y/m/d H:i:s"));
			$txtCreateUser = mysqli_real_escape_string($con,$_SESSION['user_pn']);
			$txtUpdateUser = mysqli_real_escape_string($con,$_SESSION['user_pn']);
			
			$sqlKriteria = "values (' ".$txtDate."','".$txtTID."',".$txtBrand.",".$txtCRO.",".$txtBranch.",'".$txtLokasi."',".$txtProblem.",'".$txtAction."','"
									.$txtDescription."',".$txtStatus.",".$txtTeamKW.",'".$txtTeamKC."',".$isOnsite.",".$isGaransi.",'"
									.$txtCreateDt."','".$txtUpdateDt."','".$txtCreateUser."','"
									.$txtUpdateUser."' ) ";
			
			mysqli_query($con,$sqlInsert.$sqlKriteria);
			$isSaveSuccess = true;
			echo "<script type='text/javascript'>alert('Data berhasil disimpan.');</script>";
		}
		
		
		//uncomment for debuging
		//echo $sqlInsert.$sqlKriteria;
		
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
    	<!-- <tr>
        	<td colspan="3">
            	Input Aktivitas
            </td>
        </tr> -->
        <tr>
        	<td>
            	<label>Tanggal</label>
            </td>
            <td>
            <label>:</label>
            </td>
            <td>
            	<input  class="stdFont" type="text" id="popupDatepicker" name="txtTanggal" onkeyup="DateFormat(this,this.value,event,false,'1')" onblur="DateFormat(this,this.value,event,true,'1')" value="" size="10" style="text-align: center;"/>
            </td>
            <td>
            	<span class="stdError" ><font color="#FF0000"><?php echo $errTanggal ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>TID ATM</label>
            </td>
            <td>
            <label>:</label>
            </td>
            <td>
            	<input  class="stdFont" type="text" id="txtTID" name="txtTID" maxlength="6" onkeypress="return alphanumonly(event)" size="10" style="text-align: center;"/>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errTID ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label>ATM Brand</label></td>
            <td><label>:</label></td>
            <td>
            	<select name="lstBrand" style="width: 200px">
				<?php
					while ($row = $lstAtmBrand->fetch_assoc()){

						unset($id, $name);
						$id = $row['atm_brand_id'];
						$name = $row['atm_brand_sname'];
						if ($id == 0) {
							echo '<option value="'.$id.'" selected>'.$name.'</option>';
						}else echo '<option value="'.$id.'">'.$name.'</option>';

					}
				?>
    			</select>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errBrand ?></font></span>
            </td>
        </tr>
         <tr>
        	<td><label>CRO</label></td>
            <td><label>:</label></td>
            <td>
            	<select name="lstCRO" style="width: 200px">
    			<?php 
   					 while ($row = $lstCRO->fetch_assoc()){
    
						unset($id, $name);
						$id = $row['atm_cro_id'];
						$name = $row['atm_cro_name'];
						if($id == 0){
							echo '<option value="'.$id.'" selected>'.$name.'</option>';
						}else echo '<option value="'.$id.'">'.$name.'</option>';
    
					}
				?>
    			</select>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errCRO ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label>Onsite/Offsite</label></td>
            <td><label>:</label></td>
            <td><input type="radio" name="isOnsite" value="onsite" /><label>Onsite</label>
            	<input type="radio" name="isOnsite" value="offsite"/><label>Offsite </label>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errOnsite ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label>Garansi/Non Garansi</label></td>
            <td><label>:</label></td>
            <td><input type="radio" name="isGaransi" value="garansi" /><label>Garansi</label>
            	<input type="radio" name="isGaransi" value="nongaransi"/><label>Non Garansi</label>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errGaransi ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label>KC Supervisi</label></td>
            <td><label>:</label></td>
            <td>
            	<select name="lstKC" style="width: 200px">
   				<?php 
   					 while ($row = $lstBranch->fetch_assoc()){
    
						unset($id, $name);
						$id = $row['branch_id'];
						$name = $row['branch_name'];
						if($id == 0){
							echo '<option value="'.$id.'" selected>'.$name.'</option>';
						}else echo '<option value="'.$id.'">'.$name.'</option>';
						
					}
				?>
    			</select>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errKC ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>Lokasi</label>
            </td>
            <td>
            	<label>:</label>
            </td>
            <td>
            	<input class="stdFont" type="text" name="txtLokasi"  maxlength="255" size="66"/>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errLokasi ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label>Permasalahan</label></td>
            <td><label>:</label></td>
            <td>
            	<select name="lstProblem" style="width: 200px">
    			<?php 
   					 while ($row = $lstProblem->fetch_assoc()){
    
						unset($id, $name);
						$id = $row['problem_id'];
						$name = $row['problem_name'];
						if($id == 0){
							echo '<option value="'.$id.'" selected>'.$name.'</option>';
						}else echo '<option value="'.$id.'">'.$name.'</option>';
    
					}
				?>
    			</select>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errProblem ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>Tindakan</label>
            </td>
            <td>
            	<label>:</label>
            </td>
            <td>
            	<textarea class="stdFont" rows="2" cols="68" name="txtAction"></textarea>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errAction ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>Keterangan Lainnya</label>
            </td>
            <td>
            	<label>:</label>
            </td>
            <td>
            	<textarea class="stdFont" rows="5" cols="68" name="txtDescription" ></textarea>
            	
            </td>
        </tr>
        <tr>
        	<td><label>Status</label></td>
            <td><label>:</label></td>
            <td>
            	<select name="lstStatus" style="width: 200px">
				<?php 
					while ($row = $lstStatus->fetch_assoc()){
					
						unset($id, $name);
						$id = $row['status_id'];
						$name = $row['status_name'];
						if($id == 0){
							echo '<option value="'.$id.'" selected>'.$name.'</option>';
						}else echo '<option value="'.$id.'">'.$name.'</option>';
						
					}
                ?>
    			</select>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errStatus ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label><?php echo $strUker?></label></td>
            <td><label>:</label></td>
            <td>
            	<select name="lstTeamKW" style="width: 200px">
    			<?php 
   					 while ($row = $lstTeamKW->fetch_assoc()){
    
						unset($id, $name);
						$id = $row['user_id'];
						$name = $row['user_lname'];
						if($id == 0){
							echo '<option value="'.$id.'" selected>'.$name.'</option>';
						}else echo '<option value="'.$id.'">'.$name.'</option>';
    
					}
				?>
    			</select>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errTeamKW ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label>
            	<?php echo $strUker2?></label>
            </td>
            <td>
            	<label>:</label>
            </td>
            <td>
            	<input class="stdFont" type="text" name="txtTeamKC"  maxlength="255" size="66" />
            </td>
        </tr>
        <tr>
       		<td align="right">
       		<!-- input name="btnSimpan" type="submit" value="Simpan" onclick="return confirm('Anda yakin ingin menyimpan?')"/-->
       		<p class="submit"><input type="button" class="button" name="btnSimpan" value="Simpan" onclick="submitForm(this.form,this.form.actionsubmit);"/></p>
       		</td>
            <td colspan="2"><!-- input name="btnHapus" type="reset" value="Reset" /-->
            <p class="submit"><input type="button" class="button" name="btnReset" value="Hapus" onclick="window.location.href='input_atm_activitylog.php';"/></p></td>
        </tr>
    </table>
</form>
</div>
<?php 
} else{
?>
<div id="panelInput">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="frmInput">
<input type="hidden" name="actionsubmit" value=""/>
	<table>
    	<!-- <tr>
        	<td colspan="3">
            	Input Aktivitas
            </td>
        </tr> -->
        <tr>
        	<td>
            	<label>Tanggal</label>
            </td>
            <td>
            <label>:</label>
            </td>
            <td>
            	<input class="stdFont" type="text" id="popupDatepicker" name="txtTanggal" onKeyUp="DateFormat(this,this.value,event,false,'1')" 
            	onBlur="DateFormat(this,this.value,event,true,'1')" value="<?php echo $_POST["txtTanggal"] ?>"
            	size="10" style="text-align: center;"/>
            </td>
            <td>
            	<span class="stdError" ><font color="#FF0000"><?php echo $errTanggal ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>TID ATM</label>
            </td>
            <td>
            <label>:</label>
            </td>
            <td>
            	<input class="stdFont" type="text" id="txtTID" name="txtTID" maxlength="6" onKeyPress="return alphanumonly(event)" 
            	value="<?php echo $_POST["txtTID"] ?>" size="10" style="text-align: center;"/>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errTID ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label>ATM Brand</label></td>
            <td><label>:</label></td>
            <td>
            	<select name="lstBrand" style="width: 200px">
				<?php
					while ($row = $lstAtmBrand->fetch_assoc()){

						unset($id, $name);
						$id = $row['atm_brand_id'];
						$name = $row['atm_brand_sname'];
						if($_POST['lstBrand'] == $id){
							echo '<option value="'.$id.'" selected >'.$name.'</option>';
						}else echo '<option value="'.$id.'" >'.$name.'</option>';
						

					}
				?>
    			</select>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errBrand ?></font></span>
            </td>
        </tr>
         <tr>
        	<td><label>CRO</label></td>
            <td><label>:</label></td>
            <td>
            	<select name="lstCRO" style="width: 200px">
    			<?php 
   					 while ($row = $lstCRO->fetch_assoc()){
    
						unset($id, $name);
						$id = $row['atm_cro_id'];
						$name = $row['atm_cro_name'];
						if ($_POST['lstCRO'] == $id) {
							echo '<option value="'.$id.'" selected>'.$name.'</option>';
						}else 	echo '<option value="'.$id.'">'.$name.'</option>';
    
					}
				?>
    			</select>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errCRO ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label>Onsite/Offsite</label></td>
            <td><label>:</label></td>
            <td><input type="radio" name="isOnsite" value="onsite" <?php echo $onsiteCek?>/><label>Onsite</label>
            	<input type="radio" name="isOnsite" value="offsite" <?php echo $offsiteCek?>/><label>Offsite </label>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errOnsite ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label>Garansi/Non Garansi</label></td>
            <td><label>:</label></td>
            <td><input type="radio" name="isGaransi" value="garansi" <?php echo $garansiCek?>/><label>Garansi </label>
            	<input type="radio" name="isGaransi" value="nongaransi" <?php echo $nongaransiCek?>/><label>Non Garansi </label>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errGaransi ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label>KC Supervisi</label></td>
            <td><label>:</label></td>
            <td>
            	<select name="lstKC" style="width: 200px">
   				<?php 
   					 while ($row = $lstBranch->fetch_assoc()){
    
						unset($id, $name);
						$id = $row['branch_id'];
						$name = $row['branch_name'];
						if ($_POST['lstKC'] == $id) {
							echo '<option value="'.$id.'" selected>'.$name.'</option>';
						}else 	echo '<option value="'.$id.'">'.$name.'</option>';
						
					}
				?>
    			</select>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errKC ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>Lokasi</label>
            </td>
            <td>
            	<label>:</label>
            </td>
            <td>
            	<input class="stdFont" type="text" name="txtLokasi"  maxlength="255" value="<?php echo $_POST["txtLokasi"] ?>" size="66"/>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errLokasi ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label>Permasalahan</label></td>
            <td><label>:</label></td>
            <td>
            	<select name="lstProblem" style="width: 200px">
    			<?php 
   					 while ($row = $lstProblem->fetch_assoc()){
    
						unset($id, $name);
						$id = $row['problem_id'];
						$name = $row['problem_name'];
						if ($_POST['lstProblem'] == $id) {
							echo '<option value="'.$id.'" selected>'.$name.'</option>';
						}else 	echo '<option value="'.$id.'">'.$name.'</option>';
    
					}
				?>
    			</select>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errProblem ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>Tindakan</label>
            </td>
            <td>
            	<label>:</label>
            </td>
            <td>
            	<textarea class="stdFont" rows="2" cols="68" name="txtAction"><?php echo $_POST["txtAction"] ?></textarea>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errAction ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label>Keterangan Lainnya</label>
            </td>
            <td>
            	<label>:</label>
            </td>
            <td>
            	<textarea class="stdFont" rows="5" cols="68" name="txtDescription"><?php echo $_POST["txtDescription"] ?></textarea>
            </td>
        </tr>
        <tr>
        	<td><label>Status</label></td>
            <td><label>:</label></td>
            <td>
            	<select name="lstStatus" style="width: 200px">
				<?php 
					while ($row = $lstStatus->fetch_assoc()){
					
						unset($id, $name);
						$id = $row['status_id'];
						$name = $row['status_name'];
						if ($_POST['lstStatus'] == $id) {
							echo '<option value="'.$id.'" selected>'.$name.'</option>';
						}else 	echo '<option value="'.$id.'">'.$name.'</option>';
						
					}
                ?>
    			</select>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errStatus ?></font></span>
            </td>
        </tr>
        <tr>
        	<td><label><?php echo $strUker?></label></td>
            <td><label>:</label></td>
            <td>
            	<select name="lstTeamKW" style="width: 200px">
    			<?php 
   					 while ($row = $lstTeamKW->fetch_assoc()){
    
						unset($id, $name);
						$id = $row['user_id'];
						$name = $row['user_lname'];
						if ($_POST['lstTeamKW'] == $id) {
							echo '<option value="'.$id.'" selected>'.$name.'</option>';
						}else 	echo '<option value="'.$id.'">'.$name.'</option>';
    
					}
				?>
    			</select>
            </td>
            <td>
            	<span class="stdError"><font color="#FF0000"><?php echo $errTeamKW ?></font></span>
            </td>
        </tr>
        <tr>
        	<td>
            	<label><?php echo $strUker2?></label>
            </td>
            <td>
            	<label>:</label>
            </td>
            <td>
            	<input class="stdFont" type="text" name="txtTeamKC"  maxlength="255" value="<?php echo $_POST["txtTeamKC"] ?>" size="66"/>
            </td>
        </tr>
        <tr>
       		<td align="right">
       		<!-- input name="btnSimpan" type="submit" value="Simpan" onclick="return confirm('Anda yakin ingin menyimpan?')"/-->
       		<p class="submit"><input type="button" class="button" name="btnSimpan" value="Simpan" onclick="submitForm(this.form,this.form.actionsubmit);"/></p>
       		</td>
            <td colspan="2"><!-- input name="btnHapus" type="reset" value="Reset" /-->
            <p class="submit"><input type="button" class="button" name="btnReset" value="Hapus" onclick="window.location.href='input_atm_activitylog.php';"/></p></td>
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
