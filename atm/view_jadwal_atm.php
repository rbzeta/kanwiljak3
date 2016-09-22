<?php 

$isUker = 0;
if (!empty($_SESSION['user_pn'])) {
	$logged = "in";
	if ($_SESSION['user_uker']) {
		$isUker = 1;
	}
}


?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Portal BRI Kanwil Jakarta 3</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../css/jquery-1.6.4.min.js"></script>
<script src="../js/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="../css/utils.js"></script>
<script type="text/JavaScript" src="../js/forms.js"></script>
<style type="text/css">@import "../css/menu.css";</style>
<style type="text/css">@import "../css/table.css";</style>
<link rel="stylesheet" href="../js/jquery-ui-1.8.13/themes/base/jquery.ui.all.css"></link>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/jquery-1.5.1.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.accordion.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.13/ui/jquery.ui.datepicker.js"></script>

<style type="text/css">

</style>

<script type="text/javascript">

function submitSearch(){
	var p = document.createElement("input");
	var action = document.createElement("input");

	// Add the new element to our form. 
    form =document.getElementById('frmSearch');
    form.appendChild(p);
    p.name = "actioncari";
    p.type = "hidden";
    p.value = "cari";
    
    // Add the new element to our form. 
	form =document.getElementById('frmSearch');
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "view_jadwal_atm";
    
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
	
}

function updateAction(recId){
	var p = document.createElement("input");
	var action = document.createElement("input");
	 
    // Add the new element to our form. 
    form =document.getElementById('frmSearch');
    form.appendChild(p);
    p.name = "tid";
    p.type = "hidden";
    p.value = recId;
    
    form.appendChild(action);
    action.name = "action";
    action.type = "hidden";
    action.value = "update_jadwal_atm";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
	
}

function deleteAction(recId){
	if(confirm('Anda yakin ingin menghapus data ?')){
		var p = document.createElement("input");
		var action = document.createElement("input");
		var actionType = document.createElement("input");
		 
	    // Add the new element to our form. 
	    form =document.getElementById('frmSearch');
	    form.appendChild(p);
	    p.name = "tid";
	    p.type = "hidden";
	    p.value = recId;
	    
	    form.appendChild(action);
	    action.name = "action";
	    action.type = "hidden";
	    action.value = "view_jadwal_atm";
	
	    form.appendChild(actionType);
	    actionType.name = "deleteaction";
	    actionType.type = "hidden";
	    actionType.value = "view_jadwal_atm_delete";
	    //alert(saveaction.value);
	    // Finally submit the form. 
	    form.submit();
		//document.getElementById('frmSearch').submit();
	}
}
</script>
</head>
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
$branch_desc=
$atmjadwal_isactive=
$msg=$action="";

$rNum=1;

$tid = "";
if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}

$mysqli = getConnection();

if (!empty($_POST["deleteaction"])){

	$delete_prep = "UPDATE m_atm_jadwal SET atmjadwal_isactive = 0 WHERE atmjadwal_id = ? ";
	$delete_stmt = $mysqli->prepare($delete_prep);

	if ($delete_stmt) {
		$delete_stmt->bind_param('i', $tid);
		// Execute the prepared query.
		if (! $delete_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menghapus data.');
				  </script>";
		}else echo "<script type='text/javascript'>
					alert('Data berhasil dihapus.');
				  </script>";
	}else {
		echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat menghapus data.');
				  </script>";

	}
}

