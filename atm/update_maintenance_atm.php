<?php 

$isUker = false;
$strUker = "Team Kanwil";
$strUker2 = "Team Kanca";

if (empty($_SESSION['user_pn'])) {
	$_SESSION["login_error"] = "Halaman tidak dapat diakses, silahkan login terlebih dahulu.";
	header('Location: ../login/login.php?error=1');
	session_write_close();
}else{
	if ($_SESSION['user_uker']) {
		$isUker = 1;
		$strUker = "Team Kanca";
		$strUker2 = "Team Kanwil";
	}
}

?>
<html>
<head>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.tabs.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.jqChart.css" />
<link rel="stylesheet" type="text/css" href="../css/jquery.jqRangeSlider.css" />
<script src="../js/jquery.mousewheel.js" type="text/javascript"></script>
<script src="../js/jquery.jqChart.min.js" type="text/javascript"></script>
<script src="../js/jquery.jqRangeSlider.min.js" type="text/javascript"></script>
<style type="text/css">
#tabs {
	border: 0px !important;
}

.ui-tabs .ui-tabs-panel {
	padding: 0px !important;
}

.ui-widget-header {
	background: #ffffff !important;
	border: 0px !important;
	border-bottom: 1px solid #aaaaaa !important;
	border-radius: 0px;
}

.ui-tabs .ui-tabs-nav li {
	font-size: 13px;
	border-radius: 2px;
}

table tr td .list_left {
	background-color:#F5F4E5; 
	font-weight:bold; 
	padding-left:5px; 
	vertical-align: top;
	width:150px;
}

table tr td .list_right {
	border-bottom:1px #DDDDDD solid;
}

#text_custom, #atm_act_date {
	width:335px; 
	border-top:0; 
	border-left:0; 
	border-right:0; 
	border-bottom: 2px dotted #F8A448;
	font:11px/20px normal Helvetica, Arial, sans-serif;
}

#select_custom {
	font-size:9px; 
	border-top:0; 
	border-left:0; 
	border-right:0;
	border-bottom: 2px dotted #F8A448;
}

.ui-datepicker { font-size: 10px !important; }
</style>

<script type="text/javascript">
$(function() {
	$( "#tabs" ).tabs({
		selected:0	});
});

$(function() {
	$( "#atm_act_date" ).datepicker({
		dateFormat: "dd/mm/yy",
		changeMonth: true,
		changeYear: true
	});
});

function submitSave(form,recordId,atm_act_date,
		atm_act_tid,
		select_merk,
		select_cro,
		select_isonsite,
		select_isgaransi,
		select_kanca,
		atm_act_loc,
		select_problem,
		atm_act_pmaction,
		atm_act_pmdesc,
		select_status,
		select_teamkw,
		atm_act_pmteamkc){
	
	if(updateAtmMaintenanceValidation(form,recordId,atm_act_date,
			atm_act_tid,
			select_merk,
			select_cro,
			select_isonsite,
			select_isgaransi,
			select_kanca,
			atm_act_loc,
			select_problem,
			atm_act_pmaction,
			atm_act_pmdesc,
			select_status,
			select_teamkw,
			atm_act_pmteamkc)){
		if(confirm('Anda yakin ingin menyimpan?')){
			var p = document.createElement("input");
			var action = document.createElement("input");
			var saveaction = document.createElement("input");
			 
		    // Add the new element to our form. 
		    form =document.getElementById('frmSearch');
		    form.appendChild(p);
		    p.name = "tid";
		    p.type = "hidden";
		    p.value = recordId;
		    
		    form.appendChild(action);
		    action.name = "action";
		    action.type = "hidden";
		    action.value = "update_maintenance_atm";
		
		    form.appendChild(saveaction);
		    saveaction.name = "saveaction";
		    saveaction.type = "hidden";
		    saveaction.value = "update_maintenance_atm";
		    //alert(saveaction.value);
		    // Finally submit the form. 
		    form.submit();
			//document.getElementById('frmSearch').submit();
		}
	}
}
</script>
</head>
<body>
<form action="../atm/dashboard_atm.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch">
<?php 
$atm_act_id=
$atm_act_date=
$atm_act_tid=
$atm_act_brand_id=
$atm_act_branch_id=
$atm_act_loc=
$atm_act_probcat_id=
$atm_act_pmaction=
$atm_act_status_id=
$atm_act_pmteamkw_id=
$atm_act_pmteamkc=
$atm_act_cro_id=
$atm_act_pmdesc=
$atm_act_isonsite=
$atm_act_isgaransi=
$atm_act_creadt=
$atm_act_upddt=
$atm_act_creausr=
$atm_act_updusr=
$tid=
$cro_select_id=$cro_select_desc=
$atmbrand_select_id=$atmbrand_select_nama=
$kanca_select_id=$kanca_select_desc=$kanca_select_mbcode=
$kategori_select_id=$kategori_select_desc=
$status_select_id=$status_select_desc=
$team_select_id=$team_select_desc=
$saveaction="";

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}
//$tid=21157335;

