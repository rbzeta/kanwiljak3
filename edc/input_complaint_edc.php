<?php 
if (empty($_SESSION['user_pn'])) {
	$_SESSION["login_error"] = "Halaman tidak dapat diakses, silahkan login terlebih dahulu.";
	header('Location: ../login/login.php?error=1');
	session_write_close();
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
</style>

<script type="text/javascript">

function submitSave(){
	if(confirm('Anda yakin ingin menyimpan?')){

		var action = document.createElement("input");
		var formaction = document.createElement("input");
		 
	    // Add the new element to our form. 
	    form =document.getElementById('frmSearch');
	    
	    form.appendChild(action);
	    action.name = "action";
	    action.type = "hidden";
	    action.value = "inputcomplainttiket";

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
    action.value = "inputcomplainttiket";

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

$edctipe_select_id=$edctipe_select_desc=$edccomplaint_tid=$kanca_select_kode=$edc_desc=$edccomplaint_keterangan=$edccomplaint_pic=$edccomplaint_nohppic=
$kanca_select_id=$kanca_select_desc=$formaction="";

//initialize connection
$mysqli = getConnection();

if (!empty($_POST["saveaction"])){
	
	$formaction = $_POST["saveaction"];
	$edccomplaint_tid = mysqli_real_escape_string($mysqli,$_POST['edccomplaint_tid']);
	$edccomplaint_keterangan = mysqli_real_escape_string($mysqli,$_POST['edccomplaint_keterangan']);
	$edccomplaint_pic = mysqli_real_escape_string($mysqli,$_POST['edccomplaint_pic']);
	$edccomplaint_nohppic = mysqli_real_escape_string($mysqli,$_POST['edccomplaint_nohppic']);
	$edccomplaint_kodeuker = mysqli_real_escape_string($mysqli,$_POST['select_kodeuker']);
	
	
if ($formaction == "save") {	
	
	$edc_desc = mysqli_real_escape_string($mysqli,$_POST['edc_deschidden']);
	// Insert the data into the database
	$insert_prep = "INSERT INTO m_edc_complaint
				            (edccomplaint_tid,
				             edccomplaint_pic,
				             edccomplaint_keterangan,
				             edccomplaint_kodeuker,
				             edccomplaint_creausr,
				             edccomplaint_creadt,
				             edccomplaint_updusr,
				             edccomplaint_upddt,
							 edccomplaint_lokasi,
							 edccomplaint_status,
							 edccomplaint_nohppic)
					VALUES (?,?,?,?,?,?,?,?,?,?,?) ";
	
	$insert_stmt = $mysqli->prepare($insert_prep);
	
	if ($insert_stmt) {
		$txtCreateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
        	if (!empty($_SESSION['user_pn'])) {
        		$txtCreateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);
        		$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);
        	}else {
        		$txtCreateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
        		$txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
        	}
		 
		$insert_stmt->bind_param('ississsssss', 
													validateInput($edccomplaint_tid),
													validateInput($edccomplaint_pic),
													validateInput($edccomplaint_keterangan),
													validateInput($edccomplaint_kodeuker),
													validateInput($txtCreateUser),
													validateInput($txtCreateDt),
													validateInput($txtUpdateUser),
													validateInput($txtUpdateDt),
													validateInput($edc_desc),
													//default value pending status
													validateInput("2"),
													validateInput($edccomplaint_nohppic));
	
		// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data.');
				  </script>";
		}else echo "<script type='text/javascript'>
					alert('Data berhasil disimpan.');
				  </script>";
		$edc_desc = $edccomplaint_tid = $edccomplaint_keterangan = $edccomplaint_pic = $edccomplaint_kodeuker = $_POST['select_kodeuker'] = $edccomplaint_nohppic = "";
	}else{
		echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data.');
				  </script>";
		/* header('Location: ../kanwiljak3/error.php?error=1');
		session_write_close(); */
	}
}elseif ($formaction == "search")	{
	$search_prep = " SELECT IF(EXISTS(SELECT edcmerchant_id FROM m_edc_merchant WHERE edcmerchant_tid = $edccomplaint_tid),
										(SELECT edcmerchant_nama FROM m_edc_merchant WHERE edcmerchant_tid = $edccomplaint_tid),
										(IF(EXISTS(SELECT edcbrilink_id FROM m_edc_brilink WHERE edcbrilink_tid = $edccomplaint_tid),
										(SELECT edcbrilink_agen FROM m_edc_brilink WHERE edcbrilink_tid = $edccomplaint_tid),
										(SELECT edcuko_lokasi FROM m_edc_uko WHERE edcuko_tid = $edccomplaint_tid)))) AS edc_desc ";
	
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

//get tipe list
$select_tipe = "SELECT 0 as edctipe_id,'-' as edctipe_desc UNION ALL SELECT edctipe_id,edctipe_desc FROM m_edc_tipe ";
$tipe_stmt = $mysqli->prepare($select_tipe);
if ($tipe_stmt) {

	$tipe_stmt->execute();
	$tipe_stmt->store_result();
}

if ($tipe_stmt->num_rows >= 1) {
	$tipe_stmt->bind_result($edctipe_select_id,$edctipe_select_desc);
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
?>
<div class="right">
			<table width="100%" border="1" cellspacing="0" cellpadding="0">
				<tr>
					<td height="3">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" valign="middle"><h3 style="margin-top: 0px;">
										<b>ADD COMPLAINT</b>
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
										<?php ;
										}?>
										<tr valign="middle">
											<td align="left"><h5>
													<i>FORM ADD COMPLAINT</i>
												</h5></td>
										</tr>
										<tr align="left" valign="middle">
											<td>
												<table border="0">
													<tr>
														<td>Terminal ID</td>
														<td>:</td>
														<td>
														<input type="text" id="edccomplaint_tid" name="edccomplaint_tid" value="<?php echo $edccomplaint_tid;?>" onkeypress="return numbersonly(this, event)"/>
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
														<td><textarea name="edccomplaint_keterangan" rows="7" cols="40"
																dir="ltr"><?php echo $edccomplaint_keterangan;?></textarea></td>
													</tr>
													<tr>
														<td>Nama PIC Uker</td>
														<td>:</td>
														<td><input type="text" name="edccomplaint_pic" value="<?php echo $edccomplaint_pic;?>" /></td>
													</tr>
													<tr>
														<td>No Telp PIC</td>
														<td>:</td>
														<td><input type="text" name="edccomplaint_nohppic" value="<?php echo $edccomplaint_nohppic;?>" /></td>
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