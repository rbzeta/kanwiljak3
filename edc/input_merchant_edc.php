<?php 
if (empty($_SESSION['user_pn'])) {
	$_SESSION["login_error"] = "Halaman tidak dapat diakses, silahkan login terlebih dahulu.";
	header('Location: ../login/login.php?error=1');
	session_write_close();
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

#text_custom, #edcmerchant_tglimplementasi, #edcmerchant_tglinisiasi, #txt_tgl_non_active {
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
	$( "#edcmerchant_tglimplementasi" ).datepicker({
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true
	});
});
$(function() {
	$( "#edcmerchant_tglinisiasi" ).datepicker({
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true
	});
});

function submitSave(recId){
	if(confirm('Anda yakin ingin menyimpan?')){
		var p = document.createElement("input");
		var action = document.createElement("input");
		var saveaction = document.createElement("input");
		 
	    // Add the new element to our form. 
	    form =document.getElementById('frmSearch');
	    form.appendChild(p);
	    p.name = "tid";
	    p.type = "hidden";
	    p.value = recId;
	    
	    form.appendChild(action);
	    action.name = "action";
	    action.type = "hidden";
	    action.value = "input_edc_merchant";
	
	    form.appendChild(saveaction);
	    saveaction.name = "saveaction";
	    saveaction.type = "hidden";
	    saveaction.value = "inputmerchantedcfinish";
	    //alert(saveaction.value);
	    // Finally submit the form. 
	    form.submit();
		//document.getElementById('frmSearch').submit();
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
<form action="../edc/dashboard_edc.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch">
<?php 
$edcmerchant_id=$edcmerchant_tid=$edcmerchant_mid=$edcmerchant_tipe=$edcmerchant_kodekanca =$edcmerchant_nama=$edcmerchant_brand=$edcmerchant_sn=               
$edcmerchant_provider=$edcmerchant_opendate=$edcmerchant_dataadded=$edcmerchant_alamat=$edcmerchant_kota=$edcmerchant_norek=$edcmerchant_pic=$edcmerchant_pictelp          
=$edcmerchant_usaha=$edcmerchant_FO=$edcmerchant_tglimplementasi=$edcmerchant_tglinisiasi=$edcmerchant_keterangan=$edcmerchant_mcc=$edcmerchant_mdronus          
=$edcmerchant_mdroffus=$edcmerchant_creadt=$edcmerchant_upddt=$edcmerchant_creausr=$edcmerchant_updusr=$edcmerchant_replace=$edcmerchant_status=$tid=
$edcbrand_id=$edcbrand_nama=$branch_mbcode=$branch_mbname=$branch_code=$branch_name=$edcsp_no=$edcmerchant_jenisusaha_id=$jenisusaha_id=$jenisusaha_desc=
$edcbrand_select_id=$edcbrand_select_nama=$edcmerchant_brizzi=$edcmerchant_jaringan=$provider_id=$provider_id=$provider_desc=$edcmerchant_snsimcard=
$saveaction="";

$isActive = 1;

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}
//$tid=21157335;

$mysqli = getConnection();

if (!empty($_POST["saveaction"])){
	$saveaction = $_POST["saveaction"];
	
	// Update the data into the database
	$insert_prep = "INSERT INTO m_edc_merchant
            (edcmerchant_tid,
             edcmerchant_mid,
             edcmerchant_tipe,
             edcmerchant_kodekanca,
             edcmerchant_nama,
             edcmerchant_brand,
             edcmerchant_sn,
             edcmerchant_alamat,
             edcmerchant_pic,
             edcmerchant_pictelp,
             edcmerchant_tglimplementasi,
             edcmerchant_tglinisiasi,
             edcmerchant_keterangan,
             edcmerchant_creadt,
             edcmerchant_upddt,
             edcmerchant_creausr,
             edcmerchant_updusr,
             edcmerchant_jenisusaha_id,
             edcmerchant_isactive)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
	
	$insert_stmt = $mysqli->prepare($insert_prep);
	
	if ($insert_stmt) {
		 
		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
        	if (!empty($_SESSION['user_pn'])) {
        		$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);;
        	}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
		 
		$insert_stmt->bind_param('sssssisssssssssssis', 
													validateInput($_POST['edcmerchant_tid']),
													validateInput($_POST['edcmerchant_mid']),
													validateInput($_POST['select_tipe']),
													validateInput($_POST['edcmerchant_kodekanca']),
													validateInput($_POST['edcmerchant_nama']),
													validateInput($_POST['select_merk']),
													validateInput($_POST['edcmerchant_sn']),
													validateInput($_POST['edcmerchant_alamat']),
													validateInput($_POST['edcmerchant_pic']),
													validateInput($_POST['edcmerchant_pictelp']),
													validateInput($_POST['edcmerchant_tglimplementasi']),
													validateInput($_POST['edcmerchant_tglinisiasi']),
													validateInput($_POST['edcmerchant_keterangan']),
													validateInput($txtUpdateDt),
													validateInput($txtUpdateDt),
													validateInput($txtUpdateUser),
													validateInput($txtUpdateUser),
													validateInput($_POST['select_kategori']),
													validateInput($isActive));
	
	// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			echo "<script type='text/javascript'>
							alert('Terjadi kesalahan saat menyimpan data [exec q error].');
						  </script>";
		}else{ echo "<script type='text/javascript'>
							alert('Data berhasil disimpan.');
							redirectPage('input_edc_merchant_finish');
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

//get jenis usaha list
$select_kategori = "SELECT 0 as jenisusaha_id,'-' as jenisusaha_desc UNION ALL SELECT jenisusaha_id,jenisusaha_desc FROM m_jenisusaha ";
$kategori_stmt = $mysqli->prepare($select_kategori);
if ($kategori_stmt) {

	$kategori_stmt->execute();
	$kategori_stmt->store_result();
}

if ($kategori_stmt->num_rows >= 1) {
	$kategori_stmt->bind_result($jenisusaha_id,$jenisusaha_desc);
}

//get merk list
$select_merk = "SELECT 0 as edcbrand_id,'-' as edcbrand_nama UNION ALL SELECT edcbrand_id,edcbrand_nama FROM m_edc_brand ";
$merk_stmt = $mysqli->prepare($select_merk);
if ($merk_stmt) {

	$merk_stmt->execute();
	$merk_stmt->store_result();
}

if ($merk_stmt->num_rows >= 1) {
	$merk_stmt->bind_result($edcbrand_select_id,$edcbrand_select_nama);
}

//get provider list
$select_provider = "SELECT 0 as provider_id,'-' as provider_desc UNION ALL SELECT provider_id,provider_desc FROM m_provider ";
$provider_stmt = $mysqli->prepare($select_provider);
if ($provider_stmt) {

	$provider_stmt->execute();
	$provider_stmt->store_result();
}

if ($provider_stmt->num_rows >= 1) {
	$provider_stmt->bind_result($provider_id,$provider_desc);
}
?>
<div class="right">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="3">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td align="center" valign="middle"><h3 style="margin-top:0px;"><b><?php echo $edcmerchant_nama?></b></h3></td>
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
					<li><a href="#tabs-1" style="font-size:12px;"><b>Profile</b></a></li>
					<!-- <li><a href="#tabs-2" style="font-size:12px;"><b>Transaksi</b></a></li>-->
					<li><a href="#tabs-2" style="font-size:12px;"><b>Complaint</b></a></li>
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
					<td class="list_left">TERMINAL ID</td>
					<td class="list_right">: <input id="text_custom" name="edcmerchant_tid" value="<?php echo $edcmerchant_tid?>" maxlength="15"/></td>
				</tr>
				<tr>
					<td class="list_left">MERCHANT ID</td>
					<td class="list_right">: <input id="text_custom" name="edcmerchant_mid" value="<?php echo $edcmerchant_mid?>" maxlength="15"/></td>
				</tr>
				<tr>
					<td class="list_left">KODE UKER</td>
					<td class="list_right">: <input id="text_custom" name="edcmerchant_kodekanca" value="<?php echo $edcmerchant_kodekanca?>" maxlength="5" onkeypress="return numbersonly(this,event,0)"/></td>
				</tr>
				<tr>
					<td class="list_left">NAMA MERCHANT</td>
					<td class="list_right">: <input id="text_custom" name="edcmerchant_nama" value="<?php echo $edcmerchant_nama?>" maxlength="255"/></td>
				</tr>
				<tr>
					<td class="list_left">ALAMAT</td>
					<td class="list_right">: <input id="text_custom" name="edcmerchant_alamat" value="<?php echo $edcmerchant_alamat?>" maxlength="255"/></td>
				</tr>
				<!-- tr>
					<td class="list_left">KOTA/KAB.</td>
					<td class="list_right">: <input id="text_custom" name="edcmerchant_kota" value="<?php echo $edcmerchant_kota?>" maxlength="30"/></td>
				</tr-->
				<tr>
					<td class="list_left">JENIS USAHA</td>
					<td class="list_right">: 
					<select name="select_kategori" id="select_custom">
					<?php 
							while ($kategori_stmt->fetch()){
								if ($edcmerchant_jenisusaha_id == $jenisusaha_id) {
										echo '<option value="'.$jenisusaha_id.'" selected>'.$jenisusaha_desc.'</option>';
								}else 
									echo '<option value="'.$jenisusaha_id.'">'.$jenisusaha_desc.'</option>';
							}
							?>
					</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">TIPE</td>
					<td class="list_right">: 
					<select name="select_tipe" id="select_custom">
							<option value="0" <?php if($edcmerchant_tipe =="0") echo "selected";?>> - </option>
							<option value="RITEL" <?php if($edcmerchant_tipe =="RITEL") echo "selected";?>>	RITEL </option>				
							<option value="CHAIN" <?php if($edcmerchant_tipe =="CHAIN") echo "selected";?>>	CHAIN </option>
						</select>
					</td>
				</tr>
				<!-- tr>
					<td class="list_left">NO REKENING</td>
					<td class="list_right">: <input id="text_custom" name="edcmerchant_norek" value="<?php echo $edcmerchant_norek?>" maxlength="15"/></td>
				</tr-->
				<tr>
					<td class="list_left">NAMA PIC</td>
					<td class="list_right">: <input id="text_custom" name="edcmerchant_pic" value="<?php echo $edcmerchant_pic?>" maxlength="30"/></td>
				</tr>
				<tr>
					<td class="list_left">NO TELP PIC</td>
					<td class="list_right">: <input id="text_custom" name="edcmerchant_pictelp" value="<?php echo $edcmerchant_pictelp?>" maxlength="15"/></td>
				</tr>
				<!-- <tr>
					<td class="list_left">FUNDING OFFICER</td>
					<td class="list_right">: <?php echo $edcmerchant_FO?></td>
				</tr>-->
			</table>
		</td>
		<td valign="top">
			<table width="100%" border="0" cellpadding="1" cellspacing="2">
				<tr>
					<td class="list_left">S/N MESIN</td>
					<td class="list_right">: <input id="text_custom" name="edcmerchant_sn" value="<?php echo $edcmerchant_sn?>" maxlength="16"/></td>
				</tr>
				<tr>
					<td class="list_left">MERK</td>
					<td class="list_right">: 
					<select name="select_merk" id="select_custom">
					<?php 
							while ($merk_stmt->fetch()){
								if ($edcmerchant_brand == $edcbrand_select_id) {
										echo '<option value="'.$edcbrand_select_id.'" selected>'.$edcbrand_select_nama.'</option>';
								}else 
									echo '<option value="'.$edcbrand_select_id.'">'.$edcbrand_select_nama.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<!-- tr>
					<td class="list_left">BRIZZI</td>
					<td class="list_right">: 
					<select name="select_brizzi" id="select_custom">
							<option value="0" <?php if($edcmerchant_brizzi ==0) echo "selected";?>> - </option>
							<option value="1" <?php if($edcmerchant_brizzi ==1) echo "selected";?>>	Ya </option>				
							<option value="2" <?php if($edcmerchant_brizzi ==2) echo "selected";?>>	Tidak </option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">JARINGAN</td>
					<td class="list_right">: 
					<select name="select_jaringan" id="select_custom">
							<option value="0" <?php if($edcmerchant_jaringan ==0) echo "selected";?>> - </option>
							<option value="1" <?php if($edcmerchant_jaringan ==1) echo "selected";?>> Dial Up </option>				
							<option value="2" <?php if($edcmerchant_jaringan ==2) echo "selected";?>> GPRS </option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">PROVIDER</td>
					<td class="list_right">: 
					<select name="select_provider" id="select_custom">
					<?php 
							while ($provider_stmt->fetch()){
								if ($edcmerchant_provider == $provider_id) {
										echo '<option value="'.$provider_id.'" selected>'.$provider_desc.'</option>';
								}else 
									echo '<option value="'.$provider_id.'">'.$provider_desc.'</option>';
							}
							?>
					</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">S/N SIMCARD</td>
					<td class="list_right">: <input id="text_custom" name="edcmerchant_snsimcard" value="<?php echo $edcmerchant_snsimcard?>" maxlength="30"/></td>
				</tr-->
				<tr>
					<td class="list_left"> TGL IMPLEMENTASI</td>
					<td class="list_right">: 
					<input type="text" id="edcmerchant_tglimplementasi" name="edcmerchant_tglimplementasi" value="<?php echo $edcmerchant_tglimplementasi?>" />
					</td>
				</tr>
				<tr>
					<td class="list_left"> TGL INISIASI</td>
					<td class="list_right">: 
					<input type="text" id="edcmerchant_tglinisiasi" name="edcmerchant_tglinisiasi" value="<?php echo $edcmerchant_tglinisiasi?>" />
					</td>
				</tr>
				
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellpadding="1" cellspacing="2">
				<tr>
					<td class="list_left">KETERANGAN</td>
					<td class="list_right">: 
					<textarea id="edcmerchant_keterangan" name="edcmerchant_keterangan" rows="3" cols="100" dir="ltr"><?php echo $edcmerchant_keterangan?></textarea>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<div style="margin-top:20px;">
				<input type="button" value=" Simpan" id="btnSimpan" name="btnSimpan" onclick="submitSave(<?php echo $edcmerchant_tid;?>);"/>
				
			</div>
		</td>
	</tr>
</table>
</div>

				<div id="tabs-2">
						<?php include 'report_detil_complaint_tid.php';?>
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