$mysqli = getConnection();

if (!empty($_POST["saveaction"])){
	$saveaction = $_POST["saveaction"];
	
	// Update the data into the database
	$insert_prep = "UPDATE m_atm_activitylog
					SET atm_act_date = ?,
					  atm_act_tid = ?,
					  atm_act_brand_id = ?,
					  atm_act_branch_id = ?,
					  atm_act_loc = ?,
					  atm_act_probcat_id = ?,
					  atm_act_pmaction = ?,
					  atm_act_status_id = ?,
					  atm_act_pmteamkw_id = ?,
					  atm_act_pmteamkc = ?,
					  atm_act_cro_id = ?,
					  atm_act_pmdesc = ?,
					  atm_act_isonsite = ?,
					  atm_act_isgaransi = ?,
					  atm_act_upddt = ?,
					  atm_act_updusr = ?
					WHERE atm_act_id = ? ; ";
	
	$insert_stmt = $mysqli->prepare($insert_prep);
	
	if ($insert_stmt) {
		
		$varDate = str_replace('/', '-', $_POST["atm_act_date"]);
		$txtDate = date('Y/m/d', strtotime($varDate));
		$txtDate = mysqli_real_escape_string($mysqli,$txtDate);
		
		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
        	if (!empty($_SESSION['user_pn'])) {
        		$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);;
        	}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
		 
		$insert_stmt->bind_param('ssiisisiisisiissi', 
													validateInput($txtDate),
													validateInput($_POST['atm_act_tid']),
													validateInput($_POST['select_merk']),
													validateInput($_POST['select_kanca']),
													validateInput($_POST['atm_act_loc']),
													validateInput($_POST['select_problem']),
													validateInput($_POST['atm_act_pmaction']),
													validateInput($_POST['select_status']),
													validateInput($_POST['select_teamkw']),
													validateInput($_POST['atm_act_pmteamkc']),
													validateInput($_POST['select_cro']),
													validateInput($_POST['atm_act_pmdesc']),
													validateInput($_POST['select_isonsite']),
													validateInput($_POST['select_isgaransi']),
													validateInput($txtUpdateDt),
													validateInput($txtUpdateUser),
													$tid);
	
		// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data.');
				  </script>";
		}else echo "<script type='text/javascript'>
					alert('Data berhasil disimpan.');
				  </script>";
	}else{
		echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data.');
				  </script>";
		/* header('Location: ../kanwiljak3/error.php?error=1');
		session_write_close(); */
	}
		 
}

//get cro list
$select_cro = "select 0 as atm_cro_id,'-' as atm_cro_name union all SELECT distinct atm_cro_id,atm_cro_name FROM m_atm_cro order by atm_cro_name ";
$cro_stmt = $mysqli->prepare($select_cro);
if ($cro_stmt) {

	$cro_stmt->execute();
	$cro_stmt->store_result();
}

if ($cro_stmt->num_rows >= 1) {
	$cro_stmt->bind_result($cro_select_id,$cro_select_desc);
}

//get merk list
$select_merk = "select 0 as atm_brand_id,'-' as atm_brand_sname union all SELECT distinct atm_brand_id,atm_brand_sname FROM m_atm_brand order by atm_brand_sname ";
$merk_stmt = $mysqli->prepare($select_merk);
if ($merk_stmt) {

	$merk_stmt->execute();
	$merk_stmt->store_result();
}

