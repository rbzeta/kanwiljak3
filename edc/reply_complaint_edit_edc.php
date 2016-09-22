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
	    action.value = "replycomplaintbytid";

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
	<form action="../edc/dashboard_edc.php" method="post"
		style="margin: 0px;" id="frmSearch" name="frmSearch">
<?php 

$status_select_id=$status_select_desc=$edccomplaint_tid=$kanca_select_kode=$edc_desc=$edccomplaint_keterangan=$edccomplaint_pic=
$kanca_select_id=$kanca_select_desc=$formaction=$edccomplaint_lokasi=$tid=$edccomplaint_id=$branch_name="";

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}

//initialize connection
$mysqli = getConnection();

if (!empty($_POST["saveaction"])){
	
	$formaction = $_POST["saveaction"];
	$edccomplaint_status = mysqli_real_escape_string($mysqli,$_POST['select_status']);
	$edccomplaint_tindakan = mysqli_real_escape_string($mysqli,$_POST['edccomplaint_tindakan']);
	$edccomplaint_id = mysqli_real_escape_string($mysqli,$_POST['edccomplaint_id']);
	
	
if ($formaction == "save") {	
	
	// Insert the data into the database
	$insert_prep = "UPDATE m_edc_complaint
					SET edccomplaint_status = ?, 
					  edccomplaint_updusr = ?,
					  edccomplaint_upddt = ?,
					  edccomplaint_tindakan = ?
					WHERE edccomplaint_id = ? ";
	
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
		 
		$insert_stmt->bind_param('issss', 
				validateInput($edccomplaint_status),
				validateInput($txtUpdateUser),
				validateInput($txtUpdateDt),
				validateInput($edccomplaint_tindakan),
				validateInput($edccomplaint_id));
	
		// Execute the prepared query.
		if (! $insert_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data.');
				  </script>";
		}else echo "<script type='text/javascript'>
					alert('Data berhasil disimpan.');
					redirectPage('replycomplainttiket');
				  </script>";
		$edccomplaint_tindakan = $edc_desc = $edccomplaint_tid = $edccomplaint_keterangan = $edccomplaint_pic = 
		$edccomplaint_kodeuker = $_POST['select_kodeuker'] = $_POST['select_status'] = $edccomplaint_status = "";
	}else{
		echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menyimpan data.');
				  </script>";
		/* header('Location: ../kanwiljak3/error.php?error=1');
		session_write_close(); */
	}
}
}

//get detil when page load first time
$select_prep = " SELECT edccomplaint_id,branch_name,
						  edccomplaint_tid,
						  edccomplaint_pic,
						  edccomplaint_keterangan,
						  edccomplaint_kodeuker,
						  edccomplaint_status,
						  edccomplaint_lokasi,
						  edccomplaint_tindakan
						FROM m_edc_complaint 
						LEFT JOIN m_branch ON branch_id = edccomplaint_kodeuker
						WHERE edccomplaint_id = ? LIMIT 1";

$select_stmt = $mysqli->prepare($select_prep);
if ($select_stmt) {
	$select_stmt->bind_param('s', $tid);
	$select_stmt->execute();
	$select_stmt->store_result();

	if ($select_stmt->num_rows >= 1) {

		$select_stmt->bind_result($edccomplaint_id,$branch_name,
									$edccomplaint_tid,
									$edccomplaint_pic,
									$edccomplaint_keterangan,
									$edccomplaint_kodeuker,
									$edccomplaint_status,
									$edccomplaint_lokasi,
									$edccomplaint_tindakan);
		$select_stmt->fetch();
	}
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
			<table width="100%" style="font: 11px/20px normal Helvetica, Arial, sans-serif !important; margin:10px 0 0 0;">
				<tr>
					<td valign="top" width="50%">
						<table width="100%" border="0" cellpadding="1" cellspacing="2">
							<tr>
								<td class="list_left">TERMINAL ID</td>
								<td class="list_right">: <?php echo $edccomplaint_tid?></td>
							</tr>
							<tr>
								<td class="list_left">UKER / MERCHANT / AGEN</td>
								<td class="list_right">: <?php echo $edccomplaint_lokasi?></td>
							</tr>
							<tr>
								<td class="list_left">KANCA</td>
								<td class="list_right">: <?php echo $branch_name?></td>
							</tr>
							<tr>
								<td class="list_left">PIC</td>
								<td class="list_right">: <?php echo $edccomplaint_pic?></td>
							</tr>
							<tr>
								<td class="list_left">KETERANGAN</td>
								<td class="list_right">: <?php echo $edccomplaint_keterangan?></td>
							</tr>
							<tr>
								<td class="list_left">STATUS</td>
								<td class="list_right">: 
								<select name="select_status" id="select_custom">
								<?php 
										while ($status_stmt->fetch()){
											if ($edccomplaint_status == $status_select_id) {
													echo '<option value="'.$status_select_id.'" selected>'.$status_select_desc.'</option>';
											}else 
												echo '<option value="'.$status_select_id.'">'.$status_select_desc.'</option>';
										}
										?>
										</select>
								</td>
							</tr>
							
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%" border="0" cellpadding="1" cellspacing="2">
							<tr>
								<td class="list_left">TINDAK LANJUT</td>
								<td class="list_right">: 
								<textarea id="edccomplaint_tindakan" name="edccomplaint_tindakan" rows="3" cols="100" dir="ltr"><?php echo $edccomplaint_tindakan?></textarea>
								<input type="hidden" id="edccomplaint_id" name="edccomplaint_id" value="<?php echo $edccomplaint_id?>"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<div style="margin-top:20px;">
							<input type="button" value=" Simpan" id="btnSimpan" name="btnSimpan" onclick="submitSave();"/>
							
						</div>
					</td>
				</tr>
			</table>
		</div>
	</form>
</body>
</html>