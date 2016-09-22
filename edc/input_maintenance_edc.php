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
<script type="text/javascript"
	src="../js/jquery-ui-1.8.13/ui/jquery.ui.tabs.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.jqChart.css" />
<link rel="stylesheet" type="text/css"
	href="../css/jquery.jqRangeSlider.css" />
<script src="../js/jquery.mousewheel.js" type="text/javascript"></script>
<script src="../js/jquery.jqChart.min.js" type="text/javascript"></script>
<script src="../js/jquery.jqRangeSlider.min.js" type="text/javascript"></script>
<style type="text/css">
table tr td .list_left {
	background-color: #F5F4E5;
	font-weight: bold;
	padding-left: 5px;
	vertical-align: top;
	width: 150px;
}

table tr td .list_right {
	border-bottom: 1px #DDDDDD solid;
}

.ui-datepicker { font-size: 10px !important; }
</style>

<script type="text/javascript">

$(function() {
	$( "#edcmaintenance_date" ).datepicker({
		dateFormat: "dd/mm/yy",
		changeMonth: true,
		changeYear: true
	});
});

function submitSave(){
	if(confirm('Anda yakin ingin menyimpan?')){

		var action = document.createElement("input");
		var formaction = document.createElement("input");
		 
	    // Add the new element to our form. 
	    form =document.getElementById('frmSearch');
	    
	    form.appendChild(action);
	    action.name = "action";
	    action.type = "hidden";
	    action.value = "input_maintenance_edc";

	    form.appendChild(formaction);
	    formaction.name = "saveaction";
	    formaction.type = "hidden";
	    formaction.value = "save";
	    //alert(p.value);
	    // Finally submit the form. 
	    form.submit();
		//document.getElementById('frmSearch').submit();
	}
}

function submitSearch(){
	
	var action = document.createElement("input");
	var formaction = document.createElement("input");
	 
    // Add the new element to our form. 
    form =document.getElementById('frmSearch');
    
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "input_maintenance_edc";

    form.appendChild(formaction);
    formaction.name = "saveaction";
    formaction.type = "hidden";
    formaction.value = "search";
    //alert(p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
	
}
</script>
</head>
<body>
	<form action="../edc/dashboard_edc.php" method="post"
		style="margin: 0px;" id="frmSearch" name="frmSearch">
<?php 
$edcmaintenance_id=
$edcmaintenance_tid=
$edcmaintenance_keterangan=
$edcmaintenance_jenis_id=
$edcmaintenance_date=
$edcmaintenance_petugas=
$edcmaintenance_branch_id=
$edcmaintenance_status_id=
$edcmaintenance_creauser=
$edcmaintenance_creadt=
$edcmaintenance_updusr=
$edcmaintenance_upddt=
$edc_desc=$kanca_select_kode=$kanca_select_id=$kanca_select_desc=$formaction=
$jenismaintenance_select_id=$jenismaintenance_select_desc=
$status_select_id=$status_select_desc="";

//initialize connection
$mysqli = getConnection();