if ($merk_stmt->num_rows >= 1) {
	$merk_stmt->bind_result($atmbrand_select_id,$atmbrand_select_nama);
}

//get kanca list
$select_kanca = "SELECT 0 AS branch_id,0 AS branch_mbcode,'-' AS branch_name 
										UNION ALL 
										SELECT DISTINCT branch_id ,branch_mbcode,branch_mbname AS branch_name FROM m_branch WHERE branch_mbcode = branch_code ORDER BY branch_mbcode ";
$kanca_stmt = $mysqli->prepare($select_kanca);
if ($kanca_stmt) {

	$kanca_stmt->execute();
	$kanca_stmt->store_result();
}

if ($kanca_stmt->num_rows >= 1) {
	$kanca_stmt->bind_result($kanca_select_id,$kanca_select_mbcode,$kanca_select_desc);
}

//get problem kategori list
$select_problem = "select 0 as problem_id,'-' as problem_name union all SELECT distinct problem_id,problem_name FROM m_problem_cat order by problem_name ";
$problem_stmt = $mysqli->prepare($select_problem);
if ($problem_stmt) {

	$problem_stmt->execute();
	$problem_stmt->store_result();
}

if ($problem_stmt->num_rows >= 1) {
	$problem_stmt->bind_result($kategori_select_id,$kategori_select_desc);
}

//get status list
$select_status = "SELECT 0 as status_id,'-' as status_name UNION ALL SELECT status_id,status_name FROM m_status ";
$status_stmt = $mysqli->prepare($select_status);
if ($status_stmt) {

	$status_stmt->execute();
	$status_stmt->store_result();
}

if ($status_stmt->num_rows >= 1) {
	$status_stmt->bind_result($status_select_id,$status_select_desc);
}

if ($isUker) {
	$teamQry = "select 0 as user_id,'-' as user_lname union all SELECT distinct user_id,user_lname FROM m_user where user_uker = 1 order by user_lname";
}else {
	$teamQry = "select 0 as user_id,'-' as user_lname union all SELECT distinct user_id,user_lname FROM m_user where user_uker = 0 order by user_lname";
}

//get team PM list
$select_team = $teamQry;
$team_stmt = $mysqli->prepare($select_team);
if ($team_stmt) {

	$team_stmt->execute();
	$team_stmt->store_result();
}

if ($team_stmt->num_rows >= 1) {
	$team_stmt->bind_result($team_select_id,$team_select_desc);
}


$select_prep = "SELECT atm_act_id,
					  atm_act_date,
					  atm_act_tid,
					  atm_act_brand_id,
					  atm_act_branch_id,
					  atm_act_loc,
					  atm_act_probcat_id,
					  atm_act_pmaction,
					  atm_act_status_id,
					  atm_act_pmteamkw_id,
					  atm_act_pmteamkc,
					  atm_act_cro_id,
					  atm_act_pmdesc,
					  atm_act_isonsite,
					  atm_act_isgaransi,
					  atm_act_creadt,
					  atm_act_creausr,
					  atm_act_upddt,
					  atm_act_updusr
				FROM m_atm_activitylog
				WHERE atm_act_id = ? LIMIT 1";

$select_stmt = $mysqli->prepare($select_prep);
// TEST ONLY ECHO QUERY
// echo $select_prep.$tid;
//TEST ONLY
if ($select_stmt) {

	$select_stmt->bind_param('s', $tid);		
	$select_stmt->execute();
	$select_stmt->store_result();
}

