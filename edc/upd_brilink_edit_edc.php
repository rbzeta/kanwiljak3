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

#text_custom, #edcbrilink_tglimplementasi, #edcbrilink_tglinit, #txt_tgl_non_active {
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
	$( "#edcbrilink_tglimplementasi" ).datepicker({
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true
	});
});
$(function() {
	$( "#edcbrilink_tglinit" ).datepicker({
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
	    action.value = "opentidbrilinkinputedit";
	
	    form.appendChild(saveaction);
	    saveaction.name = "saveaction";
	    saveaction.type = "hidden";
	    saveaction.value = "opentidbrilinkinputeditsave";
	    //alert(saveaction.value);
	    // Finally submit the form. 
	    form.submit();
		//document.getElementById('frmSearch').submit();
	}
}
</script>
</head>
<body>
<form action="../edc/dashboard_edc.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch">
<?php 
$edcbrilink_id=$edcbrilink_tid=$edcbrilink_mid=$edcbrilink_tipe=$edcbrilink_kodekanca=$edcbrilink_kodeunit=
$edcbrilink_brand=$edcbrilink_sn=$edcbrilink_simcard=$edcbrilink_agen=$edcbrilink_alamatrumah=$edcbrilink_alamatusaha=
$edcbrilink_nohp=$edcbrilink_jenisusaha=$edcbrilink_jarak=$edcbrilink_norekkupedes=$edcbrilink_noreksimpedes=
$edcbrilink_plafon=$edcbrilink_bakidebet=$edcbrilink_saldosimpanan=$edcbrilink_lamadebitur=$edcbrilink_lamanasabah=
$edcbrilink_alasan=$edcbrilink_provider=$edcbrilink_tglimplementasi=$edcbrilink_tglinit=$edcbrilink_creadt=
$edcbrilink_uppdt=$edcbrilink_creausr=$edcbrilink_updusr=$edcbrilink_sp_id=$tid=$edcbrilink_upddt=
$edcbrand_id=$edcbrand_nama=$branch_mbcode=$branch_mbname=$branch_code=$branch_name=$edcsp_no=
$edcbrand_select_id=$edcbrand_select_nama=$provider_id=$provider_id=$provider_desc=$action=
$kanca_select_id=$kanca_select_mbcode=$kanca_select_desc=$jenisusaha_id=$jenisusaha_desc=$edcbrilink_pic=$edcbrilink_pic_notelp=
$saveaction="";

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}
//$tid=21157335;

$mysqli = getConnection();

if (!empty($_POST["saveaction"])){
	$saveaction = $_POST["saveaction"];
	
	// Update the data into the database
	$insert_prep = "UPDATE m_edc_brilink 
			SET 
				edcbrilink_tid = ?,
				edcbrilink_mid = ?,
				edcbrilink_tipe = ?,
				edcbrilink_kodekanca = ?,
				edcbrilink_kodeunit = ?,
				edcbrilink_brand = ?, 
				edcbrilink_sn = ? , 
				edcbrilink_agen = ? ,
				edcbrilink_alamatusaha = ? ,
				edcbrilink_nohp = ? ,
				edcbrilink_jenisusaha = ? ,
				edcbrilink_tglimplementasi = ?	,
				edcbrilink_tglinit = ?,
				edcbrilink_upddt =?,
				edcbrilink_updusr = ?,
				edcbrilink_pic= ?,
				edcbrilink_pic_notelp=?
			WHERE edcbrilink_tid = ? ";
	
	$insert_stmt = $mysqli->prepare($insert_prep);
	
	if ($insert_stmt) {
		 
		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
        	if (!empty($_SESSION['user_pn'])) {
        		$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);;
        	}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
		 
		$insert_stmt->bind_param('sssisissssissssssi', 
													validateInput($_POST['edcbrilink_tid']),
													validateInput($_POST['edcbrilink_mid']),
													validateInput($_POST['select_tipe']),
													validateInput($_POST['select_kanca']),
													validateInput($_POST['edcbrilink_kodeunit']),
													validateInput($_POST['select_merk']),
													validateInput($_POST['edcbrilink_sn']),
													validateInput($_POST['edcbrilink_agen']),
													validateInput($_POST['edcbrilink_alamatusaha']),
													validateInput($_POST['edcbrilink_nohp']),
													validateInput($_POST['select_kategori']),
													validateInput($_POST['edcbrilink_tglimplementasi']),
													validateInput($_POST['edcbrilink_tglinit']),
													validateInput($txtUpdateDt),
													validateInput($txtUpdateUser),
													validateInput($_POST['edcbrilink_pic']),
													validateInput($_POST['edcbrilink_pic_notelp']),
													$tid);
	
		// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			echo "<script type='text/javascript'>
											alert('Terjadi kesalahan saat menyimpan data [exec q error].');
										  </script>";
		}else echo "<script type='text/javascript'>
					alert('Data berhasil disimpan.');
				  </script>";
	}else{
		echo "<script type='text/javascript'>
											alert('Terjadi kesalahan saat menyimpan data. [statement q error]');
										  </script>";
		/* header('Location: ../kanwiljak3/error.php?error=1');
		session_write_close(); */
	}
		 
}

