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

#text_custom, #atmjadwal_date {
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
	$( "#atmjadwal_date" ).datepicker({
		dateFormat: "dd/mm/yy",
		changeMonth: true,
		changeYear: true
	});
});

function submitSave(form,
		atmjadwal_date,
		atmjadwal_tid,
		select_kanca,
		atmjadwal_pic,
		atmjadwal_keterangan){ 
	
	if(insertJadwalATMValidation(form,
			atmjadwal_date,
			atmjadwal_tid,
			select_kanca,
			atmjadwal_pic,
			atmjadwal_keterangan)){
		
		if(confirm('Anda yakin ingin menyimpan?')){
			var action = document.createElement("input");
			var saveaction = document.createElement("input");
			 
		    // Add the new element to our form. 
		    form =document.getElementById('frmSearch');

		    form.appendChild(action);
		    action.name = "action";
		    action.type = "hidden";
		    action.value = "input_jadwal_atm";
		
		    form.appendChild(saveaction);
		    saveaction.name = "saveaction";
		    saveaction.type = "hidden";
		    saveaction.value = "input_jadwal_atm";
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
$atmjadwal_id=
$atmjadwal_date=
$atmjadwal_branch_id=
$atmjadwal_tid=
$atmjadwal_pic=
$atmjadwal_keterangan=
$atmjadwal_creadt=
$atmjadwal_creausr=
$atmjadwal_upddt=
$atmjadwal_updusr=
$atmjadwal_isactive=
$branch_desc=
$kanca_select_id=$kanca_select_desc=$kanca_select_mbcode=
$tid=
$status_select_id=$status_select_desc=
$provider_id=$provider_desc=
$saveaction="";

$isActive = 1;

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}
//$tid=21157335;

$mysqli = getConnection();

if (!empty($_POST["saveaction"])){
	$saveaction = $_POST["saveaction"];
	
	insertATMJadwal($mysqli);
		 
}

//get kanca list
$kanca_stmt = getKancaList($mysqli);
if ($kanca_stmt->num_rows >= 1) {
	$kanca_stmt->bind_result($kanca_select_id,$kanca_select_mbcode,$kanca_select_desc);
}
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
					<li><a href="#tabs-1" style="font-size:12px;"><b>Input Jadwal</b></a></li>
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
					<td class="list_left"> Tanggal</td>
					<td class="list_right">: 
					<input type="text" id="atmjadwal_date" name="atmjadwal_date" value="<?php echo $atmjadwal_date?>" 
					onkeyup="DateFormat(this,this.value,event,false,'3')" 
            	onblur="DateFormat(this,this.value,event,true,'3')" size="10"/>
					</td>
				</tr>
				<tr>
					<td class="list_left">TID</td>
					<td class="list_right">: <input id="text_custom" name="atmjadwal_tid" value="<?php echo $atmjadwal_tid?>" maxlength="10"/></td>
				</tr>
				<tr>
					<td class="list_left">Kanca</td>
					<td class="list_right">: 
					<select name="select_kanca" id="select_custom">
					<?php 
							while ($kanca_stmt->fetch()){
								if ($atmjadwal_branch_id == $kanca_select_id) {
										echo '<option value="'.$kanca_select_id.'" selected>'.$kanca_select_desc.'</option>';
								}else 
									echo '<option value="'.$kanca_select_id.'">'.$kanca_select_desc.'</option>';
							}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<td class="list_left">PIC</td>
					<td class="list_right">: <input id="text_custom" name="atmjadwal_pic" value="<?php echo $atmjadwal_pic?>" maxlength="100"/></td>
				</tr>
				<tr>
					<td class="list_left">Keterangan</td>
					<td class="list_right">: <input id="text_custom" name="atmjadwal_keterangan" value="<?php echo $atmjadwal_keterangan?>" maxlength="255" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="1" align="center">
			<div style="margin-top:20px;">
				<input type="button" value=" Simpan" id="btnSimpan" name="btnSimpan" 
				
				onclick="submitSave(this.form,
														this.form.atmjadwal_date,
														this.form.atmjadwal_tid,
														this.form.select_kanca,
														this.form.atmjadwal_pic,
														this.form.atmjadwal_keterangan
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