if ($select_stmt->num_rows >= 1) {
	
	$select_stmt->bind_result($atm_act_id,
								$atm_act_date,
								$atm_act_tid,
								$atm_act_brand_id,
								$atm_act_branch_id,
								$atm_act_loc,
								$atm_act_probcat_id,
								$atm_act_pmaction,
								$atm_act_status_id,
								$atm_act_pmteamkw_id,
								$atm_act_pmteamkc,
								$atm_act_cro_id,
								$atm_act_pmdesc,
								$atm_act_isonsite,
								$atm_act_isgaransi,
								$atm_act_creadt,
								$atm_act_creausr,
								$atm_act_upddt,
								$atm_act_updusr);
									
	$select_stmt->fetch();
	
	$varDate = str_replace('/', '-', $atm_act_date);
	$txtDate = date('d/m/Y', strtotime($varDate));
	$atm_act_date = $txtDate;
}
?>
<div class="right">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="3">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td align="center" valign="middle"><h3 style="margin-top:0px;"><b><?php echo $atm_act_tid.' '.$atm_act_loc?></b></h3></td>
          </tr>
        </table>
    </td>
  </tr>
  
  <tr>
    <td valign="top">
	<table width="100%"  border="0" cellpadding="00">
      <tr>
        <td align="center" valign="top">
			<div id="tabs">
				<ul>
					<li><a href="#tabs-1" style="font-size:12px;"><b>Maintenance</b></a></li>
					<!-- <li><a href="#tabs-2" style="font-size:12px;"><b>Transaksi</b></a></li>-->
					<!--li><a href="#tabs-2" style="font-size:12px;"><b>Complaint</b></a></li>
					<li><a href="#tabs-3" style="font-size:12px;"><b>Maintenance</b></a></li>
					<li><a href="#tabs-4" style="font-size:12px;"><b>Penarikan</b></a></li>
					<!--  <li><a href="#tabs-6" style="font-size:12px;"><b>Log Activity User</b></a></li>-->
				</ul>
<div id="tabs-1">

