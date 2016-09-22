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

function submitSave(form,recordId,atmnop_tid,
		atmnop_brand,
		atmnop_vendor,
		atmnop_lokasi,
		atmnop_area,
		atmnop_pengelola,
		atmnop_petugas,
		atmnop_keterangan){
	
	if(updateAtmProblemValidation(form,recordId,atmnop_tid,
			atmnop_brand,
			atmnop_vendor,
			atmnop_lokasi,
			atmnop_area,
			atmnop_pengelola,
			atmnop_petugas,
			atmnop_keterangan)){

		
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
		    action.value = "update_problem_atm";
		
		    form.appendChild(saveaction);
		    saveaction.name = "saveaction";
		    saveaction.type = "hidden";
		    saveaction.value = "update_problem_atm";
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
date_default_timezone_set("Asia/Jakarta");

$atmnop_id=
$atmnop_tid=
$atmnop_brand=
$atmnop_vendor=
$atmnop_ip=
$atmnop_lokasi=
$atmnop_area=
$atmnop_pengelola=
$atmnop_downtime=
$atmnop_keterangan=
$atmnop_petugas=
$atmnop_lasttrx=
$atmnop_creadt=
$atmnop_upddt=
$atmnop_creausr=
$atmnop_updusr=
$atmnop_garansi=
$atmnop_status=
$atmnop_isreplace=
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

	//update data sparepart by id
	updateATMProblemById($mysqli,$tid);
	
}

//get data atm detail
$select_stmt = getATMProblemDetailByid($mysqli,$tid);

if ($select_stmt->num_rows >= 1) {

	$select_stmt->bind_result($atmnop_id,
								$atmnop_tid,
								$atmnop_brand,
								$atmnop_vendor,
								$atmnop_ip,
								$atmnop_lokasi,
								$atmnop_area,
								$atmnop_pengelola,
								$atmnop_downtime,
								$atmnop_keterangan,
								$atmnop_petugas,
								$atmnop_lasttrx,
								$atmnop_creadt,
								$atmnop_upddt,
								$atmnop_creausr,
								$atmnop_updusr,
								$atmnop_garansi,
								$atmnop_status);
		
	$select_stmt->fetch();
	
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
              <td align="center" valign="middle"><h3 style="margin-top:0px;">Update Problem ATM</h3></td>
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
					<td class="list_left">TID ATM</td>
					<td class="list_right">: <input id="text_custom" name="atmnop_tid" value="<?php echo $atmnop_tid?>"/></td>
				</tr>
				<tr>
					<td class="list_left">Merk ATM</td>
					<td class="list_right">: <input id="text_custom" name="atmnop_brand" value="<?php echo $atmnop_brand?>"/></td>
				</tr>
				<tr>
					<td class="list_left">Vendor</td>
					<td class="list_right">: <input id="text_custom" name="atmnop_vendor" value="<?php echo $atmnop_vendor?>"/></td>
				</tr>
				<tr>
					<td class="list_left">Lokasi</td>
					<td class="list_right">: <input id="text_custom" name="atmnop_lokasi" value="<?php echo $atmnop_lokasi?>"/></td>
				</tr>
				<tr>
					<td class="list_left">Area</td>
					<td class="list_right">: <input id="text_custom" name="atmnop_area" value="<?php echo $atmnop_area?>"/></td>
				</tr>
				<tr>
					<td class="list_left">Pengelola</td>
					<td class="list_right">: <input id="text_custom" name="atmnop_pengelola" value="<?php echo $atmnop_pengelola?>"/></td>
				</tr>
				<tr>
					<td class="list_left">Petugas</td>
					<td class="list_right">: <input id="text_custom" name="atmnop_petugas" value="<?php echo $atmnop_petugas?>"/></td>
				</tr>
				<tr>
					<td class="list_left">Keterangan</td>
					<td class="list_right">: <textarea id="atmnop_keterangan" name="atmnop_keterangan"rows="3" cols="100" ><?php echo $atmnop_keterangan?></textarea></td>
				</tr>
				
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="1" align="center">
			<div style="margin-top:20px;">
				<input type="button" value=" Simpan" id="btnSimpan" name="btnSimpan" 
				
				onclick="submitSave(this.form,<?php echo $atmnop_id?>,
														this.form.atmnop_tid,
														this.form.atmnop_brand,
														this.form.atmnop_vendor,
														this.form.atmnop_lokasi,
														this.form.atmnop_area,
														this.form.atmnop_pengelola,
														this.form.atmnop_petugas,
														this.form.atmnop_keterangan
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