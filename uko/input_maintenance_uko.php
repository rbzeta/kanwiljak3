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

#text_custom, #ukermaintenance_date {
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
	$( "#ukermaintenance_date" ).datepicker({
		dateFormat: "dd/mm/yy",
		changeMonth: true,
		changeYear: true
	});
});

function submitSave(form,
		ukermaintenance_date,
		select_kanca,
		ukermaintenance_keterangan,
		ukermaintenance_problem,
		ukermaintenance_tindaklanjut,
		select_status,
		ukermaintenance_pic
		){
	
	if(insertUkoMaintenanceValidation(form,
			ukermaintenance_date,
			select_kanca,
			ukermaintenance_keterangan,
			ukermaintenance_problem,
			ukermaintenance_tindaklanjut,
			select_status,
			ukermaintenance_pic
			)){

		
		if(confirm('Anda yakin ingin menyimpan?')){
			var p = document.createElement("input");
			var action = document.createElement("input");
			var saveaction = document.createElement("input");
			 
		    // Add the new element to our form. 
		    form =document.getElementById('frmSearch');

		    form.appendChild(action);
		    action.name = "action";
		    action.type = "hidden";
		    action.value = "input_maintenance_uko";
		
		    form.appendChild(saveaction);
		    saveaction.name = "saveaction";
		    saveaction.type = "hidden";
		    saveaction.value = "input_maintenance_uko";
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
<form action="../uko/dashboard_uko.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch">
<?php 
date_default_timezone_set("Asia/Jakarta");

$ukermaintenance_id=
$ukermaintenance_date=
$ukermaintenance_branch_id=
$ukermaintenance_problem=
$ukermaintenance_tindaklanjut=
$ukermaintenance_status_id=
$ukermaintenance_pic=
$ukermaintenance_keterangan=
$ukermaintenance_user_id=
$ukermaintenance_creadt=
$ukermaintenance_creauser=
$ukermaintenance_upddt=
$ukermaintenance_updusr=
$cro_select_id=$cro_select_desc=
$atmbrand_select_id=$atmbrand_select_nama=
$kanca_select_id=$kanca_select_desc=$kanca_select_mbcode=
$kategori_select_id=$kategori_select_desc=
$status_select_id=$status_select_desc=
$team_select_id=$team_select_desc=
$saveaction="";

$mysqli = getConnection();

if (!empty($_POST["saveaction"])){
	$saveaction = $_POST["saveaction"];
	
	// insert the data into the database
	$insert_prep = "INSERT INTO m_uker_maintenance 
					            (ukermaintenance_date,
					             ukermaintenance_branch_id,
					             ukermaintenance_problem,
					             ukermaintenance_tindaklanjut,
					             ukermaintenance_status_id,
					             ukermaintenance_pic,
					             ukermaintenance_keterangan,
					             ukermaintenance_user_id,
					             ukermaintenance_creadt,
					             ukermaintenance_creauser,
					             ukermaintenance_upddt,
					             ukermaintenance_updusr)
						VALUES (?,
						        ?,
						        ?,
						        ?,
						        ?,
						        ?,
						        ?,
						        ?,
						        ?,
						        ?,
						        ?,
						        ?);  ";
	
	$insert_stmt = $mysqli->prepare($insert_prep);
	
	if ($insert_stmt) {
		
		$varDate = str_replace('/', '-', $_POST["ukermaintenance_date"]);
		$txtDate = date('Y/m/d', strtotime($varDate));
		$txtDate = mysqli_real_escape_string($mysqli,$txtDate);
		
		$txtUpdateDt = mysqli_real_escape_string($mysqli,date("Y/m/d H:i:s"));
        	if (!empty($_SESSION['user_pn'])) {
        		$txtUpdateUser = mysqli_real_escape_string($mysqli,$_SESSION['user_pn']);
        	}else $txtUpdateUser = mysqli_real_escape_string($mysqli,"page_hardcode");
		 
		$insert_stmt->bind_param('sissississss', 
													validateInput($txtDate),
													validateInput($_POST['select_kanca']),
													validateInput($_POST['ukermaintenance_problem']),
													validateInput($_POST['ukermaintenance_tindaklanjut']),
													validateInput($_POST['select_status']),
													validateInput($_POST['ukermaintenance_pic']),
													validateInput($_POST['ukermaintenance_keterangan']),
													validateInput($_SESSION['user_id']),
													validateInput($txtUpdateDt),
													validateInput($txtUpdateUser),
													validateInput($txtUpdateDt),
													validateInput($txtUpdateUser));
	
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


if ($isUker) {
	$teamQry = "select 0 as user_id,'-' as user_lname union all SELECT distinct user_id,user_lname FROM m_user
															where user_uker = 1 and user_id = ? order by user_lname";
	$kancaQry = "select 0 as branch_id,0 as branch_mbcode,'-' as branch_name union all SELECT distinct branch_id ,branch_mbcode,concat(branch_mbcode,' - ',branch_mbname) as branch_name 
					             		FROM m_branch WHERE branch_id = ? order by branch_mbcode ";
}else {
	$teamQry = "select 0 as user_id,'-' as user_lname union all SELECT distinct user_id,user_lname FROM m_user
															where user_uker = 0 and user_id = ? order by user_lname";
	$kancaQry = "SELECT 0 AS branch_id,0 AS branch_mbcode,'-' AS branch_name 
										UNION ALL 
										SELECT DISTINCT branch_id ,branch_mbcode,branch_mbname AS branch_name FROM m_branch WHERE branch_mbcode = branch_code ORDER BY branch_mbcode ";
}

//get kanca list
$select_kanca = $kancaQry;
$kanca_stmt = $mysqli->prepare($select_kanca);
if ($kanca_stmt) {
	$ukermaintenance_branch_id = $_SESSION['user_branch_id'];
	
	if ($isUker)$kanca_stmt->bind_param('i', $ukermaintenance_branch_id);
	
	$kanca_stmt->execute();
	$kanca_stmt->store_result();
}

if ($kanca_stmt->num_rows >= 1) {
	$kanca_stmt->bind_result($kanca_select_id,$kanca_select_mbcode,$kanca_select_desc);
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="3">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td align="center" valign="middle"><h3 style="margin-top:0px;"><b><?php echo $ukermaintenance_keterangan?></b></h3></td>
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
					<li><a href="#tabs-1" style="font-size:12px;"><b>Maintenance</b></a></li>
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
					<td class="list_left"> Tanggal (dd/mm/yyyy)</td>
					<td class="list_right">: 
					<input type="text" id="ukermaintenance_date" name="ukermaintenance_date" value="<?php echo $ukermaintenance_date?>" 
					onkeyup="DateFormat(this,this.value,event,false,'3')" 
            	onblur="DateFormat(this,this.value,event,true,'3')" size="10"/>
					</td>
				</tr>
				<tr>
					<td class="list_left">KC Supervisi</td>
					<td class="list_right">: 
					<select name="select_kanca" id="select_custom">
					<?php 
					
							while ($kanca_stmt->fetch()){
								if ($ukermaintenance_branch_id == $kanca_select_id) {
										echo '<option value="'.$kanca_select_id.'" selected>'.$kanca_select_desc.'</option>';
								}else 
									echo '<option value="'.$kanca_select_id.'">'.$kanca_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">Lokasi</td>
					<td class="list_right">: <input id="text_custom" name="ukermaintenance_keterangan" value="<?php echo $ukermaintenance_keterangan?>" maxlength="255" /></td>
				</tr>
				<tr>
					<td class="list_left">Problem</td>
					<td class="list_right">: <input id="text_custom" name="ukermaintenance_problem" value="<?php echo $ukermaintenance_problem?>" maxlength="255" /></td>
				</tr>
				<tr>
					<td class="list_left">Tindak Lanjut</td>
					<td class="list_right">: <input id="text_custom" name="ukermaintenance_tindaklanjut" value="<?php echo $ukermaintenance_tindaklanjut?>" maxlength="255" /></td>
				</tr>
				<tr>
					<td class="list_left">Status</td>
					<td class="list_right">: 
					<select name="select_status" id="select_custom">
					<?php 
							while ($status_stmt->fetch()){
								if ($ukermaintenance_status_id == $status_select_id) {
										echo '<option value="'.$status_select_id.'" selected>'.$status_select_desc.'</option>';
								}else 
									echo '<option value="'.$status_select_id.'">'.$status_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">PIC</td>
					<td class="list_right">: <input id="text_custom" name="ukermaintenance_pic" value="<?php echo $ukermaintenance_pic?>" maxlength="50" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="1" align="center">
			<div style="margin-top:20px;">
				<input type="button" value=" Simpan" id="btnSimpan" name="btnSimpan" 
				
				onclick="submitSave(this.form,
														this.form.ukermaintenance_date,
														this.form.select_kanca,
														this.form.ukermaintenance_keterangan,
														this.form.ukermaintenance_problem,
														this.form.ukermaintenance_tindaklanjut,
														this.form.select_status,
														this.form.ukermaintenance_pic
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