<table width="100%" style="font: 11px/20px normal Helvetica, Arial, sans-serif !important; margin:10px 0 0 0;">
	<tr>
		<td valign="top" width="50%">
			<table width="100%" border="0" cellpadding="1" cellspacing="2">
				<tr>
					<td class="list_left"> Tanggal (dd/mm/yyyy)</td>
					<td class="list_right">: 
					<input type="text" id="atm_act_date" name="atm_act_date" value="<?php echo $atm_act_date?>" 
					onkeyup="DateFormat(this,this.value,event,false,'3')" 
            	onblur="DateFormat(this,this.value,event,true,'3')" size="10"/>
					</td>
				</tr>
				<tr>
					<td class="list_left">TID</td>
					<td class="list_right">: <input id="text_custom" name="atm_act_tid" value="<?php echo $atm_act_tid?>" maxlength="10" onkeypress="return alphanumonly(event)"/></td>
				</tr>
				<tr>
					<td class="list_left">Merk ATM</td>
					<td class="list_right">: 
					<select name="select_merk" id="select_custom">
					<?php 
							while ($merk_stmt->fetch()){
								if ($atm_act_brand_id == $atmbrand_select_id) {
										echo '<option value="'.$atmbrand_select_id.'" selected>'.$atmbrand_select_nama.'</option>';
								}else 
									echo '<option value="'.$atmbrand_select_id.'">'.$atmbrand_select_nama.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">CRO</td>
					<td class="list_right">: 
					<select name="select_cro" id="select_custom">
					<?php 
							while ($cro_stmt->fetch()){
								if ($atm_act_cro_id == $cro_select_id) {
										echo '<option value="'.$cro_select_id.'" selected>'.$cro_select_desc.'</option>';
								}else 
									echo '<option value="'.$cro_select_id.'">'.$cro_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">Onsite/Offsite</td>
					<td class="list_right">: 
					<select name="select_isonsite" id="select_custom">
							<option value="0" <?php if($atm_act_isonsite ==0) echo "selected";?>> Offsite </option>
							<option value="1" <?php if($atm_act_isonsite ==1) echo "selected";?>> Onsite </option>				
							<option value="2" <?php if($atm_act_isonsite ==2) echo "selected";?>>	- </option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">Garansi/Non Garansi</td>
					<td class="list_right">: 
					<select name="select_isgaransi" id="select_custom">
							<option value="0" <?php if($atm_act_isgaransi ==0) echo "selected";?>> Non Garansi </option>
							<option value="1" <?php if($atm_act_isgaransi ==1) echo "selected";?>> Garansi </option>				
							<option value="2" <?php if($atm_act_isgaransi ==2) echo "selected";?>>	- </option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">KC Supervisi</td>
					<td class="list_right">: 
					<select name="select_kanca" id="select_custom">
					<?php 
							while ($kanca_stmt->fetch()){
								if ($atm_act_branch_id == $kanca_select_id) {
										echo '<option value="'.$kanca_select_id.'" selected>'.$kanca_select_desc.'</option>';
								}else 
									echo '<option value="'.$kanca_select_id.'">'.$kanca_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">Lokasi</td>
					<td class="list_right">: <input id="text_custom" name="atm_act_loc" value="<?php echo $atm_act_loc?>" maxlength="50"/></td>
				</tr>
				<tr>
					<td class="list_left">Problem</td>
					<td class="list_right">: 
					<select name="select_problem" id="select_custom">
					<?php 
							while ($problem_stmt->fetch()){
								if ($atm_act_probcat_id == $kategori_select_id) {
										echo '<option value="'.$kategori_select_id.'" selected>'.$kategori_select_desc.'</option>';
								}else 
									echo '<option value="'.$kategori_select_id.'">'.$kategori_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">Tindakan</td>
					<td class="list_right">: 
					<textarea id="atm_act_pmaction" name="atm_act_pmaction" rows="3" cols="100" dir="ltr"><?php echo $atm_act_pmaction?></textarea>
					</td>
				</tr>
				<tr>
					<td class="list_left">Keterangan Lainnya</td>
					<td class="list_right">: 
					<textarea id="atm_act_pmdesc" name="atm_act_pmdesc" rows="3" cols="100" dir="ltr"><?php echo $atm_act_pmdesc?></textarea>
					</td>
				</tr>
				<tr>
					<td class="list_left">Status</td>
					<td class="list_right">: 
					<select name="select_status" id="select_custom">
					<?php 
							while ($status_stmt->fetch()){
								if ($atm_act_status_id == $status_select_id) {
										echo '<option value="'.$status_select_id.'" selected>'.$status_select_desc.'</option>';
								}else 
									echo '<option value="'.$status_select_id.'">'.$status_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
				<td class="list_left"><?php echo $strUker?></td>
					<td class="list_right">: 
					<select name="select_teamkw" id="select_custom">
					<?php 
							while ($team_stmt->fetch()){
								if ($atm_act_pmteamkw_id == $team_select_id) {
										echo '<option value="'.$team_select_id.'" selected>'.$team_select_desc.'</option>';
								}else 
									echo '<option value="'.$team_select_id.'">'.$team_select_desc.'</option>';
							}
							?>
							</select>
					</td>
					</tr>
				<tr>
					<td class="list_left"><?php echo $strUker2?></td>
					<td class="list_right">: <input id="text_custom" name="atm_act_pmteamkc" value="<?php echo $atm_act_pmteamkc?>" maxlength="50"/></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="1" align="center">
			<div style="margin-top:20px;">
				<input type="button" value=" Simpan" id="btnSimpan" name="btnSimpan" 
				
				onclick="submitSave(this.form,
														<?php echo $atm_act_id;?>,
														this.form.atm_act_date,
														this.form.atm_act_tid,
														this.form.select_merk,
														this.form.select_cro,
														this.form.select_isonsite,
														this.form.select_isgaransi,
														this.form.select_kanca,
														this.form.atm_act_loc,
														this.form.select_problem,
														this.form.atm_act_pmaction,
														this.form.atm_act_pmdesc,
														this.form.select_status,
														this.form.select_teamkw,
														this.form.atm_act_pmteamkc
														);"/>
				
			</div>
		</td>
	</tr>
</table>
</div>
<!-- 
<div id="tabs-2">
	
</div>
<div id="tabs-3">
	<table width="100%"  border="0" cellpadding="1" cellspacing="0" class="prLBL3" style="margin:10px 0; font: 11px/20px normal Helvetica, Arial, sans-serif !important;">
		<tr>
			<td align="center">- Tidak ada data -</td>
		</tr>
	</table>
</div>
<div id="tabs-4">
	<table width="100%"  border="0" cellpadding="1" cellspacing="0" class="prLBL3" style="margin:10px 0; font: 11px/20px normal Helvetica, Arial, sans-serif !important;">
		<tr>
			<td align="center">- Tidak ada data -</td>
		</tr>
	</table>
</div>
-->
</div>
</td>
<td align="right" valign="top">&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
</form>
</body>
</html>