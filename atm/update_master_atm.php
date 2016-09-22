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

function submitSave(form,recordId,select_kanca,
		masteratm_branch_code,
		masteratm_tid,
		select_tipeatm,
		masteratm_lokasi,
		select_isonsite,
		select_cro,
		select_isgaransi,
		select_merk){ 
	
	if(updateAtmMasterValidation(form,recordId,select_kanca,
			masteratm_branch_code,
			masteratm_tid,
			select_tipeatm,
			masteratm_lokasi,
			select_isonsite,
			select_cro,
			select_isgaransi,
			select_merk)){
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
		    action.value = "update_master_atm";
		
		    form.appendChild(saveaction);
		    saveaction.name = "saveaction";
		    saveaction.type = "hidden";
		    saveaction.value = "update_master_atm";
		    //alert(saveaction.value);
		    // Finally submit the form. 
		    form.submit();
			//document.getElementById('frmSearch').submit();
		}
	}
}

function redirectPage(controlID){
	var action = document.createElement("input");
	// Add the new element to our form. 
	form =document.getElementById('frmSearch');
	    
	form.appendChild(action);
	action.name = "action";
	action.type = "hidden";
	action.value = controlID;
	form.submit();
}
</script>
</head>
<body>
<form action="../atm/dashboard_atm.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch">
<?php 
$masteratm_id=
$masteratm_branch_mbcode=
$masteratm_branch_code=
$masteratm_tid=
$masteratm_tipe=
$masteratm_lokasi=
$masteratm_isonsite=
$masteratm_upddt=
$masteratm_updusr=
$masteratm_cro_id=
$masteratm_isgaransi=
$masteratm_brand_id=
$masteratm_attr_cover=
$masteratm_attr_it=
$masteratm_attr_ups=
$masteratm_attr_cctv=
$tid=
$cro_select_id=$cro_select_desc=
$atmbrand_select_id=$atmbrand_select_nama=
$kanca_select_id=$kanca_select_desc=$kanca_select_mbcode=
$jenisatm_select_id=$jenisatm_select_desc=
$status_select_id=$status_select_desc=
$team_select_id=$team_select_desc=
$attribut_select_id=$attribut_select_desc=
$attribut2_select_id=$attribut2_select_desc=
$attribut3_select_id=$attribut3_select_desc=
$attribut4_select_id=$attribut4_select_desc=
$saveaction="";

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}
//$tid=21157335;

$mysqli = getConnection();

if (!empty($_POST["saveaction"])){
	$saveaction = $_POST["saveaction"];
	
	// Update the data into the database
	$insert_prep = "UPDATE m_master_atm
					SET masteratm_branch_mbcode = ?,
					  masteratm_branch_code = ?,
					  masteratm_tid = ?,
					  masteratm_tipe = ?,
					  masteratm_lokasi = ?,
					  masteratm_isonsite = ?,
					  masteratm_upddt = ?,
					  masteratm_updusr = ?,
					  masteratm_cro_id = ?,
					  masteratm_isgaransi = ?,
					  masteratm_brand_id = ?,
					masteratm_attr_cover = ?,
					masteratm_attr_it = ?,
					masteratm_attr_ups = ?,
					masteratm_attr_cctv = ?
					WHERE masteratm_id = ?; ; ";
	
	$insert_stmt = $mysqli->prepare($insert_prep);
	
	if ($insert_stmt) {
		
		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
        	if (!empty($_SESSION['user_pn'])) {
        		$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);;
        	}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
		 
		$insert_stmt->bind_param('iisisissiiiiiiii', 	validateInput($_POST['select_kanca']),
													validateInput($_POST['masteratm_branch_code']),
													validateInput($_POST['masteratm_tid']),
													validateInput($_POST['select_tipeatm']),													
													validateInput($_POST['masteratm_lokasi']),
													validateInput($_POST['select_isonsite']),
													validateInput($txtUpdateDt),
													validateInput($txtUpdateUser),
													validateInput($_POST['select_cro']),
													validateInput($_POST['select_isgaransi']),
													validateInput($_POST['select_merk']),
													validateInput($_POST['select_cover']),
													validateInput($_POST['select_it']),
													validateInput($_POST['select_ups']),
													validateInput($_POST['select_cctv']),
													$tid);
	
		// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data [exec q error].');
				  </script>";
		}else{ echo "<script type='text/javascript'>
					alert('Data berhasil disimpan.');
					redirectPage('update_master_atm_finish');
				  </script>";
		}
	}else{
		echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data. [statement q error]');
				  </script>";
		/* header('Location: ../kanwiljak3/error.php?error=1');
		session_write_close(); */
	}
		 
}

//get status attribut list
$select_attribut = "select 0 as atmattribut_id,'-' as atmattribut_name union all SELECT distinct atmattribut_id,atmattribut_name FROM m_status_atm_attribut order by atmattribut_name ";
$attribut_stmt = $mysqli->prepare($select_attribut);
if ($attribut_stmt) {

	$attribut_stmt->execute();
	$attribut_stmt->store_result();
}