?>
<body style="margin-top: 0px;margin-left: 0px;margin-right: 0px">
<form action="../atm/dashboard_atm.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch"> 
<div class="right">
<table >
	<tr>
		<td style="padding-left: 30px;padding-right: 30px">
			<div>
			<p style="font-family:monospace;font-weight: bolder;text-align: left;font-size: large; ">Jadwal Maintenance ATM</p>
			
			<hr>
				<table>
					<tr>
								<td align="left" valign="middle">
									<b>Search by :</b>
									<?php 
										$post=$txtSearch = "";
										$totalatm = 0;
										if (!empty($_POST['selectSearch'])) {
											$post = $_POST['selectSearch'];
										
											if (validateInput($_POST["txtSearch"]) <> "") {
												$txtSearch = $_POST["txtSearch"];
											}
										}
																			
										//unset var before reusing
										unset($select_prep,$select_stmt);
										
										$criteria=$txtSearchSQL = "";
										
										if(!empty($_POST["actioncari"]) || !empty($action)){
											if (validateInput($_POST["txtSearch"]) <> "") {
										
												switch ($post) {
													case "atmjadwal_tid":
														$criteria .= " AND atmjadwal_tid LIKE ?  ";
														break;
													case "atmjadwal_pic":
														$criteria .= " AND atmjadwal_pic LIKE ?  ";
														break;
							
													default:
														;
														break;
												}												
												$txtSearchSQL = "%".$txtSearch."%";
											}
										}
										$criteriaBranch = "";
										if ($logged == "in") {
											if ($isUker) {
												$criteriaBranch .= " AND atmjadwal_branch_id = ".$_SESSION['user_branch_code'];
											}
										}
										$select_stmt = getJadwalData($mysqli, $criteria,$txtSearchSQL,$criteriaBranch);							 
						 
									?>
									<select id="selectSearch" name="selectSearch">
									<option value="atmjadwal_tid" <?php if ($post == "atmjadwal_tid") { echo "selected"; }else echo "";?>>TID</option>
									<option value="atmjadwal_pic" <?php if ($post == "atmjadwal_pic") { echo "selected"; }else echo "";?>>PIC</option>	
									</select>
									<input type="text" id="txtSearch" name="txtSearch" value="<?php echo $txtSearch;?>" onkeydown="if (event.keyCode == 13) document.getElementById('btnCari').click()"/>
									<input type="button" value=" Cari" id="btnCari" name="btnCari" onclick="submitSearch();"/>
								</td>
	              			</tr>
				</table>
				<table class="tg" >
				  <tr>
				    <th class="tg-b286" style="text-align: center">No.</th>
				    <?php 
              			$strAction = "";
              			if ($logged == "in") {
              				$strAction .= '<th class="tg-b286" style="text-align: right">Edit</th>';
              				echo $strAction;
              				
              			}
              			?>
              		<th class="tg-b286" style="text-align: right" nowrap>TANGGAL</th>
              		<th class="tg-b286" style="text-align: right" nowrap>TID</th>
              		<th class="tg-b286" style="text-align: right" nowrap>KANCA</th>
				    <th class="tg-b286" style="text-align: right" nowrap>PIC</th>
				    <th class="tg-b286" style="text-align: left" nowrap>KETERANGAN</th>
				  </tr>
				  <?php 
				  if ($select_stmt->num_rows >= 1) {
				  
				  	$select_stmt->bind_result($atmjadwal_id,
												$atmjadwal_date,
												$atmjadwal_branch_id,
												$atmjadwal_tid,
												$atmjadwal_pic,
												$atmjadwal_keterangan,
												$atmjadwal_creadt,
												$atmjadwal_creausr,
												$atmjadwal_upddt,
												$atmjadwal_updusr,
												$branch_desc,
												$atmjadwal_isactive);
				  	while ($select_stmt->fetch()){
					
					switch ($atmjadwal_isactive) {
						case "0":
							$statusColor = "background-color:#FF3939";
							break;
						case "1":
							$statusColor = "background-color:#00FF00";
							break;
						default: $statusColor = "background-color:#FFFFFF";
					}

						$msg="";
						
						$strActionScript = "";
						if ($logged == "in") {
							$strActionScript .= '<td class="tg-031e" style="text-align: center">
													<a class="underline" href="javascript:updateAction('.$atmjadwal_id.');">
														<img src="../resource/pen.png" style="width:10px;height:10px"></img></a>
													<a class="underline" href="javascript:deleteAction('.$atmjadwal_id.');">
														<img src="../resource/delete_icon.png" style="width:10px;height:10px"></img></a>
												</td>';
						}
						
				  		$msg .= '<tr>
								    <td class="tg-031e" style="text-align: right">'.$rNum.'</td>
									'.$strActionScript.'
    								<td class="tg-031e" style="text-align: left">'.$atmjadwal_date.'</td>
								    <td class="tg-031e" style="text-align: left">'.$atmjadwal_tid.'</td>
									<td class="tg-031e" style="text-align: left">'.$branch_desc.'</td>
									<td class="tg-031e" style="text-align: left">'.$atmjadwal_pic.'</td>
    								<td class="tg-031e" style="text-align: left">'.$atmjadwal_keterangan.'</td>
								</tr>';
				  			
				  		$rNum += 1;
				  		
				  		echo $msg;
				  	}
				  }
				  
				  ?>
				</table>
			</div>
		</td>
	</tr>
</table>
<div align="right">
			<p
				style="font-weight: bold; margin-bottom: 0px; font-family: Consolas, Monaco, Courier New, Courier, monospace;">Electronic
				Payment Services</p>
			<hr />
			<img src="../resource/card_maestro.png" width="60" /> <img
				src="../resource/card_cirrus.png" width="60" /> <img
				src="../resource/card_link.png" width="60" /> <img
				src="../resource/card_visa.png" width="60" /> <img
				src="../resource/card_mastercard.jpg" width="60" />
		</div>
</div>
</form>
</body>
</html>
