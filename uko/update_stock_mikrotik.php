<?php 

$isUker = false;

if (empty($_SESSION['user_pn'])) {
	$_SESSION["login_error"] = "Halaman tidak dapat diakses, silahkan login terlebih dahulu.";
	header('Location: ../login/login.php?error=1');
	session_write_close();
}else{
	if ($_SESSION['user_uker']) {
		$isUker = 1;
		
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

#text_custom, #stockmikrotik_startdt, #stockmikrotik_enddt {
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
	$( "#stockmikrotik_startdt" ).datepicker({
		dateFormat: "dd/mm/yy",
		changeMonth: true,
		changeYear: true
	});
});

$(function() {
	$( "#stockmikrotik_enddt" ).datepicker({
		dateFormat: "dd/mm/yy",
		changeMonth: true,
		changeYear: true
	});
});

function submitSave(form,recordId,stockmikrotik_mikrotiksn,
		stockmikrotik_modemsn,
		stockmikrotik_simno,
		select_provider,
		select_status,
		stockmikrotik_lokasi,
		stockmikrotik_startdt,
		stockmikrotik_enddt,
		stockmikrotik_pic,
		stockmikrotik_ippool){ 
	
	if(updateStockMikrotikValidation(form,recordId,stockmikrotik_mikrotiksn,
			stockmikrotik_modemsn,
			stockmikrotik_simno,
			select_provider,
			select_status,
			stockmikrotik_lokasi,
			stockmikrotik_startdt,
			stockmikrotik_enddt,
			stockmikrotik_pic,
			stockmikrotik_ippool)){
		
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
		    action.value = "update_stock_mikrotik";
		
		    form.appendChild(saveaction);
		    saveaction.name = "saveaction";
		    saveaction.type = "hidden";
		    saveaction.value = "update_stock_mikrotik";
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
<form action="../uko/dashboard_uko.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch">
<?php 
$stockmikrotik_id=
$stockmikrotik_mikrotiksn=
$stockmikrotik_modemsn=
$stockmikrotik_provider=
$stockmikrotik_simno=
$stockmikrotik_status=
$stockmikrotik_lokasi=
$stockmikrotik_upddt=
$stockmikrotik_updusr=
$statusmikrotik_name=
$edcprovider_nama=
$stockmikrotik_creadt=
$stockmikrotik_creausr=
$stockmikrotik_startdt=
$stockmikrotik_enddt=
$stockmikrotik_pic=
$stockmikrotik_ippool=
$tid=
$status_select_id=$status_select_desc=
$provider_id=$provider_desc=
$saveaction="";

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}
//$tid=21157335;

$mysqli = getConnection();

if (!empty($_POST["saveaction"])){
	$saveaction = $_POST["saveaction"];
	
	// Update the data into the database
	$insert_prep = "UPDATE m_stock_mikrotik
					SET stockmikrotik_mikrotiksn = ?,
					  stockmikrotik_modemsn = ?,
					  stockmikrotik_provider = ?,
					  stockmikrotik_simno = ?,
					  stockmikrotik_status = ?,
					  stockmikrotik_lokasi = ?,
					  stockmikrotik_upddt = ?,
					  stockmikrotik_updusr = ?,
						stockmikrotik_startdt = ?,
						stockmikrotik_enddt = ?,
						stockmikrotik_pic = ?,
						stockmikrotik_ippool = ?
					WHERE stockmikrotik_id = ? ;  ";
	
	$insert_stmt = $mysqli->prepare($insert_prep);
	
	if ($insert_stmt) {

		$varDate = str_replace('/', '-', $_POST["stockmikrotik_startdt"]);
		$txtDate = date('Y/m/d', strtotime($varDate));
		$txtDate = mysqli_real_escape_string($mysqli,$txtDate);
		
		$varDate1 = str_replace('/', '-', $_POST["stockmikrotik_enddt"]);
		$txtDate1 = date('Y/m/d', strtotime($varDate1));
		$txtDate1 = mysqli_real_escape_string($mysqli,$txtDate1);
		
		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
        	if (!empty($_SESSION['user_pn'])) {
        		$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);;
        	}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
		 
		$insert_stmt->bind_param('ssisisssssssi', 	validateInput($_POST['stockmikrotik_mikrotiksn']),
													validateInput($_POST['stockmikrotik_modemsn']),
													validateInput($_POST['select_provider']),
													validateInput($_POST['stockmikrotik_simno']),
													validateInput($_POST['select_status']),
													validateInput($_POST['stockmikrotik_lokasi']),
													validateInput($txtUpdateDt),
													validateInput($txtUpdateUser),
													validateInput($txtDate),
													validateInput($txtDate1),
													validateInput($_POST['stockmikrotik_pic']),
													validateInput($_POST['stockmikrotik_ippool']),
													$tid);
	
		// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data [exec q error].');
				  </script>";
		}else{ echo "<script type='text/javascript'>
					alert('Data berhasil disimpan.');
					redirectPage('update_stock_mikrotik_finish');
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

//get status list
$select_status = "SELECT 0 AS statusmikrotik_id,'-' AS statusmikrotik_name UNION ALL SELECT DISTINCT statusmikrotik_id,statusmikrotik_name FROM m_status_mikrotik ORDER BY statusmikrotik_name ";
$status_stmt = $mysqli->prepare($select_status);
if ($status_stmt) {

	$status_stmt->execute();
	$status_stmt->store_result();
}

if ($status_stmt->num_rows >= 1) {
	$status_stmt->bind_result($status_select_id,$status_select_desc);
}

//get provider list
$select_provider = "SELECT 0 as provider_id,'-' as provider_desc UNION ALL SELECT edcprovider_id,edcprovider_nama FROM m_edc_provider ";
$provider_stmt = $mysqli->prepare($select_provider);
if ($provider_stmt) {

	$provider_stmt->execute();
	$provider_stmt->store_result();
}

if ($provider_stmt->num_rows >= 1) {
	$provider_stmt->bind_result($provider_id,$provider_desc);
}


$select_prep = "SELECT
				  stockmikrotik_id,
				  stockmikrotik_mikrotiksn,
				  stockmikrotik_modemsn,
				  stockmikrotik_provider,
				  stockmikrotik_simno,
				  stockmikrotik_status,
				  stockmikrotik_lokasi,
				  stockmikrotik_creadt,
				  stockmikrotik_creausr,
				  stockmikrotik_upddt,
				  stockmikrotik_updusr,
					stockmikrotik_startdt,
					stockmikrotik_enddt,
					stockmikrotik_pic,
					stockmikrotik_ippool
				FROM m_stock_mikrotik
				WHERE stockmikrotik_id = ? LIMIT 1";

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
	
	$select_stmt->bind_result($stockmikrotik_id,
								$stockmikrotik_mikrotiksn,
								$stockmikrotik_modemsn,
								$stockmikrotik_provider,
								$stockmikrotik_simno,
								$stockmikrotik_status,
								$stockmikrotik_lokasi,
								$stockmikrotik_creadt,
								$stockmikrotik_creausr,
								$stockmikrotik_upddt,
								$stockmikrotik_updusr,
								$stockmikrotik_startdt,
								$stockmikrotik_enddt,
								$stockmikrotik_pic,
								$stockmikrotik_ippool);
									
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
              <td align="center" valign="middle"><h3 style="margin-top:0px;"><b></b></h3></td>
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
					<li><a href="#tabs-1" style="font-size:12px;"><b>Detail</b></a></li>
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
					<td class="list_left">SN Mikrotik</td>
					<td class="list_right">: <input id="text_custom" name="stockmikrotik_mikrotiksn" value="<?php echo $stockmikrotik_mikrotiksn?>" maxlength="50"/></td>
				</tr>
				<tr>
					<td class="list_left">SN Modem</td>
					<td class="list_right">: <input id="text_custom" name="stockmikrotik_modemsn" value="<?php echo $stockmikrotik_modemsn?>" maxlength="50"/></td>
				</tr>
				<tr>
					<td class="list_left">SIM Number</td>
					<td class="list_right">: <input id="text_custom" name="stockmikrotik_simno" value="<?php echo $stockmikrotik_simno?>" maxlength="50" /></td>
				</tr>
				<tr>
					<td class="list_left">Provider</td>
					<td class="list_right">: 
					<select name="select_provider" id="select_custom">
					<?php 
							while ($provider_stmt->fetch()){
								if ($stockmikrotik_provider == $provider_id) {
										echo '<option value="'.$provider_id.'" selected>'.$provider_desc.'</option>';
								}else 
									echo '<option value="'.$provider_id.'">'.$provider_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">Status</td>
					<td class="list_right">: 
					<select name="select_status" id="select_custom">
					<?php 
							while ($status_stmt->fetch()){
								if ($stockmikrotik_status == $status_select_id) {
										echo '<option value="'.$status_select_id.'" selected>'.$status_select_desc.'</option>';
								}else 
									echo '<option value="'.$status_select_id.'">'.$status_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">Lokasi</td>
					<td class="list_right">: <input id="text_custom" name="stockmikrotik_lokasi" value="<?php echo $stockmikrotik_lokasi?>" maxlength="255"/></td>
				</tr>
				<tr>
					<td class="list_left"> Tgl Mulai (dd/mm/yyyy)</td>
					<td class="list_right">: 
					<input type="text" id="stockmikrotik_startdt" name="stockmikrotik_startdt" value="<?php echo $stockmikrotik_startdt?>" 
					onkeyup="DateFormat(this,this.value,event,false,'3')" 
            	onblur="DateFormat(this,this.value,event,true,'3')" size="10"/>
					</td>
				</tr>
				<tr>
					<td class="list_left"> Tgl Selesai (dd/mm/yyyy)</td>
					<td class="list_right">: 
					<input type="text" id="stockmikrotik_enddt" name="stockmikrotik_enddt" value="<?php echo $stockmikrotik_enddt?>" 
					onkeyup="DateFormat(this,this.value,event,false,'3')" 
            	onblur="DateFormat(this,this.value,event,true,'3')" size="10"/>
					</td>
				</tr>
				<tr>
					<td class="list_left">PIC</td>
					<td class="list_right">: <input id="text_custom" name="stockmikrotik_pic" value="<?php echo $stockmikrotik_pic?>" maxlength="50"/></td>
				</tr>
				<tr>
					<td class="list_left">IP Pool</td>
					<td class="list_right">: <input id="text_custom" name="stockmikrotik_ippool" value="<?php echo $stockmikrotik_ippool?>" maxlength="20"/></td>
				</tr>
				
				
				
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="1" align="center">
			<div style="margin-top:20px;">
				<input type="button" value=" Simpan" id="btnSimpan" name="btnSimpan" 
				
				onclick="submitSave(this.form,
														<?php echo $stockmikrotik_id;?>,
														this.form.stockmikrotik_mikrotiksn,
														this.form.stockmikrotik_modemsn,
														this.form.stockmikrotik_simno,
														this.form.select_provider,
														this.form.select_status,
														this.form.stockmikrotik_lokasi,
														this.form.stockmikrotik_startdt,
														this.form.stockmikrotik_enddt,
														this.form.stockmikrotik_pic,
														this.form.stockmikrotik_ippool
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