if ($attribut_stmt->num_rows >= 1) {
	$attribut_stmt->bind_result($attribut_select_id,$attribut_select_desc);
}

//get status attribut list
$select_attribut = "select 0 as atmattribut_id,'-' as atmattribut_name union all SELECT distinct atmattribut_id,atmattribut_name FROM m_status_atm_attribut order by atmattribut_name ";
$attribut_stmt = $mysqli->prepare($select_attribut);
if ($attribut_stmt) {

	$attribut_stmt->execute();
	$attribut_stmt->store_result();
}

if ($attribut_stmt->num_rows >= 1) {
	$attribut_stmt->bind_result($attribut_select_id,$attribut_select_desc);
}
//get status attribut2 list
$attribut_stmt2 = $mysqli->prepare($select_attribut);
if ($attribut_stmt2) {

	$attribut_stmt2->execute();
	$attribut_stmt2->store_result();
}

if ($attribut_stmt2->num_rows >= 1) {
	$attribut_stmt2->bind_result($attribut2_select_id,$attribut2_select_desc);
}
//get status attribut3 list
$attribut_stmt3 = $mysqli->prepare($select_attribut);
if ($attribut_stmt3) {

	$attribut_stmt3->execute();
	$attribut_stmt3->store_result();
}

if ($attribut_stmt3->num_rows >= 1) {
	$attribut_stmt3->bind_result($attribut3_select_id,$attribut3_select_desc);
}

//get status attribut4 list
$attribut_stmt4 = $mysqli->prepare($select_attribut);
if ($attribut_stmt4) {

	$attribut_stmt4->execute();
	$attribut_stmt4->store_result();
}

if ($attribut_stmt4->num_rows >= 1) {
	$attribut_stmt4->bind_result($attribut4_select_id,$attribut4_select_desc);
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
										SELECT DISTINCT branch_code ,branch_mbcode,branch_mbname AS branch_name FROM m_branch WHERE branch_mbcode = branch_code ORDER BY branch_mbcode ";
$kanca_stmt = $mysqli->prepare($select_kanca);
if ($kanca_stmt) {

	$kanca_stmt->execute();
	$kanca_stmt->store_result();
}

if ($kanca_stmt->num_rows >= 1) {
	$kanca_stmt->bind_result($kanca_select_id,$kanca_select_mbcode,$kanca_select_desc);
}

//get jenis mesin
$select_jenisatm = "select 0 as atmtipe_id,'-' as atmtipe_name union all SELECT distinct atmtipe_id,atmtipe_name FROM m_atm_tipe order by atmtipe_name ";
$jenisatm_stmt = $mysqli->prepare($select_jenisatm);
if ($jenisatm_stmt) {

	$jenisatm_stmt->execute();
	$jenisatm_stmt->store_result();
}

if ($jenisatm_stmt->num_rows >= 1) {
	$jenisatm_stmt->bind_result($jenisatm_select_id,$jenisatm_select_desc);
}


$select_prep = "SELECT masteratm_id,
					  masteratm_branch_mbcode,
					  masteratm_branch_code,
					  masteratm_tid,
					  masteratm_tipe,
					  masteratm_lokasi,
					  masteratm_isonsite,
					  masteratm_upddt,
					  masteratm_updusr,
					  masteratm_cro_id,
					  masteratm_isgaransi,
					  masteratm_brand_id,
					masteratm_attr_cover,
					masteratm_attr_it,
					masteratm_attr_ups,
					masteratm_attr_cctv
				FROM m_master_atm
				WHERE masteratm_id = ? AND masteratm_isactive = 1 LIMIT 1";

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
	
	$select_stmt->bind_result($masteratm_id,
								$masteratm_branch_mbcode,
								$masteratm_branch_code,
								$masteratm_tid,
								$masteratm_tipe,
								$masteratm_lokasi,
								$masteratm_isonsite,
								$masteratm_upddt,
								$masteratm_updusr,
								$masteratm_cro_id,
								$masteratm_isgaransi,
								$masteratm_brand_id,
								$masteratm_attr_cover,
								$masteratm_attr_it,
								$masteratm_attr_ups,
								$masteratm_attr_cctv);
									
	$select_stmt->fetch();
}

