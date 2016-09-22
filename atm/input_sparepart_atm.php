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

function submitSave(form,select_merk,
		select_part,
		atmpart_sn,
		atmpart_source_tid,
		atmpart_dest_tid,
		atmpart_keterangan,
		select_statuspart){
	
	if(insertAtmSparepartValidation(form,select_merk,
			select_part,
			atmpart_sn,
			atmpart_source_tid,
			atmpart_dest_tid,
			atmpart_keterangan,
			select_statuspart)){

		
		if(confirm('Anda yakin ingin menyimpan?')){
			//var p = document.createElement("input");
			var action = document.createElement("input");
			var saveaction = document.createElement("input");
			 
		    // Add the new element to our form. 
		    //form =document.getElementById('frmSearch');
		    //form.appendChild(p);
		    //p.name = "tid";
		    //p.type = "hidden";
		    //p.value = atm_act_tid;
		    
		    form.appendChild(action);
		    action.name = "action";
		    action.type = "hidden";
		    action.value = "input_sparepart_atm";
		
		    form.appendChild(saveaction);
		    saveaction.name = "saveaction";
		    saveaction.type = "hidden";
		    saveaction.value = "input_sparepart_atm";
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
date_default_timezone_set("Asia/Jakarta");

$atmpart_id=
$atmpart_brand_id=
$atmpart_jenis_id=
$atmpart_sn=
$atmpart_source_tid=
$atmpart_dest_tid=
$atmpart_keterangan=
$atmpart_isactive=
$atmpart_creadt=
$atmpart_upddt=
$atmpart_creausr=
$atmpart_updusr=
$atmpart_status_id=
$tid=
$cro_select_id=$cro_select_desc=
$atmbrand_select_id=$atmbrand_select_nama=
$kanca_select_id=$kanca_select_desc=$kanca_select_mbcode=
$kategori_select_id=$kategori_select_desc=
$status_select_id=$status_select_desc=
$team_select_id=$team_select_desc=
$atmpart_select_id=$atmpart_select_desc=
$statuspart_select_id=$statuspart_select_desc=
$saveaction="";

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}
//$tid=21157335;

$mysqli = getConnection();

if (!empty($_POST["saveaction"])){
	$saveaction = $_POST["saveaction"];
	
	/* // insert the data into the database
	$insert_prep = "INSERT INTO m_atm_sparepart
			            (atmpart_brand_id,
			             atmpart_jenis_id,
			             atmpart_sn,
			             atmpart_source_tid,
			             atmpart_dest_tid,
			             atmpart_keterangan,
			             atmpart_isactive,
			             atmpart_creadt,
			             atmpart_upddt,
			             atmpart_creausr,
			             atmpart_updusr)
					VALUES (?,?,?,?,?,?,?,?,?,?,?);  ";
	
	$insert_stmt = $mysqli->prepare($insert_prep);
	
	if ($insert_stmt) {
		
		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
        	if (!empty($_SESSION['user_pn'])) {
        		$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);
        	}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
		 
		$insert_stmt->bind_param('iissssissss', 
												    validateInput($_POST['select_merk']),
													validateInput($_POST['select_part']),
													validateInput($_POST['atmpart_sn']),
													validateInput($_POST['atmpart_source_tid']),
													validateInput($_POST['atmpart_dest_tid']),
													validateInput($_POST['atmpart_keterangan']),
													validateInput('1'),
													validateInput($txtUpdateDt),
													validateInput($txtUpdateDt),
													validateInput($txtUpdateUser),
													validateInput($txtUpdateUser)); */
	
		/* // Execute the prepared query.
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
	//} */
		 insertATMSparepart($mysqli);
}

//get cro list
$cro_stmt = getCROList($mysqli);

if ($cro_stmt->num_rows >= 1) {
	$cro_stmt->bind_result($cro_select_id,$cro_select_desc);
}

//get merk list
$merk_stmt = getATMBrandList($mysqli);

if ($merk_stmt->num_rows >= 1) {
	$merk_stmt->bind_result($atmbrand_select_id,$atmbrand_select_nama);
}

//get problem kategori list
$problem_stmt = getATMProblemList($mysqli);

if ($problem_stmt) {

	$problem_stmt->execute();
	$problem_stmt->store_result();
}

if ($problem_stmt->num_rows >= 1) {
	$problem_stmt->bind_result($kategori_select_id,$kategori_select_desc);
}

//get status list
$status_stmt = getATMStatusList($mysqli);

if ($status_stmt->num_rows >= 1) {
	$status_stmt->bind_result($status_select_id,$status_select_desc);
}

//get part status list
$statuspart_stmt = getATMStatusPartList($mysqli);

if ($statuspart_stmt->num_rows >= 1) {
	$statuspart_stmt->bind_result($statuspart_select_id,$statuspart_select_desc);
}

//get part atm list
$atmpart_stmt = getATMJenisPartList($mysqli);

if ($atmpart_stmt->num_rows >= 1) {
	$atmpart_stmt->bind_result($atmpart_select_id,$atmpart_select_desc);
}

?>
<div class="right">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="3">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td align="center" valign="middle"><h3 style="margin-top:0px;">Input Stock Sparepart ATM</h3></td>
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
					<li><a href="#tabs-1" style="font-size:12px;"><b>Input</b></a></li>
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
					<td class="list_left">Merk ATM</td>
					<td class="list_right">: 
					<select name="select_merk" id="select_custom">
					<?php 
							while ($merk_stmt->fetch()){
								if ($atmpart_brand_id == $atmbrand_select_id) {
										echo '<option value="'.$atmbrand_select_id.'" selected>'.$atmbrand_select_nama.'</option>';
								}else 
									echo '<option value="'.$atmbrand_select_id.'">'.$atmbrand_select_nama.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				
				<tr>
					<td class="list_left">Jenis Part</td>
					<td class="list_right">: 
					<select name="select_part" id="select_custom">
					<?php 
							while ($atmpart_stmt->fetch()){
								if ($atmpart_jenis_id == $atmpart_select_id) {
										echo '<option value="'.$atmpart_select_id.'" selected>'.$atmpart_select_desc.'</option>';
								}else 
									echo '<option value="'.$atmpart_select_id.'">'.$atmpart_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				
				<tr>
					<td class="list_left">Serial Number</td>
					<td class="list_right">: <input id="text_custom" name="atmpart_sn" value="<?php echo $atmpart_sn?>"/></td>
				</tr>
				<tr>
					<td class="list_left">TID ATM Sumber</td>
					<td class="list_right">: <input id="text_custom" name="atmpart_source_tid" value="<?php echo $atmpart_source_tid?>" maxlength="10" onkeypress="return alphanumonly(event)"/></td>
				</tr>
				<tr>
					<td class="list_left">TID ATM Tujuan</td>
					<td class="list_right">: <input id="text_custom" name="atmpart_dest_tid" value="<?php echo $atmpart_dest_tid?>" maxlength="10" onkeypress="return alphanumonly(event)"/></td>
				</tr>
				<tr>
					<td class="list_left">Keterangan</td>
					<td class="list_right">: <input id="text_custom" name="atmpart_keterangan" value="<?php echo $atmpart_keterangan?>" /></td>
				</tr>
				<tr>
					<td class="list_left">Status</td>
					<td class="list_right">: 
					<select name="select_statuspart" id="select_custom">
					<?php 
							while ($statuspart_stmt->fetch()){
								if ($atmpart_status_id == $statuspart_select_id) {
										echo '<option value="'.$statuspart_select_id.'" selected>'.$statuspart_select_desc.'</option>';
								}else 
									echo '<option value="'.$statuspart_select_id.'">'.$statuspart_select_desc.'</option>';
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
														this.form.select_merk,
														this.form.select_part,
														this.form.atmpart_sn,
														this.form.atmpart_source_tid,
														this.form.atmpart_dest_tid,
														this.form.atmpart_keterangan,
														this.form.select_statuspart
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