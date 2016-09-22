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
    action.value = "view_master_sparepart_atm";
    
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
    action.value = "update_sparepart_atm";
    //alert(form+'xxx'+p.value);
    // Finally submit the form. 
    form.submit();
	//document.getElementById('frmSearch').submit();
	
}

function verifAction(recId){
	var keterangan = prompt("Keterangan TID " +recId);
	if (keterangan != null) {
		var p = document.createElement("input");
		var action = document.createElement("input");
		var actionType = document.createElement("input");
		var ket = document.createElement("input");
		
		 
	    // Add the new element to our form. 
	    form =document.getElementById('frmSearch');
	    form.appendChild(p);
	    p.name = "tid";
	    p.type = "hidden";
	    p.value = recId;

	    form.appendChild(ket);
	    ket.name = "update_keterangan";
	    ket.type = "hidden";
	    ket.value = keterangan;
	    
	    form.appendChild(action);
	    action.name = "action";
	    action.type = "hidden";
	    action.value = "view_verif_brilink_edc";
	
	    form.appendChild(actionType);
	    actionType.name = "deleteaction";
	    actionType.type = "hidden";
	    actionType.value = "view_verif_brilink_edc";
	    //alert(saveaction.value);
	    // Finally submit the form. 
	    form.submit();
		//document.getElementById('frmSearch').submit();
	}
	
}
</script>
</head>
<?php 
$edc_mid=
$edc_tid=
$lokasi=
$kode_uker_pemrakarsa=
$uker_pemrakarsa=
$kode_uker_implementor=
$uker_implementor=
$mainbr_pemrakarsa=
$brdesc_pemrakarsa=
$mainbr_implementor=
$brdesc_implementor=
$keterangan=
$msg=$action="";

$rNum=1;

$tid = "";
$update_keterangan = "";

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}

if (!empty($_POST["update_keterangan"])){
	$update_keterangan = $_POST["update_keterangan"];
}


$mysqli = getConnection();

if (!empty($_POST["deleteaction"])){

	$delete_prep = "UPDATE m_edc_brilink_verif SET keterangan = ? WHERE tid = ? ";
	$delete_stmt = $mysqli->prepare($delete_prep);

	if ($delete_stmt) {
		$delete_stmt->bind_param('si', $update_keterangan,$tid);
		// Execute the prepared query.
		if (! $delete_stmt->execute()) {
			echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat update data. [exec]');
				  </script>";
		}else echo "<script type='text/javascript'>
					alert('Data berhasil diupdate.');
				  </script>";
	}else {
		echo "<script type='text/javascript'>
					alert('Terjadi kesalahan saat update data. [qry]');
				  </script>";

	}
	echo $_POST["update_keterangan"];
}

?>
<body style="margin-top: 0px;margin-left: 0px;margin-right: 0px">
<form action="../edc/dashboard_edc.php" method="post" style="margin:0px;" id="frmSearch" name="frmSearch"> 
<div class="right">
<table >
	<tr>
		<td style="padding-left: 30px;padding-right: 30px">
			<div>
			<p style="font-family:monospace;font-weight: bolder;text-align: left;font-size: large; ">Verifikasi EDC BRILINK</p>
			
			<hr>
				<table>
					<tr>
								<!-- td align="left" valign="middle">
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
													case "atmpart_sn":
														$criteria .= " AND atmpart_sn LIKE ?  ";
														break;
												case "atmpart_source_tid":
														$criteria .= " AND atmpart_source_tid LIKE ?  ";
														break;
												case "atmpart_dest_tid":
														$criteria .= " AND atmpart_dest_tid LIKE ?  ";
														break;
												case "jenispart_name":
														$criteria .= " AND jenispart_name LIKE ?  ";
														break;
													
													default:
														;
														break;
												}												
												$txtSearchSQL = "%".$txtSearch."%";
											}
										}
										
										$select_stmt = getEDCBrilinkVerifikasi($mysqli, $criteria, $txtSearchSQL);
										 
										
										 
									?>
									<select id="selectSearch" name="selectSearch">
									<option value="select_uker_pemrakarsa" <?php if ($post == "select_uker_pemrakarsa") { echo "selected"; }else echo "";?>>Uker Pemrakarsa</option>					
									<option value="atmpart_source_tid" <?php if ($post == "atmpart_source_tid") { echo "selected"; }else echo "";?>>TID Sumber</option>					
									</select>
									<input type="text" id="txtSearch" name="txtSearch" value="<?php echo $txtSearch;?>" onkeydown="if (event.keyCode == 13) document.getElementById('btnCari').click()"/>
									<input type="button" value=" Cari" id="btnCari" name="btnCari" onclick="submitSearch();"/>
								</td-->
								
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
              			<th class="tg-b286" style="text-align: center" nowrap>MID</th>
				    <th class="tg-b286" style="text-align: center" nowrap>TID</th>
				    <th class="tg-b286" style="text-align: left" nowrap>LOKASI</th>
				    <th class="tg-b286" style="text-align: left" nowrap>UKER PEMRAKARSA</th>
				    <th class="tg-b286" style="text-align: right" nowrap>UKER IMPLEMENTASI</th>
				    <th class="tg-b286" style="text-align: right" nowrap>SUPERVISI</th>
				    <th class="tg-b286" style="text-align: right" nowrap>KETERANGAN</th>
		
				  </tr>
				  <?php 
				  if ($select_stmt->num_rows >= 1) {
				  
				  	$select_stmt->bind_result($edc_mid,
												$edc_tid,
												$lokasi,
												$kode_uker_pemrakarsa,
												$uker_pemrakarsa,
												$kode_uker_implementor,
												$uker_implementor,
												$mainbr_pemrakarsa,
												$brdesc_pemrakarsa,
												$mainbr_implementor,
												$brdesc_implementor,
												$keterangan);
				  	while ($select_stmt->fetch()){

					switch ($keterangan) {
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
													<a class="underline" href="javascript:verifAction('.$edc_tid.');">
														<img src="../resource/pen.png" style="width:10px;height:10px"></img></a>
												</td>';
						}
						
				  		$msg .= '<tr>
								    <td class="tg-031e" style="text-align: right">'.$rNum.'</td>
									'.$strActionScript.'
								    <td class="tg-031e" style="text-align: left">'.$edc_mid.'</td>
									<td class="tg-031e" style="text-align: left">'.$edc_tid.'</td>
									<td class="tg-031e" style="text-align: left">'.$lokasi.'</td>
									<td class="tg-031e" style="text-align: left">'.$kode_uker_pemrakarsa.' - '.$uker_pemrakarsa.'</td>
									<td class="tg-031e" style="text-align: left">'.$kode_uker_pemrakarsa.' - '.$uker_pemrakarsa.'</td>
    								<td class="tg-031e" style="text-align: left">'.$brdesc_pemrakarsa.'</td>
    								<td class="tg-031e" style="text-align: left">'.$keterangan.'</td>
    								
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