if (!empty($_POST["saveaction"])){
	
	$formaction = $_POST["saveaction"];
	$edcmaintenance_tid = mysqli_real_escape_string($mysqli,$_POST['edcmaintenance_tid']);
	$edcmaintenance_keterangan = mysqli_real_escape_string($mysqli,$_POST['edcmaintenance_keterangan']);
	$edcmaintenance_petugas = mysqli_real_escape_string($mysqli,$_POST['edcmaintenance_petugas']);
	$edcmaintenance_branch_id = mysqli_real_escape_string($mysqli,$_POST['select_kodeuker']);
	
	
if ($formaction == "save") {	
	
	$edc_desc = mysqli_real_escape_string($mysqli,$_POST['edc_deschidden']);
	// Insert the data into the database
	$insert_prep = "INSERT INTO m_edc_maintenance
					            (edcmaintenance_tid,
					             edcmaintenance_keterangan,
					             edcmaintenance_jenis_id,
					             edcmaintenance_date,
					             edcmaintenance_petugas,
					             edcmaintenance_branch_id,
					             edcmaintenance_status_id,
					             edcmaintenance_creauser,
					             edcmaintenance_creadt,
					             edcmaintenance_updusr,
					             edcmaintenance_upddt)
					VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
	
	$insert_stmt = $mysqli->prepare($insert_prep);
	
	if ($insert_stmt) {
		$txtCreateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
		
		$varDate = str_replace('/', '-', $_POST["edcmaintenance_date"]);
		$txtMaintenanceDt = date('Y/m/d', strtotime($varDate));
		$txtMaintenanceDt = mysqli_real_escape_string($mysqli,$txtMaintenanceDt);
		 
        	if (!empty($_SESSION['user_pn'])) {
        		$txtCreateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);
        		$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);
        	}else {
        		$txtCreateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
        		$txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
        	}
		 
		$insert_stmt->bind_param('isissiissss', 
													validateInput($edcmaintenance_tid),
													validateInput($edcmaintenance_keterangan),
													validateInput($_POST['select_jenismaintenance']),
													validateInput($txtMaintenanceDt),
													validateInput($edcmaintenance_petugas),
													validateInput($_POST['select_kodeuker']),
													validateInput($_POST['select_status']),
													validateInput($txtCreateUser),
													validateInput($txtCreateDt),
													validateInput($txtUpdateUser),
													validateInput($txtUpdateDt));
	
		// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data.');
				  </script>";
		}else echo "<script type='text/javascript'>
					alert('Data berhasil disimpan.');
				  </script>";
		$edc_desc = $edcmaintenance_tid = $edcmaintenance_keterangan = $edcmaintenance_jenis_id = $_POST['select_jenismaintenance'] = 
		$edcmaintenance_branch_id = $_POST['select_kodeuker'] = $edcmaintenance_status_id = $_POST['select_status'] = $edcmaintenance_petugas = "";
	}else{
		echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data.');
				  </script>";
		/* header('Location: ../kanwiljak3/error.php?error=1');
		session_write_close(); */
	}
}elseif ($formaction == "search")	{
	$search_prep = " SELECT IF(EXISTS(SELECT edcmerchant_id FROM m_edc_merchant WHERE edcmerchant_tid = $edcmaintenance_tid),
										(SELECT edcmerchant_nama FROM m_edc_merchant WHERE edcmerchant_tid = $edcmaintenance_tid),
										(IF(EXISTS(SELECT edcbrilink_id FROM m_edc_brilink WHERE edcbrilink_tid = $edcmaintenance_tid),
										(SELECT edcbrilink_agen FROM m_edc_brilink WHERE edcbrilink_tid = $edcmaintenance_tid),
										(SELECT edcuko_lokasi FROM m_edc_uko WHERE edcuko_tid = $edcmaintenance_tid)))) AS edc_desc ";
	
	$search_stmt = $mysqli->prepare($search_prep);
	if ($search_stmt) {
		$search_stmt->execute();
		$search_stmt->store_result();
		
		if ($search_stmt->num_rows >= 1) {
		
			$search_stmt->bind_result($edc_desc);
			$search_stmt->fetch();
		}
	}
}	 

}

//get maintenance list
$select_tipe = "SELECT 0 as jenismaintenance_id,'-' as jenismaintenance_desc UNION ALL SELECT jenismaintenance_id,jenismaintenance_desc FROM m_jenismaintenance ";
$tipe_stmt = $mysqli->prepare($select_tipe);
if ($tipe_stmt) {

	$tipe_stmt->execute();
	$tipe_stmt->store_result();
}

if ($tipe_stmt->num_rows >= 1) {
	$tipe_stmt->bind_result($jenismaintenance_select_id,$jenismaintenance_select_desc);
}

//get KC list
$select_kanca = "select 0 as branch_id,0 as branch_mbcode,'-' as branch_name 
										union all 
										SELECT distinct branch_id ,branch_mbcode,branch_mbname as branch_name FROM m_branch WHERE branch_mbcode = branch_code order by branch_mbcode ";
$kanca_stmt = $mysqli->prepare($select_kanca);
if ($kanca_stmt) {

	$kanca_stmt->execute();
	$kanca_stmt->store_result();
}

