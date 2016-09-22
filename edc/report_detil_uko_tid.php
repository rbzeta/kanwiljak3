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
$(function() {
	$( "#tabs" ).tabs({
		selected:0	});
});

</script>
</head>
<body>
<?php 
$edcuko_id=$edcuko_tid=$edcuko_mid=$edcuko_kodekanca=$edcuko_lokasi=
$edcuko_brand=$edcuko_sn=$edcuko_tglinisiasi=$edcuko_tglimplementasi=$tid=
$edcbrand_id=$edcbrand_nama=$branch_mbcode=$branch_mbname=$branch_code=$branch_name=$edcsp_no="";

if (!empty($_POST["tid"])){
	$tid = $_POST["tid"];
}
//$tid=21157335;

$mysqli = getConnection();

$select_prep = "SELECT edcuko_id,edcuko_tid,edcuko_mid,edcuko_kodekanca,edcuko_lokasi,
				edcuko_brand,edcuko_sn,edcuko_tglinisiasi,edcuko_tglimplementasi,edcsp_no,
				edcbrand_id,edcbrand_nama,branch_mbcode,branch_mbname,branch_code,branch_name
				FROM m_edc_uko
				LEFT JOIN m_edc_brand ON edcbrand_id = edcuko_brand
				LEFT JOIN m_branch ON branch_code = edcuko_kodekanca 
			    LEFT JOIN m_edc_sp ON edcsp_id = edcuko_sp_id 
				WHERE edcuko_tid = ? AND edcuko_isactive=1 LIMIT 1 ";

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
								$edcuko_brand,$edcuko_sn,$edcuko_tglinisiasi,$edcuko_tglimplementasi,$edcsp_no,
								$edcbrand_id,$edcbrand_nama,$branch_mbcode,$branch_mbname,$branch_code,$branch_name);
	
	$select_stmt->fetch();
}
?>
<div class="right">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="3">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="center" valign="middle"><h3 style="margin-top: 0px;">
									<b><?php echo $edcuko_lokasi?></b>
								</h3></td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td valign="top">
					<table width="100%" border="0" cellpadding="00">
						<tr>
							<td align="center" valign="top">
								<div id="tabs">
									<ul>
										<li><a href="#tabs-1" style="font-size: 12px;"><b>Profile</b></a></li>
										<li><a href="#tabs-2" style="font-size: 12px;"><b>Complaint</b></a></li>
										<li><a href="#tabs-3" style="font-size: 12px;"><b>Maintenance</b></a></li>
										<li><a href="#tabs-4" style="font-size: 12px;"><b>Penarikan</b></a></li>
									</ul>
									<div id="tabs-1">

										<table width="100%"
											style="font: 11px/20px normal Helvetica, Arial, sans-serif !important; margin: 10px 0 0 0;">
											<tr>
												<td valign="top" width="50%">
													<table width="100%" border="0" cellpadding="1"
														cellspacing="2">
														<tr>
															<td class="list_left">TID</td>
															<td class="list_right">: <?php echo $edcuko_tid?></td>
														</tr>
														<tr>
															<td class="list_left">MID</td>
															<td class="list_right">: <?php echo $edcuko_mid?></td>
														</tr>
														<tr>
															<td class="list_left">KANCA SUPERVISI</td>
															<td class="list_right">: <?php echo $edcuko_kodekanca.' - '.$branch_name?></td>
														</tr>
														<tr>
															<td class="list_left">LOKASI</td>
															<td class="list_right">: <?php echo $edcuko_lokasi?></td>
														</tr>
														<tr>
															<td class="list_left">MERK</td>
															<td class="list_right">: <?php echo $edcbrand_nama?></td>
														</tr>
														<tr>
															<td class="list_left">S/N MESIN</td>
															<td class="list_right">: <?php echo $edcuko_sn?></td>
														</tr>
														
														<tr>
															<td class="list_left">TGL IMPLEMENTASI</td>
															<td class="list_right">: <?php echo $edcuko_tglimplementasi?></td>
														</tr>
													</table>
												</td>
												<td valign="top">
													
												</td>
											</tr>
											
										</table>
									</div>
									<div id="tabs-2">
										<?php include 'report_detil_complaint_tid.php';?>
									</div>
									<div id="tabs-3">
										<table width="100%" border="0" cellpadding="1" cellspacing="0"
											class="prLBL3"
											style="margin: 10px 0; font: 11px/20px normal Helvetica, Arial, sans-serif !important;">
											<tr>
												<td align="center">- Tidak ada data -</td>
											</tr>
										</table>
									</div>
									<div id="tabs-4">
										<table width="100%" border="0" cellpadding="1" cellspacing="0"
											class="prLBL3"
											style="margin: 10px 0; font: 11px/20px normal Helvetica, Arial, sans-serif !important;">
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
</body>
</html>