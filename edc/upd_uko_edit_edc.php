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

#text_custom, #edcuko_tglimplementasi, #edcuko_tglinisiasi, #txt_tgl_non_active {
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
	$( "#edcuko_tglimplementasi" ).datepicker({
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true
	});
});
$(function() {
	$( "#edcuko_tglinisiasi" ).datepicker({
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
	    action.value = "opentidukoinputedit";
	
	    form.appendChild(saveaction);
	    saveaction.name = "saveaction";
	    saveaction.type = "hidden";
	    saveaction.value = "opentidukoinputeditsave";
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
$edcuko_id=$edcuko_tid=$edcuko_mid=$edcuko_kodekanca=$edcuko_lokasi=$tid=$edcbrand_select_id=$edcbrand_select_nama=
$edcuko_brand=$edcuko_sn=$edcuko_tglinisiasi=$edcuko_tglimplementasi=$saveaction=$edcuko_sp_id=$edcsp_no=
$edcbrand_id=$edcbrand_nama=$branch_mbcode=$branch_mbname=$branch_code=$branch_name="";

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}
//$tid=21157335;

$mysqli = getConnection();

if (!empty($_POST["saveaction"])){
	$saveaction = $_POST["saveaction"];
	
	// Update the data into the database
	$insert_prep = "UPDATE m_edc_uko
					SET 
					  edcuko_lokasi = ?,
					  edcuko_brand = ?,
					  edcuko_sn = ?,
					  edcuko_tglimplementasi = ?,
					  edcuko_upddt = ?,
					  edcuko_updusr = ? 
					WHERE edcuko_tid = ? ";
	
	$insert_stmt = $mysqli->prepare($insert_prep);
	
	if ($insert_stmt) {
		 
		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
        	if (!empty($_SESSION['user_pn'])) {
        		$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);;
        	}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
		 
		$insert_stmt->bind_param('sisssss', 
													validateInput($_POST['edcuko_lokasi']),
													validateInput($_POST['select_merk']),
													validateInput($_POST['edcuko_sn']),
													validateInput($_POST['edcuko_tglimplementasi']),
													validateInput($txtUpdateUser),
													validateInput($txtUpdateDt),
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

$select_prep = "SELECT
				  edcuko_id,
				  edcuko_tid,
				  edcuko_mid,
				  edcuko_kodekanca,
				  edcuko_lokasi,
				  edcuko_brand,
				  edcuko_sn,
				  edcuko_tglinisiasi,
				  edcuko_tglimplementasi,
				  edcuko_sp_id,branch_name,edcsp_no
				FROM m_edc_uko
				LEFT JOIN m_edc_brand ON edcbrand_id = edcuko_brand
				LEFT JOIN m_branch ON branch_code = edcuko_kodekanca 
			    LEFT JOIN m_edc_sp ON edcsp_id = edcuko_sp_id
				WHERE edcuko_tid = ? AND edcuko_isactive=1 LIMIT 1";

$select_stmt = $mysqli->prepare($select_prep);
// TEST ONLY ECHO QUERY
//echo $select_prep.$tid;
//TEST ONLY
if ($select_stmt) {

	$select_stmt->bind_param('s', $tid);		
	$select_stmt->execute();
	$select_stmt->store_result();
}

if ($select_stmt->num_rows >= 1) {

	$select_stmt->bind_result($edcuko_id,$edcuko_tid,$edcuko_mid,$edcuko_kodekanca,$edcuko_lokasi,
								$edcuko_brand,$edcuko_sn,$edcuko_tglinisiasi,$edcuko_tglimplementasi,$edcuko_sp_id,$branch_mbname,$edcsp_no);
	
	$select_stmt->fetch();
}
?>
<div class="right">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="3">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td align="center" valign="middle"><h3 style="margin-top:0px;"><b><?php echo $edcuko_lokasi?></b></h3></td>
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
					<td class="list_right">: <input id="text_custom" name="edcuko_tid" value="<?php echo $edcuko_tid?>" maxlength="15"/></td>
				</tr>
				<tr>
					<td class="list_left">MID</td>
					<td class="list_right">: <input id="text_custom" name="edcuko_mid" value="<?php echo $edcuko_mid?>" maxlength="15"/></td>
				</tr>
				<tr>
					<td class="list_left">KODE UKER</td>
					<td class="list_right">: <input id="text_custom" name="edcuko_kodekanca" value="<?php echo $edcuko_kodekanca?>" maxlength="5" onkeypress="return numbersonly(this,event,0)"/></td>
				</tr>
				<tr>
					<td class="list_left">LOKASI</td>
					<td class="list_right">: <input id="text_custom" name="edcuko_lokasi" value="<?php echo $edcuko_lokasi?>" maxlength="50"/></td>
				</tr>
				<tr>
					<td class="list_left">MERK</td>
					<td class="list_right">: 
					<select name="select_merk" id="select_custom">
					<?php 
							while ($merk_stmt->fetch()){
								if ($edcuko_brand == $edcbrand_select_id) {
										echo '<option value="'.$edcbrand_select_id.'" selected>'.$edcbrand_select_nama.'</option>';
								}else 
									echo '<option value="'.$edcbrand_select_id.'">'.$edcbrand_select_nama.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">S/N</td>
					<td class="list_right">: <input id="text_custom" name="edcuko_sn" value="<?php echo $edcuko_sn?>" maxlength="30"/></td>
				</tr>
				<tr>
					<td class="list_left"> TGL IMPLEMENTASI</td>
					<td class="list_right">: 
					<input type="text" id="edcuko_tglimplementasi" name="edcuko_tglimplementasi" value="<?php echo $edcuko_tglimplementasi?>" />
					</td>
				</tr>
				
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<div style="margin-top:20px;">
				<input type="button" value=" Simpan" id="btnSimpan" name="btnSimpan" onclick="submitSave(<?php echo $edcuko_tid;?>);"/>
				
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