if ($kanca_stmt->num_rows >= 1) {
	$kanca_stmt->bind_result($kanca_select_id,$kanca_select_kode,$kanca_select_desc);
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

?>
<div class="right">
			<table width="100%" border="1" cellspacing="0" cellpadding="0">
				<tr>
					<td height="3">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" valign="middle"><h3 style="margin-top: 0px;">
										<b>ADD MAINTENANCE</b>
									</h3></td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td valign="top"><table width="100%" border="0" cellpadding="00">
							<tr>
								<td align="center" valign="top">
									<table width="100%" border="0" cellpadding="2" cellspacing="0">
										<?php if ($edc_desc == "" && $formaction =="search") {
											?><tr valign="middle"><td class="prLBL1" align="center" style="font-size:12px; background-color:#ff0000; color:#ffffff; border:1px solid #008800;"><b>Nama Uker / Merchant / Agen tidak ditemukan.</b></td></tr>
											<tr valign="middle"><td class="prLBL1" align="center" style="font-size:12px; background-color:#ff0000; color:#ffffff; border:1px solid #008800;"><b>Nama Uker / Merchant / Agen tidak ditemukan.</b></td></tr>
										<?php ;
										}?>
										<tr valign="middle">
											<td align="left"><h5>
													<i>FORM ADD MAINTENANCE</i>
												</h5></td>
										</tr>
										<tr align="left" valign="middle">
											<td>
												<table border="0">
													<tr>
														<td>Terminal ID</td>
														<td>:</td>
														<td>
														<input type="text" id="edcmaintenance_tid" name="edcmaintenance_tid"value="<?php echo $edcmaintenance_tid;?>" onkeypress="return numbersonly(this, event)"/>
														<input type="button" value=" Search " id="btnSearch" name="btnSearch" onclick="submitSearch();"/>
														</td>
													</tr>
													<tr>
<!-- 														<td>Type</td> -->
<!-- 														<td>:</td> -->
<!-- 														<td><select name="select_tipe"> -->
														<?php 
// 															while ($tipe_stmt->fetch()){
// 																	if ($_POST['select_tipe'] == $edctipe_select_id) {
// 																		echo '<option value="'.$edctipe_select_id.'" selected>'.strtoupper($edctipe_select_desc).'</option>';
// 																	}else
// 																		echo '<option value="'.$edctipe_select_id.'">'.strtoupper($edctipe_select_desc).'</option>';
// 															}
// 														?>
<!-- 														</select>  -->
<!-- 														</td> -->
														<td>Uker / Merchant / Agen</td>
														<td>: </td>
														<td>
														<input type="text" name="edc_desc" value="<?php echo $edc_desc?>" disabled="disabled" maxlength="40" style="width:340px;" />
														<input type="hidden" id="edc_deschidden" name="edc_deschidden" value="<?php echo $edc_desc?>"/>
														</td>
						
													</tr>
													<tr>
														<td valign="top">Keterangan</td>
														<td valign="top">:</td>
														<td><textarea name="edcmaintenance_keterangan" rows="7" cols="40"
																dir="ltr"><?php echo $edcmaintenance_keterangan;?></textarea></td>
													</tr>
													<tr>
														<td>Jenis Maintenance</td>
														<td>:</td>
														<td><select name="select_jenismaintenance">
														<?php 
															while ($tipe_stmt->fetch()){
																	if ($_POST['select_jenismaintenance'] == $jenismaintenance_select_id) {
																		echo '<option value="'.$jenismaintenance_select_id.'" selected>'.strtoupper($jenismaintenance_select_desc).'</option>';
																	}else
																		echo '<option value="'.$jenismaintenance_select_id.'">'.strtoupper($jenismaintenance_select_desc).'</option>';
															}
														?>
														</select></td>
													</tr>
													<tr>
														<td> Tanggal (dd/mm/yyyy)</td>
														<td>: </td>
														<td><input type="text" id="edcmaintenance_date" name="edcmaintenance_date" value="<?php echo $edcmaintenance_date?>" 
														onkeyup="DateFormat(this,this.value,event,false,'3')" 
									            	onblur="DateFormat(this,this.value,event,true,'3')" size="10"/>
														</td>
													</tr>
													<tr>
														<td>Nama</td>
														<td>:</td>
														<td><input type="text" name="edcmaintenance_petugas" value="<?php echo $edcmaintenance_petugas;?>" /></td>
													</tr>
													<tr>
														<td>Unit Kerja</td>
														<td>:</td>
														<td><select name="select_kodeuker">
														<?php 
															while ($kanca_stmt->fetch()){
																	if ($_POST['select_kodeuker'] == $kanca_select_id) {
																		echo '<option value="'.$kanca_select_id.'" selected>'.strtoupper($kanca_select_desc).'</option>';
																	}else
																		echo '<option value="'.$kanca_select_id.'">'.strtoupper($kanca_select_desc).'</option>';
															}
														?>
														</select></td>
													</tr>
													<tr>
														<td>Status</td>
														<td>:</td>
														<td><select name="select_status">
														<?php 
																while ($status_stmt->fetch()){
																	if ($_POST['select_status'] == $status_select_id) {
																			echo '<option value="'.$status_select_id.'" selected>'.$status_select_desc.'</option>';
																	}else 
																		echo '<option value="'.$status_select_id.'">'.$status_select_desc.'</option>';
																}
																?>
																</select>
														</td>
													</tr>
													<tr>
														<td colspan="3">
														<?php if ($edc_desc != "" && $formaction =="search") {
														?><input type="button" value=" Simpan" id="btnSimpan" name="btnSimpan" onclick="submitSave();"/>														
														<?php ;
														}?>
														</td>
													</tr>
												</table>
											</td>
										</tr>

									</table>							
								<td align="right" valign="top">&nbsp;</td>
							</tr>
						</table></td>
				</tr>
				
			</table>
		</div>
	</form>
</body>
</html>