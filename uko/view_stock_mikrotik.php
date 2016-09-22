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
<title>Portal BRI Kanwil Jakarta 3</title>
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
    action.value = "update_stock_mikrotik";
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
	    action.value = "view_stock_mikrotik";
	
	    form.appendChild(actionType);
	    actionType.name = "deleteaction";
	    actionType.type = "hidden";
	    actionType.value = "view_stock_mikrotik_delete";
	    //alert(saveaction.value);
	    // Finally submit the form. 
	    form.submit();
		//document.getElementById('frmSearch').submit();
	}
}
</script>
</head>
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
$stockmikrotik_startdt=
$stockmikrotik_enddt=
$stockmikrotik_pic=
$stockmikrotik_ippool=
$msg="";

$rNum=1;

$tid = "";
if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}

$mysqli = getConnection();

if (!empty($_POST["deleteaction"])){

	$delete_prep = "UPDATE m_stock_mikrotik SET stockmikrotik_isactive = 0 WHERE stockmikrotik_id = ? ";
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

//$mysqli = getConnection();

//unset var before reusing
unset($select_prep,$select_stmt);

$select_prep = " SELECT
stockmikrotik_id,
stockmikrotik_mikrotiksn,
stockmikrotik_modemsn,
stockmikrotik_provider,
stockmikrotik_simno,
stockmikrotik_status,
stockmikrotik_lokasi,
stockmikrotik_upddt,
stockmikrotik_updusr,
statusmikrotik_name,
edcprovider_nama,
stockmikrotik_startdt,
stockmikrotik_enddt,
stockmikrotik_pic,
stockmikrotik_ippool
FROM m_stock_mikrotik
LEFT JOIN m_status_mikrotik ON statusmikrotik_id = stockmikrotik_status
LEFT JOIN m_edc_provider ON edcprovider_id = stockmikrotik_provider
WHERE stockmikrotik_isactive = 1
ORDER BY stockmikrotik_status,stockmikrotik_upddt DESC ";

$select_stmt = $mysqli->prepare($select_prep);

if ($select_stmt) {
	
	$select_stmt->execute();
	$select_stmt->store_result();
	
}
?>
<body style="margin-top: 0px;margin-left: 0px;margin-right: 0px">
<form action="../uko/dashboard_uko.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch"> 
<div class="right">
<table >
	<tr>
		<td style="padding-left: 30px;padding-right: 30px">
			<div>
			<p style="font-family:monospace;font-weight: bolder;text-align: left;font-size: large; ">View Penggunaan Mikrotik</p>
			
			<hr>
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
				    <th class="tg-b286" style="text-align: right" nowrap>SN Mikrotik</th>
				    <th class="tg-b286" style="text-align: left" nowrap>SN Modem</th>
				    <th class="tg-b286" style="text-align: right" nowrap>No Simcard</th>
				    <th class="tg-b286" style="text-align: right" nowrap>Provider</th>
				    <th class="tg-b286" style="text-align: right" nowrap>Status</th>
				    <th class="tg-b286" style="text-align: right" nowrap>Lokasi</th>
				    <th class="tg-b286" style="text-align: right" nowrap>PIC</th>
				    <th class="tg-b286" style="text-align: right" nowrap>IP Pool</th>
				    <th class="tg-b286" style="text-align: right" nowrap>Tgl Mulai</th>
				    <th class="tg-b286" style="text-align: right" nowrap>Tgl Selesai</th>
		
				  </tr>
				  <?php 
				  if ($select_stmt->num_rows >= 1) {
				  
				  	$select_stmt->bind_result($stockmikrotik_id,
												$stockmikrotik_mikrotiksn,
												$stockmikrotik_modemsn,
												$stockmikrotik_provider,
												$stockmikrotik_simno,
												$stockmikrotik_status,
												$stockmikrotik_lokasi,
												$stockmikrotik_upddt,
												$stockmikrotik_updusr,
												$statusmikrotik_name,
												$edcprovider_nama,
												$stockmikrotik_startdt,
												$stockmikrotik_enddt,
												$stockmikrotik_pic,
												$stockmikrotik_ippool);
				  	while ($select_stmt->fetch()){

					switch ($statusmikrotik_name) {
						case "In Use":
							$statusColor = "background-color:#FF3939";
							break;
						case "Available":
							$statusColor = "background-color:#00FF00";
							break;
						default: $statusColor = "background-color:#FFFFFF";
					}

						$msg="";
						
						$strActionScript = "";
						if ($logged == "in") {
							$strActionScript .= '<td class="tg-031e" style="text-align: center">
													<a class="underline" href="javascript:updateAction('.$stockmikrotik_id.');">
														<img src="../resource/pen.png" style="width:10px;height:10px"></img></a>
													<a class="underline" href="javascript:deleteAction('.$stockmikrotik_id.');">
														<img src="../resource/delete_icon.png" style="width:10px;height:10px"></img></a>
												</td>';
						}
						
				  		$msg .= '<tr>
								    <td class="tg-031e" style="text-align: right">'.$rNum.'</td>
									'.$strActionScript.'
								    <td class="tg-031e" style="text-align: left">'.$stockmikrotik_mikrotiksn.'</td>
									<td class="tg-031e" style="text-align: left">'.$stockmikrotik_modemsn.'</td>
									<td class="tg-031e" style="text-align: left">'.$stockmikrotik_simno.'</td>
									<td class="tg-031e" style="text-align: left">'.$edcprovider_nama.'</td>
									<td class="tg-031e" style="text-align: center;'.$statusColor.'">'.$statusmikrotik_name.'</td>
									<td class="tg-031e" style="text-align: left">'.$stockmikrotik_lokasi.'</td>
						    		<td class="tg-031e" style="text-align: left">'.$stockmikrotik_pic.'</td>
									<td class="tg-031e" style="text-align: left">'.$stockmikrotik_ippool.'</td>
						    		<td class="tg-031e" style="text-align: left">'.$stockmikrotik_startdt.'</td>
									<td class="tg-031e" style="text-align: left">'.$stockmikrotik_enddt.'</td>
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