//echo $masteratm_brand_id;
?>
<div class="right">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="3">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td align="center" valign="middle"><h3 style="margin-top:0px;"><b><?php echo $masteratm_tid.' '.$masteratm_lokasi?></b></h3></td>
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
					<li><a href="#tabs-1" style="font-size:12px;"><b>Detail ATM</b></a></li>
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
					<td class="list_left">Tipe</td>
					<td class="list_right">: 
					<select name="select_tipeatm" id="select_custom">
					<?php 
							while ($jenisatm_stmt->fetch()){
								if ($masteratm_tipe == $jenisatm_select_id) {
										echo '<option value="'.$jenisatm_select_id.'" selected>'.$jenisatm_select_desc.'</option>';
								}else 
									echo '<option value="'.$jenisatm_select_id.'">'.$jenisatm_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">TID</td>
					<td class="list_right">: <input id="text_custom" name="masteratm_tid" value="<?php echo $masteratm_tid?>" maxlength="10" onkeypress="return alphanumonly(event)"/></td>
				</tr>
				<tr>
					<td class="list_left">Merk ATM</td>
					<td class="list_right">: 
					<select name="select_merk" id="select_custom">
					<?php 
							while ($merk_stmt->fetch()){
								if ($masteratm_brand_id == $atmbrand_select_id) {
										echo '<option value="'.$atmbrand_select_id.'" selected>'.$atmbrand_select_nama.'</option>';
								}else 
									echo '<option value="'.$atmbrand_select_id.'">'.$atmbrand_select_nama.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">KC Supervisi</td>
					<td class="list_right">: 
					<select name="select_kanca" id="select_custom">
					<?php 
							while ($kanca_stmt->fetch()){
								if ($masteratm_branch_mbcode == $kanca_select_id) {
										echo '<option value="'.$kanca_select_id.'" selected>'.$kanca_select_desc.'</option>';
								}else 
									echo '<option value="'.$kanca_select_id.'">'.$kanca_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">Kode Uker Pengelola</td>
					<td class="list_right">: <input id="text_custom" name="masteratm_branch_code" value="<?php echo $masteratm_branch_code?>" maxlength="10" onkeypress="return numbersonly(this,event,0)"/></td>
				</tr>
				<tr>
					<td class="list_left">Onsite/Offsite</td>
					<td class="list_right">: 
					<select name="select_isonsite" id="select_custom">
							<option value="0" <?php if($masteratm_isonsite ==0) echo "selected";?>> Offsite </option>
							<option value="1" <?php if($masteratm_isonsite ==1) echo "selected";?>> Onsite </option>				
							<option value="2" <?php if($masteratm_isonsite ==2) echo "selected";?>>	- </option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">CRO</td>
					<td class="list_right">: 
					<select name="select_cro" id="select_custom">
					<?php 
							while ($cro_stmt->fetch()){
								if ($masteratm_cro_id == $cro_select_id) {
										echo '<option value="'.$cro_select_id.'" selected>'.$cro_select_desc.'</option>';
								}else 
									echo '<option value="'.$cro_select_id.'">'.$cro_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				
				<tr>
					<td class="list_left">Garansi/Non Garansi</td>
					<td class="list_right">: 
					<select name="select_isgaransi" id="select_custom">
							<option value="0" <?php if($masteratm_isgaransi ==0) echo "selected";?>> Non Garansi </option>
							<option value="1" <?php if($masteratm_isgaransi ==1) echo "selected";?>> Garansi </option>				
							<option value="2" <?php if($masteratm_isgaransi ==2) echo "selected";?>>	- </option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td class="list_left">Lokasi</td>
					<td class="list_right">: <input id="text_custom" name="masteratm_lokasi" value="<?php echo $masteratm_lokasi?>" maxlength="255"/></td>
				</tr>
				
				<tr>
					<td class="list_left">Cover ATM</td>
					<td class="list_right">: 
					<select name="select_cover" id="select_custom">
					<?php 
							while ($attribut_stmt->fetch()){
								if ($masteratm_attr_cover == $attribut_select_id) {
										echo '<option value="'.$attribut_select_id.'" selected>'.$attribut_select_desc.'</option>';
								}else 
									echo '<option value="'.$attribut_select_id.'">'.$attribut_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">Isolation Transformer</td>
					<td class="list_right">: 
					<select name="select_it" id="select_custom">
					<?php 
							while ($attribut_stmt2->fetch()){
								if ($masteratm_attr_it == $attribut2_select_id) {
										echo '<option value="'.$attribut2_select_id.'" selected>'.$attribut2_select_desc.'</option>';
								}else 
									echo '<option value="'.$attribut2_select_id.'">'.$attribut2_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">UPS</td>
					<td class="list_right">: 
					<select name="select_ups" id="select_custom">
					<?php 
							while ($attribut_stmt3->fetch()){
								if ($masteratm_attr_ups == $attribut3_select_id) {
										echo '<option value="'.$attribut3_select_id.'" selected>'.$attribut3_select_desc.'</option>';
								}else 
									echo '<option value="'.$attribut3_select_id.'">'.$attribut3_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">CCTV</td>
					<td class="list_right">: 
					<select name="select_cctv" id="select_custom">
					<?php 
							while ($attribut_stmt4->fetch()){
								if ($masteratm_attr_cctv == $attribut4_select_id) {
										echo '<option value="'.$attribut4_select_id.'" selected>'.$attribut4_select_desc.'</option>';
								}else 
									echo '<option value="'.$attribut4_select_id.'">'.$attribut4_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="1" align="center">
			<div style="margin-top:20px;">
				<input type="button" value=" Simpan" id="btnSimpan" name="btnSimpan" 
				
				onclick="submitSave(this.form,
														<?php echo $masteratm_id;?>,
														this.form.select_kanca,
														this.form.masteratm_branch_code,
														this.form.masteratm_tid,
														this.form.select_tipeatm,
														this.form.masteratm_lokasi,
														this.form.select_isonsite,
														this.form.select_cro,
														this.form.select_isgaransi,
														this.form.select_merk
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