//get jenis usaha list
$kategori_stmt = getJenisUsahaList($mysqli);
 if ($kategori_stmt->num_rows >= 1) {

 	$kategori_stmt->bind_result($jenisusaha_id,$jenisusaha_desc);
 }

//get merk list
$merk_stmt = getMerkList($mysqli);
if ($merk_stmt->num_rows >= 1) {
	$merk_stmt->bind_result($edcbrand_select_id,$edcbrand_select_nama);
}

//get provider list
$provider_stmt = getProviderList($mysqli);
if ($provider_stmt->num_rows >= 1) {
	$provider_stmt->bind_result($provider_id,$provider_desc);
}

//get kanca list
$kanca_stmt = getKancaList($mysqli);
if ($kanca_stmt->num_rows >= 1) {
	$kanca_stmt->bind_result($kanca_select_id,$kanca_select_mbcode,$kanca_select_desc);
}


$select_prep = "SELECT edcbrilink_id,edcbrilink_tid,edcbrilink_mid,edcbrilink_tipe,edcbrilink_kodekanca,edcbrilink_kodeunit,edcbrilink_brand,
				edcbrilink_sn,edcbrilink_simcard,edcbrilink_agen,edcbrilink_alamatrumah,edcbrilink_alamatusaha,edcbrilink_nohp,edcbrilink_jenisusaha,edcbrilink_jarak,edcbrilink_norekkupedes,
				edcbrilink_noreksimpedes,edcbrilink_plafon,edcbrilink_bakidebet,edcbrilink_saldosimpanan,edcbrilink_lamadebitur,
				edcbrilink_lamanasabah,edcbrilink_alasan,edcbrilink_provider,edcbrilink_tglimplementasi,edcbrilink_tglinit,
				edcbrilink_creadt,edcbrilink_upddt,edcbrilink_creausr,edcbrilink_updusr,															
				edcbrand_id,edcbrand_nama,branch_mbcode,branch_mbname,branch_code,branch_name,edcbrilink_pic,edcbrilink_pic_notelp
				FROM m_edc_brilink
				LEFT JOIN m_edc_brand ON edcbrand_id = edcbrilink_brand
				LEFT JOIN m_branch ON branch_code = edcbrilink_kodekanca 
			    WHERE edcbrilink_tid = ? AND edcbrilink_isactive=1 LIMIT 1";

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

	$select_stmt->bind_result($edcbrilink_id,$edcbrilink_tid,$edcbrilink_mid,$edcbrilink_tipe,$edcbrilink_kodekanca,$edcbrilink_kodeunit,$edcbrilink_brand,
							$edcbrilink_sn,$edcbrilink_simcard,$edcbrilink_agen,$edcbrilink_alamatrumah,$edcbrilink_alamatusaha,$edcbrilink_nohp,$edcbrilink_jenisusaha,
							$edcbrilink_jarak,$edcbrilink_norekkupedes,$edcbrilink_noreksimpedes,$edcbrilink_plafon,$edcbrilink_bakidebet,$edcbrilink_saldosimpanan,
							$edcbrilink_lamadebitur,$edcbrilink_lamanasabah,$edcbrilink_alasan,$edcbrilink_provider,$edcbrilink_tglimplementasi,$edcbrilink_tglinit,
							$edcbrilink_creadt,$edcbrilink_upddt,$edcbrilink_creausr,$edcbrilink_updusr,
							$edcbrand_id,$edcbrand_nama,$branch_mbcode,$branch_mbname,$branch_code,$branch_name,$edcbrilink_pic,$edcbrilink_pic_notelp);
	
	$select_stmt->fetch();
}
?>
<div class="right">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="3">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td align="center" valign="middle"><h3 style="margin-top:0px;"><b><?php echo $edcbrilink_agen?></b></h3></td>
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
					<td class="list_left">TID</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_tid" value="<?php echo $edcbrilink_tid?>" maxlength="15"/></td>
				</tr>
				<tr>
					<td class="list_left">MID</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_mid" value="<?php echo $edcbrilink_mid?>" maxlength="15"/></td>
				</tr>
				<tr>
					<td class="list_left">TIPE</td>
					<td class="list_right">: 
					<select name="select_tipe" id="select_custom">
							<option value="NOT DEFINED" <?php if($edcbrilink_tipe =="NOT DEFINED") echo "selected";?>> - </option>
							<option value="RITEL" <?php if($edcbrilink_tipe =="RITEL") echo "selected";?>>	RITEL </option>				
							<option value="MIKRO" <?php if($edcbrilink_tipe =="MIKRO") echo "selected";?>>	MIKRO </option>
						</select>
					</td>
				</tr>					
				<tr>
					<td class="list_left">KC Supervisi</td>
					<td class="list_right">: 
					<select name="select_kanca" id="select_custom">
					<?php 
							while ($kanca_stmt->fetch()){
								if ($edcbrilink_kodekanca == $kanca_select_id) {
										echo '<option value="'.$kanca_select_id.'" selected>'.$kanca_select_desc.'</option>';
								}else 
									echo '<option value="'.$kanca_select_id.'">'.$kanca_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">KODE UKER</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_kodeunit" value="<?php echo $edcbrilink_kodeunit?>" maxlength="5" onkeypress="return numbersonly(this,event,0)"/></td>
				</tr>	
				<tr>
					<td class="list_left">MERK</td>
					<td class="list_right">: 
					<select name="select_merk" id="select_custom">
					<?php 
							while ($merk_stmt->fetch()){
								if ($edcbrilink_brand == $edcbrand_select_id) {
										echo '<option value="'.$edcbrand_select_id.'" selected>'.$edcbrand_select_nama.'</option>';
								}else 
									echo '<option value="'.$edcbrand_select_id.'">'.$edcbrand_select_nama.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">S/N MESIN</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_sn" value="<?php echo $edcbrilink_sn?>" maxlength="16"/></td>
				</tr>				
				<!--tr>
					<td class="list_left">SIMCARD</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_simcard" value="<?php echo $edcbrilink_simcard?>" maxlength="16"/></td>
				</tr-->				
				<tr>
					<td class="list_left">NAMA AGEN</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_agen" value="<?php echo $edcbrilink_agen?>" maxlength="30"/></td>
				</tr>
				<!-- tr>
					<td class="list_left">ALAMAT RUMAH</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_alamatrumah" value="<?php echo $edcbrilink_alamatrumah?>" maxlength="40"/></td>
				</tr-->				
				<tr>
					<td class="list_left">ALAMAT USAHA</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_alamatusaha" value="<?php echo $edcbrilink_alamatusaha?>" maxlength="40"/></td>
				</tr>		
				<tr>
					<td class="list_left">NO HP</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_nohp" value="<?php echo $edcbrilink_nohp?>" maxlength="20"/></td>
				</tr>
				<tr>
					<td class="list_left">JENIS USAHA</td>
					<td class="list_right">: 
					<select name="select_kategori" id="select_custom">
					<?php 
							while ($kategori_stmt->fetch()){
								if ($edcbrilink_jenisusaha == $jenisusaha_id) {
										echo '<option value="'.$jenisusaha_id.'" selected>'.$jenisusaha_desc.'</option>';
								}else 
									echo '<option value="'.$jenisusaha_id.'">'.$jenisusaha_desc.'</option>';
							}
							?>
					</select>
					</td>
				</tr>
								
			</table>
		</td>
		<td valign="top">
			<table width="100%" border="0" cellpadding="1" cellspacing="2">

				<!-- tr>
					<td class="list_left">NO REKENING KUPEDES</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_norekkupedes" value="<?php echo $edcbrilink_norekkupedes?>" maxlength="20"/></td>
				</tr>
				<tr>
					<td class="list_left">NO REKENING SIMPEDES</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_noreksimpedes" value="<?php echo $edcbrilink_noreksimpedes?>" maxlength="20"/></td>
				</tr>
				<tr>
					<td class="list_left">PLAFON</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_plafon" value="<?php echo $edcbrilink_plafon?>" maxlength="20"/></td>
				</tr>
				<tr>
					<td class="list_left">BAKI DEBET</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_bakidebet" value="<?php echo $edcbrilink_bakidebet?>" maxlength="20"/></td>
				</tr>			
				<tr>
					<td class="list_left">SALDO SIMPANAN</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_saldosimpanan" value="<?php echo $edcbrilink_saldosimpanan?>" maxlength="20"/></td>
				</tr>		
				<tr>
					<td class="list_left">LAMA DEBITUR</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_lamadebitur" value="<?php echo $edcbrilink_lamadebitur?>" maxlength="15"/></td>
				</tr>	
				<tr>
					<td class="list_left">LAMA NASABAH</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_lamanasabah" value="<?php echo $edcbrilink_lamanasabah?>" maxlength="15"/></td>
				</tr>	
				<tr>
					<td class="list_left">ALASAN</td>
					<td class="list_right">: <input id="text_custom" name="edcbrilink_alasan" value="<?php echo $edcbrilink_alasan?>" maxlength="30"/></td>
				</tr>													
				<tr>
					<td class="list_left">PROVIDER</td>
					<td class="list_right">: 
					<select name="select_provider" id="select_custom">
					<?php 
							while ($provider_stmt->fetch()){
								if ($edcbrilink_provider == $provider_id) {
										echo '<option value="'.$provider_id.'" selected>'.$provider_desc.'</option>';
								}else 
									echo '<option value="'.$provider_id.'">'.$provider_desc.'</option>';
							}
							?>
					</select>
					</td>
				</tr-->
				<tr>
					<td class="list_left"> NAMA PIC (F0/MANTRI)</td>
					<td class="list_right">: 
					<input type="text" id="text_custom" name="edcbrilink_pic" value="<?php echo $edcbrilink_pic?>" />
					</td>
				</tr>
				<tr>
					<td class="list_left"> NO TELP PIC</td>
					<td class="list_right">: 
					<input type="text" id="text_custom" name="edcbrilink_pic_notelp" value="<?php echo $edcbrilink_pic_notelp?>" />
					</td>
				</tr>
				<tr>
					<td class="list_left"> TGL IMPLEMENTASI</td>
					<td class="list_right">: 
					<input type="text" id="edcbrilink_tglimplementasi" name="edcbrilink_tglimplementasi" value="<?php echo $edcbrilink_tglimplementasi?>" />
					</td>
				</tr>
				<tr>
					<td class="list_left"> TGL INISIASI</td>
					<td class="list_right">: 
					<input type="text" id="edcbrilink_tglinit" name="edcbrilink_tglinit" value="<?php echo $edcbrilink_tglinit?>" />
					</td>
				</tr>
				
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<div style="margin-top:20px;">
				<input type="button" value=" Simpan" id="btnSimpan" name="btnSimpan" onclick="submitSave(<?php echo $edcbrilink_tid;?>);"/>
				
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